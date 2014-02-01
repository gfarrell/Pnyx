<?php
class Policy extends mBase {
    public static $timestamps = false;

    public function rescindedBy() {
        return $this->belongs_to('Policy', 'rescinded_by');
    }

    public function renewedBy() {
        return $this->belongs_to('Policy', 'renewed_by');
    }

    public function rescinds() {
        return $this->has_many('Policy', 'rescinded_by');
    }

    public function renews() {
        return $this->has_many('Policy', 'renewed_by');
    }

    public function relatesTo() {
        return $this->has_many('Policy', 'rescinded_by')->or_where('renewed_by', '=', $this->id);
    }

    public function afterSave() {
        Policy::index($this);
    }

    public static function index($policy) {
        $index_fields = array('title', 'notes', 'believes', 'resolves');

        // Set up indices
        // Existing records have existing indices, so update them
        $indices = DB::table('policy_indices')->where_policy_id($policy->id)->get();
        if(is_array($indices) && count($indices) > 0) {
            foreach($indices as $index) {
                $field = $index->field_name;
                $i = array_search($field, $index_fields);
                if($i !== false) {
                    DB::table('policy_indices')
                            ->where('id', '=', $index->id)
                            ->update(array(
                                'data'=>$policy->{$field}
                                )
                            );
                    // we'll have to deal with unindexed fields (if any)
                    unset($index_fields[$i]);
                } else {
                    DB::table('policy_indices')->delete($index->id);
                }
            }
            //$qIndex->update($indices);
        }

        // Now process the remaining fields
        // For new records this will be all of them
        if(count($index_fields) > 0) {
            $indices = array();
            foreach($index_fields as $field) {
                array_push($indices, array(
                    'policy_id'  => $policy->id,
                    'field_name' => $field,
                    'data'       => $policy->$field
                ));
            }
            DB::table('policy_indices')->insert($indices);
        }
    }

    public static function deleteIndices($policy_id) {
        DB::table('policy_indices')
                ->where('policy_id', '=', $policy_id)
                ->delete();
    }

    public static function search($query) {
        // Need to search title, notes, believes, resolves and keywords
        // Weighting as follows:
        //  title                       => 33% (so approx x3)
        //  notes, believes + resolves  => 66% (22% each so approx x2)
        //  and here is the super query that achieves this

        $results = DB::query(<<<EOT
SELECT 
        Policy.title, Policy.id, Policy.date,
        Policy.votes_for, Policy.votes_against, Policy.votes_abstain,
        SUM(IndexWeight.multiplier * (MATCH(data) AGAINST('$query'))) AS score
FROM
        policy_indices AS pIndex
LEFT JOIN
        policies AS Policy
        ON (pIndex.policy_id = Policy.id)
LEFT JOIN
        index_weights AS IndexWeight
        ON (pIndex.field_name = IndexWeight.field_name)
WHERE
    MATCH(data) AGAINST('$query')
GROUP BY pIndex.policy_id
ORDER BY score DESC
EOT
            );

        // Now make them into Policy objects
        $policies = array();
        foreach($results as $result) {
            $policies[] = new Policy((array)$result);
        }
        return $policies;
    }

    public static function cleanData($data) {
        $direct_fields = array('title','date','notes','believes','resolves','votes_for','votes_against','votes_abstain');

        $new_data = Set::get($data, $direct_fields);

        // Fix any date problems
        $new_data['date'] = date('Y-m-d', strtotime($data['date']));

        // Deal with prop / sec
        $people = Set::get($data, array('proposed','seconded'));
        foreach($people as $type => $p) {
            $u = Ravenly\Models\User::lookup($p);
            $new_data[$type] = is_null($u) ? $p : $u['name'];
        }

        return $new_data;
    }

    public static function makeFromArray($data) {
        // Get clean data
        $data_extract = Policy::cleanData($data);

        // Save data fields
        $policy = Policy::create($data_extract);

        // Save relationships
        $policy->savePolicyRelationships($data);

        if($policy) {
            return $policy->id;
        } else {
            return false;
        }
    }

    public function savePolicyRelationships($data) {
        // TODO: implement one-to-many relationships (ie an array)
        if(isset($data['child_id']) && intval($data['child_id']) > 0) {
            // clear previous
            $this->renews()->first()->fill(array('renewed_by'=>null))->save();
            $this->rescinds()->first()->fill(array('rescinded_by'=>null))->save();

            // set
            $p = Policy::find(intval($data['child_id']));
            if($data['child_action'] == 'renew') {
                $p->renewed_by = $this->id;
            } else if($data['child_action'] == 'rescind') {
                $p->rescinded_by = $this->id;
            }
            $p->save();
        }
    }

    public function didPass() {
        $votes = array('votes_for','votes_against');
        $majority = '';
        $max = 0;

        foreach($votes as $key) {
            if(strtolower($this->$key) == 'm') {
                $vote_int = 0;
                $majority = $key;
                break;
            } elseif($this->$key != '') {
                $vote_int = intval($this->$key);
            } else {
                $vote_int = 0;
            }

            if($vote_int > $max) {
                $max = $vote_int;
                $majority = $key;
            }
        }

        return ($majority == 'votes_for');
    }

    public function isCurrent() {
        $now = time();
        return ($now < $this->expires());
    }

    public function isRescinded() {
        return !is_null($this->rescinded_by) && $this->rescindedBy->didPass();
    }

    public function wasRenewed() {
        return !is_null($this->renewed_by) && $this->renewedBy->didPass();
    }

    public function expires() {
        // Full Michaelmas term is defined to start on the 1st of October
        // KCSU Policy is set to last X years, including the year in which
        // it was passed
        // Therefore to calculate expiry, we need to see if we are outside X
        // year from the NEXT 1st october
        $then = strtotime($this->date);
        $policy_date = array('y'=>intval(date('Y', $then)), 'm'=>intval(date('m', $then)));

        $start_year = ($policy_date['m'] < 10) ? $policy_date['y'] : $policy_date['y'] + 1;
        $expiry_year = $start_year + Config::get('pnyx.policy_lifetime');
        return strtotime($expiry_year . '-' . '10-01'); // YYYY-10-01
    }

    public function votes($what) {
        $votes = array('for', 'against', 'abstain');
        $result = 'uncounted';

        if(in_array($what, $votes)) {
            $what = 'votes_' . $what;
            $vote = $this->$what;
            if(strtolower($vote) == 'm') {
                $result = 'majority';
            } elseif($vote != '') {
                $result = $vote;
            }
        } else {
            throw new Exception('Invalid vote type "' . $what . '".');
        }

        return $result;
    }
}

// EVENTS

Event::listen('eloquent.deleting: Policy', function($policy) { Policy::deleteIndices($policy->id); });

?>
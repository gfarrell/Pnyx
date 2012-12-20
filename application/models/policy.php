<?php
class Policy extends mBase {
    public static $timestamps = false;

    public static function cleanData($data) {
        $direct_fields = array('title','date','notes','believes','resolves','votes_for','votes_against','votes_abstain','review_flag');

        $data = Set::get($data, $direct_fields);

        // Fix any date problems
        $data['date'] = date('Y-m-d', strtotime($data['date']));

        // Deal with prop / sec
        $people = Set::get($data, array('proposed','seconded'));
        foreach($people as $type => $p) {
            if(User::validateCrsid($p)) {   // Only lookup if it is a CRSID
                $u = User::lookup($p);
                $data[$type] = is_null($u) ? $p : $u['name'];
            }
        }

        return $data;
    }

    public static function makeFromArray($data) {
        // Get clean data
        $data_extract = Policy::cleanData($data);

        // Save data fields
        $policy = Policy::create($data_extract);

        // Process tags
        $policy->saveTags(explode(',', $data['raw_tags']));

        return $policy->id;
    }

    public function saveTags($tags) {
        // Deal with tags
        // First create all non-existent tags
        Tag::createNonexistent($tags);
        // Now get all the tags specified
        $spec_tags = Tag::where_in('name', $tags)->get('id');
        $tag_ids = array_map(function($t) { return $t->id; }, $spec_tags);
        // Sync!
        $this->tags()->sync($tag_ids);
    }

    public function tags() {
        return $this->has_many_and_belongs_to('Tag');
    }

    public function tags_raw() {
        $tags = $this->tags()->get();
        $names = array();

        foreach($tags as $t) {
            array_push($names, $t->name);
        }

        return implode(',', $names);
    }

    public function didPass() {
        $votes = array('votes_for','votes_against');
        $majority = '';
        $max = 0;

        foreach($votes as $key) {
            if(strtolower($this->$key) == 'm') {
                $vote_int = 0;
                $majority = $key;
            } elseif($this->$key != '') {
                $vote_int = intval($this->$key);
            } else {
                $vote_int = 0;
            }

            if($vote_int > $max) {
                $max = $vote_int;
                if($majority == '') {
                    $majority = $key;
                }
            }
        }

        return ($majority == 'votes_for');
    }

    public function isCurrent() {
        $now = time();
        return ($now < $this->expires());
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
            }
        } else {
            throw new Exception('Invalid vote type "' . $what . '".');
        }

        return $result;
    }
}
?>
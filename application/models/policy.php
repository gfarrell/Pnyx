<?php
class Policy extends mBase {
    public static $timestamps = false;

    public static function makeFromArray($data) {
        $direct_fields = array('title','date','notes','believes','resolves','votes_for','votes_against','votes_abstain','review_flag');

        $data_extract = Set::get($data, $direct_fields);

        // Fix any date problems
        $data_extract['date'] = date('Y-m-d', strtotime($data_extract['date']));

        // Deal with prop / sec
        $people = Set::get($data, array('proposed','seconded'));
        foreach($people as $type => $p) {
            $u = User::lookup($p);
            $data_extract[$type] = is_null($u) ? $p : $u['name'];
        }

        // Save data fields
        $policy = Policy::create($data_extract);

        // Deal with tags
        // First create all non-existent tags
        $tags = explode(',', $data['tags']);
        Tag::createNonexistent($tags);
        // Now get all the tags specified
        $spec_tags = Tag::where_in('name', $tags)->get('id');
        $tag_ids = array_map(function($t) { return $t->id; }, $spec_tags);
        // Sync!
        $policy->tags()->sync($tag_ids);

        return $policy->id;
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
<?php
class Tag extends mBase {
    public static function createNonexistent($tags) {
        $tags = array_map(function($t) { return strtolower($t); }, $tags);
        $existing = Tag::where_in('name', $tags)->get('name');

        $existing = array_map(function($t) { return $t->name; }, $existing);

        $insert = array();
        foreach($tags as $tag) {
            if($tag != '' && !in_array($tag, $existing)) {
                array_push($insert, array('name'=>$tag));
            }
        }
        if(count($insert) > 0) {
            Tag::insert($insert);
        }
    }
}
?>
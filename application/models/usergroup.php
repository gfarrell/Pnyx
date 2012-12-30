<?php
class UserGroup extends mBase {
    function user() {
        return $this->has_many('User', 'group_id');
    }
}
?>
<?php

class User extends mBase {
    public function group() {
        return $this->belongs_to('UserGroup');
    }

    public function isAdmin() {
        return ($this->group->name == 'admin');
    }

    public function isAuthorised() {
        return (bool) $this->in_kings;
    }
}

?>
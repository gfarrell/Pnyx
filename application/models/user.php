<?php

class User extends mBase {
    public static function validateCrsid($crsid) {
        return (bool) preg_match('/(\w+)(\d+)/', $crsid);
    }

    public static function lookup($crsid) {
        $u = LDAP::search($crsid, 'uid');
        
        return count($u) > 0 ? $u[0] : null;
    }

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
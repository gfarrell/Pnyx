<?php

class Policy_Controller extends Base_Controller {
    public function __construct() {
        $this->filter('before', 'auth');
    }

    public function action_index() {}
    public function action_add() {}
    public function action_edit() {}
    public function action_delete() {}
}

?>
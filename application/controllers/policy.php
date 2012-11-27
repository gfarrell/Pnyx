<?php

class Policy_Controller extends Base_Controller {
    public $restful = true;

    public function __construct() {
        $this->filter('before', 'auth');
    }

    public function get_index() {}
    public function get_add() {}
    public function get_edit($id) {
        $policy = Policy::find($id);

        return View::make('policy.edit')
                ->with(array(
                    'policy' => $policy
                ));
    }
    public function delete_delete() {}
}

?>
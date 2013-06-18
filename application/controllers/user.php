<?php

use Ravenly\Models\User;
use Ravenly\Models\UserGroup;

class User_Controller extends Base_Controller {
    public $restful = true;

    public function __construct() {
        $this->filter('before', 'raven');
        $this->filter('before', 'raven:group', array('admin'));
    }

    public function get_edit($crsid) {
        $user = User::where_crsid($crsid)->first();
        $groups = UserGroup::all();
        return View::make('user.edit')->with(array('user'=>$user, 'groups'=>$groups));
    }
    public function put_edit() {

    }
}
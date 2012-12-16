<?php

class Policy_Controller extends Base_Controller {
    public $restful = true;

    public function __construct() {
        $this->filter('before', 'auth');
    }

    public function get_index() {
        $policies = Policy::order_by('date', 'DESC')->paginate(25, array('title','date','votes_for','votes_against','votes_abstain'));

        return Request::ajax() ? Response::eloquent($policies) : View::make('policy.index')->with(array('policies'=>$policies));
    }

    public function get_view($id=null) {
        $policy = Policy::find($id);
        if(!$policy) return Response::error(404);

        return Request::ajax() ? Response::eloquent($policy) : View::make('policy.view')->with(array('policy'=>$policy));
    }

    public function get_add() {
        return View::make('policy.edit');
    }
    public function get_edit($id=null) {
        $policy = Policy::find($id);

        if(is_null($id) || is_null($policy)) {
            return Redirect::to('policy/add');
        }

        return View::make('policy.edit')
                ->with(array(
                    'policy' => $policy
                ));
    }
    public function post_add() {
        $id = Policy::makeFromArray(Input::all());
        return Redirect::to('policy/view/'.$id);
    }
    public function put_edit() {}

    public function delete_delete() {}
}

?>
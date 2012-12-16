<?php

class Policy_Controller extends Base_Controller {
    public $restful = true;

    public function __construct() {
        $this->filter('before', 'auth');
    }

    /**
     * GET index
     * Displays an index of motions.
     * 
     */
    public function get_index() {
        $policies = Policy::order_by('date', 'DESC')->paginate(25, array('id', 'title','date','votes_for','votes_against','votes_abstain'));

        return Request::ajax() ? Response::eloquent($policies) : View::make('policy.index')->with(array('policies'=>$policies));
    }

    /**
     * GET view
     * View an individual policy.
     * 
     * @param int $id policy id
     */
    public function get_view($id=null) {
        $policy = Policy::find($id);
        if(!$policy) return Response::error(404);

        return Request::ajax() ? Response::eloquent($policy) : View::make('policy.view')->with(array('policy'=>$policy));
    }

    /**
     * GET add
     * Add a new policy.
     * 
     */
    public function get_add() {
        return View::make('policy.edit');
    }

    /**
     * GET edit
     * Edit an existing policy.
     * 
     * @param int $id policy id
     */
    public function get_edit($id=null) {
        $policy = Policy::find($id);

        if(is_null($id) || is_null($policy)) {
            return Redirect::to('policy/add');
        }

        Input::replace($policy->attributes);

        return View::make('policy.edit')
                ->with(array(
                    'policy' => $policy
                ));
    }

    /**
     * POST add
     * Processes a new motion.
     * 
     */
    public function post_add() {
        $id = Policy::makeFromArray(Input::all());
        return Redirect::to('policy/view/'.$id);
    }

    /**
     * PUT edit
     * Saves changes to a motion.
     * 
     */
    public function put_edit() {
        $id = Input::get('id');
        $policy = Policy::find($id);

        if(is_null($id) || is_null($policy)) {
            return Redirect::to('policy/add')->with('alert_error', 'No such Policy document exists with id '.$id.'. You can create one below.')->with_input();
        }

        $data = Policy::cleanData(Input::all());
        Policy::update($id, $data);

        $policy->saveTags(explode(',',Input::get('raw_tags')));

        return Redirect::to('policy/edit/'.$id);
    }

    public function delete_delete() {}
}

?>
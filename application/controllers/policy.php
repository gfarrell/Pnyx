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
        if(!$policy) {
            Session::flash('alert_error', "No Policy document with id $id exists.");
            return Response::error(404);
        }

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
            return Redirect::to('policy/add')->with('alert_error', 'No such Policy document exists with id '.$id.'. You can create one below.');
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
        Session::flash('alert_success', 'Policy document successfully created.');
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
        $policy->fill($data);
        $policy->save();

        $policy->saveTags(explode(',',Input::get('raw_tags')));

        Session::flash('alert_success', 'Changes saved.');

        return $this->get_edit($id);
    }

    public function delete_delete() {}

    public function get_search() {
        $query = Input::get('query');
        if(!is_null($query)) {
            $policies = Policy::search($query);
        } else {
            $policies = array();
        }

        return Request::ajax() ? Response::eloquent($policies) : View::make('policy.search')->with(array('policies'=>$policies, 'query'=>$query));
    }
}

?>
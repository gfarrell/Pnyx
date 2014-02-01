<?php

class Policy_Controller extends Base_Controller {
    public $restful = true;

    public $validation = array(
        'title'         =>  'required',
        'date'          =>  'required',
        'notes'         =>  'required|min:50',
        'believes'      =>  'required|min:50',
        'resolves'      =>  'required|min:50',
        'votes_for'     =>  'min:0',
        'votes_against' =>  'min:0',
        'votes_abstain' =>  'min:0'
    );

    public function __construct() {
        $this->filter('before', 'raven')->except(array('add', 'edit', 'delete'));
        $this->filter('before', 'raven:group', array('admin'))->only(array('add', 'edit', 'delete'));
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
     * GET current
     * Displays all current policy.
     * 
     */
    public function get_current() {
        // To get all policy that is current, it must have both passed and not expired
        
        $policies = Policy::order_by('date', 'desc')
                            ->where(function($query) {
                                $query->where('votes_for', '=', 'm');
                                $query->or_where('votes_for', '>', DB::raw('`votes_against`')); // have to do this escapism of the second field otherwise Laravel treats it as a string value, not a field.
                            })
                            ->where('votes_against', '!=', 'm')
                            ->where('date', '>', PNYX_POLICY_UPPER_DATE) // don't need to transform dates
                            ->get();
        return Request::ajax() ? Response::eloquent($policies) : View::make('policy.current')->with('policies', $policies);
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
        // $validation = Validator::make($input = Input::get(), $this->validation);

        // if ($validation->fails()) {
        //     return Redirect::to('policy/add')->with_errors($validation)->with_input(Input::get());
        // }

        $id = Policy::makeFromArray(Input::all());
        if($id) {
            Session::flash('alert_success', 'Policy document successfully created.');
            return Redirect::to('policy/view/'.$id);
        } else {
            Session::flash('alert_error', 'Policy creation failed!');
            return View::make('policy.edit');
        }
    }

    /**
     * PUT edit
     * Saves changes to a motion.
     * 
     */
    public function put_edit() {
        $id = Input::get('id');
        
        // $validation = Validator::make($input = Input::get(), $this->validation);

        // if ($validation->fails()) {
        //     return Redirect::to('policy/edit/'.$id)->with_errors($validation)->with_input(Input::get());
        // }

        $policy = Policy::find($id);

        if(is_null($id) || is_null($policy)) {
            return Redirect::to('policy/add')->with('alert_error', 'No such Policy document exists with id '.$id.'. You can create one below.')->with_input();
        }

        $data_extract = Policy::cleanData(Input::all());
        $policy->fill($data_extract);
        $policy->save();
        $policy->savePolicyRelationships(Input::all());

        Session::flash('alert_success', 'Changes saved.');

        return $this->get_edit($id);
    }

    public function delete_delete() {
        $id = Input::get('id');
        $policy = Policy::find($id);

        if(!$policy) {
            Session::flash('alert_error', "No Policy document with id $id exists, so I cannot delete it.");
            return Redirect::back();
        } else {
            $title = $policy->title;
            // Delete all indices
            DB::table('policy_indices')->where('policy_id', '=', $policy->id)->delete();
            // Now delete policy
            $policy->delete();
            Session::flash('alert_success', 'Policy document "'. $title .'" successfully deleted.');
            return Redirect::to('policy/index');
        }
    }

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
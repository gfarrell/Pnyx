<?php

class Admin_Controller extends Base_Controller {
    public $restful = true;

    public function __construct() {
        $this->filter('before', 'raven:group', array('admin'));
    }

    public function get_index() {
        // Load users
        $groups = UserGroup::all();
        $groups_list = array();
        foreach($groups as $group) {
            $groups_list[$group->id] = $group->name;
        }

        // Build view
        return View::make('admin.index')
                ->with('users', User::all())
                ->with('groups', $groups)
                ->with('groups_list', $groups_list)
                ->with('index_weights', DB::table('index_weights')->get());
    }

    public function post_user() {
        // Create new user
        $user = User::create(Set::get(Input::all(), 'crsid'));

        // Add groups if specified
        $groups = Input::get('groups');
        $user->groups()->sync($groups);

        return Response::eloquent($user);
    }

    public function put_user() {
        // Update user
        $user = User::find(Input::get('id'));

        // Only groups are editable anyway
        $groups = Input::get('groups');
        $user->groups()->sync($groups);

        Return Response::eloquent($user);
    }
}
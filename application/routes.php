<?php

use Ravenly\Models\User;
use Ravenly\Models\UserGroup;

Route::get('/', array('before'=>'raven', function()
{
	return View::make('home.index')
                ->with('latest_policies', Policy::order_by('date', 'desc')->take(5)->get());
}));

Route::get('/admin', array('before'=>'raven', function() {
    if(!Ravenly::user()->inGroup('admin')) {
        return Response::error(403);
    }

    $groups = UserGroup::all();
    $groups_list = array();
    foreach($groups as $group) {
        $groups_list[$group->id] = $group->name;
    }
    return View::make('home.admin')
            ->with('users', User::all())
            ->with('groups', $groups)
            ->with('groups_list', $groups_list)
            ->with('index_weights', DB::table('index_weights')->get());
}));

Route::controller('policy');

/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});
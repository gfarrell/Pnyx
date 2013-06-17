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
Route::get('/tags.json/(:any)', function($query) {
    $query = Input::get('q');
    $tags = Tag::where('name', 'LIKE', '%'.$query.'%')->take(10)->get();
    /*
        FOR SOME F*ING REASON THIS RETURNS ALL THE RESULTS, EVEN WHEN THE SQL QUERY WORKS PROPERLY
        WTF!
     */
    return Response::eloquent($tags); // Return JSON'd model
});

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

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Router::register('GET /', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('before', function()
{
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
    if(isset($_SERVER['REMOTE_USER'])) {
        $user = User::where_crsid($_SERVER['REMOTE_USER'])->first();
        if($user) {
            Auth::login($user->id);
            if($user->isAuthorised()) {
                return;
            }
        }

        return Response::error('403'); // Failed login
    } else {
    	if (Auth::guest()) return Redirect::to('login');
    }
});
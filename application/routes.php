<?php

use Ravenly\Models\User;
use Ravenly\Models\UserGroup;

Route::get('/', array('before'=>'raven', function()
{
    // all policy created between october four years previously and three years previously will expire this year in october
    $now = array('m'=>intval(date('m')), 'y'=>intval(date('Y')));
    // find low and high years
    $low_y = $now['y'] - Config::get('pnyx.policy_lifetime');
    if($now['m'] > 10) {
        $low_y = $low_y + 1;
    }

	return View::make('home.index')
                ->with(array(
                    'latest_policies'   => Policy::order_by('date', 'desc')->take(5)->get(),
                    'expiring_policies' => Policy::order_by('date', 'desc')->where_between('date', $low_y.'-10-01', ($low_y+1).'-10-01')->get()
                ));
}));

Route::controller('admin');

Route::controller('policy');
Route::controller('user');

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
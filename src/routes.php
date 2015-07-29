<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::controllers([
    'auth' => 'Crtek\Authenticator\AuthController',
    'password' => 'Crtek\Authenticator\PasswordController',
]);

Route::get(config('Authenticator.login_page'), function() {
    return view('Authenticator::login')->with('url', config('Authenticator.auth_url'));
});

Route::get(config('Authenticator.logout'), function() {
    return $this->app['authenticator']->logout();
});

Route::get(config('Authenticator.login_redirect'), function() {
    $user = Crtek\Authenticator\Models\User::find(\Auth::id());
    return view('Authenticator::dashboard')->with('user', $user);
});

Route::get(config('Authenticator.auth_url').'/{provider?}', function($provider = null) {
    return $this->app['authenticator']->login($provider);
});

Route::post(config('Authenticator.auth_url').'/{provider?}', [/*'middleware' =>'jwtAuth',*/ function($provider = null, Request $request) {
	//if the api has a different redirect uri socialite should use it
	if(Request::has('redirectUri')){
		Config::set('services.'.$provider.'.redirect', Request::input('redirectUri'));
	}
    return $this->app['authenticator']->login($provider, true);
}]);
/*dummy soute for satellizer cal*/
Route::get(config('Authenticator.auth_api_url').'/{provider?}', function(){exit();});
// API Routes.
Route::get(config('Authenticator.auth_api_url').'/me', ['middleware' => 'jwtAuth', function() {
	$user =  Auth::User();
    return $user;
}/*'uses' => 'Bernardino\Authenticator\ApiController@getUser'*/]);
Route::put(config('Authenticator.auth_api_url').'/me', ['middleware' => 'jwtAuth', 'uses' => 'Crtek\Authenticator\ApiController@update']);

Route::get('activate/{code}', 'Crtek\Authenticator\AuthController@accountIsActive');

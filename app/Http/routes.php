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

/*Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
*/
Route::get('/', function(){
    return redirect('dashboard');
});

Route::get('dashboard/login', ['uses' => 'DashboardController@login','middleware' => 'guest', 'as' => 'dashboard_login']);
Route::post('dashboard/login', 'DashboardController@postLogin');

Route::group(['prefix' => 'dashboard', 'middleware' => 'auth'], function()
{
    Theme::set('dashboard_default');

	Route::get('/', ['uses' => 'DashboardController@index', 'as' => 'dashboard']);

    /*Route::get('change_password', ['uses' => 'UserController@changePassword', 'as' => 'change_password']);
    Route::post('change_password', ['uses' => 'UserController@postChangePassword', 'as' => 'change_password']);*/

	Route::get('logout', 'DashboardController@logout');

    
    /*Route::get('settings', [ 'uses' => 'SettingController@index', 'as' => 'settings']);
    Route::post('settings', 'SettingController@update');*/

    Route::resource('procurement', 'ProcurementController');

    /*Route::group(['prefix' => 'procurement'], function()
    {
        Route::get('/', ['uses' => 'ProcurementController@index', 'as' => 'procurement']);
        Route::get('add', ['uses' => 'ProcurementController@create', 'as' => 'create_procurement']);
        Route::post('add', ['uses' => 'ProcurementController@store', 'as' => 'add_procurement']);

        Route::resource('procurement', 'ProcurementController');


    });*/

	/*Route::group(['prefix' => 'users'], function()
	{
        Route::resource('roles', 'RoleController');
        Route::get('profile', ['uses' => 'UserController@profile']);
    });*/
});
/*Route::group(['prefix' => 'roles', 'middleware' => 'role:kepegawaian'], function() {
    Route::get('/', ['uses' => 'RoleController@index', 'as' => 'role_index']);
    Route::post('/', ['uses' => 'RoleController@store']);
});*/

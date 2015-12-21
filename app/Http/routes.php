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

    Route::get('change_password', ['uses' => 'UserController@changePassword', 'as' => 'change_password']);
    Route::post('change_password', ['uses' => 'UserController@postChangePassword', 'as' => 'change_password']);

	Route::get('logout', 'DashboardController@logout');

    
    /*Route::get('settings', [ 'uses' => 'SettingController@index', 'as' => 'settings']);
    Route::post('settings', 'SettingController@update');*/

    Route::post('procurement/{id}', ['uses' => 'ProcurementController@changeStatus']);
    Route::get('procurement/purchase_order/{id}', ['uses' => 'ProcurementController@purchaseOrder', 'as' => 'dashboard.procurement.purchase_order']);

    Route::get('procurement/datatables/{id}', ['uses' => 'ProcurementController@datatables', 'as' => 'procurement.datatables']);
    Route::put('procurement/updateItem/{id}', ['uses' => 'ProcurementController@updateItem', 'as' => 'procurement.datatables.edit']);
    Route::post('procurement/addItem/{id}', ['uses' => 'ProcurementController@addItem', 'as' => 'procurement.datatables.add']);
    Route::post('procurement/removeItem/{id}', ['uses' => 'ProcurementController@removeItem', 'as' => 'procurement.datatables.remove']);


    Route::post('procurement/printPO/{id}', ['uses' => 'ProcurementController@printPO']);
    Route::post('procurement/uploadInvoice/{id}', ['uses' => 'ProcurementController@uploadInvoice']);
    Route::resource('procurement', 'ProcurementController');

    /*Route::group(['prefix' => 'procurement'], function()
    {
        Route::get('/', ['uses' => 'ProcurementController@index', 'as' => 'procurement']);
        Route::get('add', ['uses' => 'ProcurementController@create', 'as' => 'create_procurement']);
        Route::post('add', ['uses' => 'ProcurementController@store', 'as' => 'add_procurement']);
        Route::resource('procurement', 'ProcurementController');
    });*/

    //Route::get('memo/create', ['uses' => 'MemoController@create', 'as' => 'dashboard.memo.create']);
    Route::resource('memo', 'MemoController');

    Route::get('profile', ['uses' => 'UserController@profile']);
    Route::resource('users', 'UserController');
    //Route::get('exportIntra', ['uses' => 'UserController@exportFromIntra']);
    Route::get('insertNim', ['uses' => 'UserController@insertNim']);


	/*Route::group(['prefix' => 'users'], function()
	{
        Route::resource('roles', 'RoleController');
        Route::resource('/', 'UserController');
        Route::get('profile', ['uses' => 'UserController@profile']);
    });*/
});
/*Route::group(['prefix' => 'roles', 'middleware' => 'role:kepegawaian'], function() {
    Route::get('/', ['uses' => 'RoleController@index', 'as' => 'role_index']);
    Route::post('/', ['uses' => 'RoleController@store']);
});*/


/*Event::listen('illuminate.query', function($query)
{
    var_dump($query);
});*/
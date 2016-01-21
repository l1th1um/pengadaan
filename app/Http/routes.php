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

Route::get('show_agenda',['uses' => 'AgendaController@showAgenda', 'as' => 'show_agenda']);
Route::get('show_announcement/{id}',['uses' => 'AnnouncementController@showAnnouncement', 'as' => 'show_announcement']);

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

    Route::resource('memo', 'MemoController');

    Route::get('profile', ['uses' => 'UserController@profile']);
    Route::resource('users', 'UserController');

    Route::get('forwarded_memo_item', ['uses' => 'MemoController@forwarded_memo', 'as' => 'memo.forwarded.index']);

    Route::get('print_memo/{id}', ['uses' => 'MemoController@printMemo', 'as' => 'dashboard.memo.printMemo']);
    Route::get('memo/datatables/{id}', ['uses' => 'MemoController@datatables', 'as' => 'memo.datatables']);
    Route::put('memo/updateItem/{id}', ['uses' => 'MemoController@updateItem', 'as' => 'memo.datatables.edit']);
    Route::post('memo/addItem/{id}', ['uses' => 'MemoController@addItem', 'as' => 'memo.datatables.add']);
    Route::post('memo/removeItem/{id}', ['uses' => 'MemoController@removeItem', 'as' => 'memo.datatables.remove']);
    Route::get('memo/autocomplete', ['uses' => 'MemoController@autocomplete_catalog', 'as' => 'dashboard.memo.autocomplete']);
    Route::get('memo/process/{id}', ['uses' => 'MemoController@processMemo', 'as' => 'dashboard.memo.process']);
    Route::post('memo/update_status/{id}', ['uses' => 'MemoController@updateMemoStatus', 'as' => 'dashboard.memo.update_status']);

    Route::get('memo_item/{id}/status', ['uses' => 'MemoController@editItemStatus', 'as' => 'memo.item.status']);

    Route::delete('memo_item/{id}', ['uses' => 'MemoController@itemDestroy', 'as' => 'memo.item.destroy']);

    Route::resource('announcement', 'AnnouncementController');
    Route::resource('agenda', 'AgendaController');

});

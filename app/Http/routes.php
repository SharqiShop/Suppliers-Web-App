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

Route::auth();


Route::get('/', 'HomeController@index');




Route::get('supplier/add', 'HomeController@newSupplier');
Route::post('supplier/save', 'HomeController@saveSupplier');
Route::get('/update/{orderid}', 'HomeController@updateSupplier');

Route::get('/invoice/{orderid}', 'HomeController@showInvoice');

Route::get('/stock', 'HomeController@showProducts');
Route::get('pro/disable', 'HomeController@disable');
Route::get('pro/enable', 'HomeController@enable');



Route::get('/orders', 'HomeController@showOrder');
Route::get('order/status', 'HomeController@orderStatus');
Route::get('order/action', 'HomeController@action');
Route::get('order/refund', 'HomeController@refund');
Route::get('/onhold', 'HomeController@showOnHold');

Route::resource('/api/orders', 'OrderController');
Route::resource('/api/items', 'ItemController');


Route::get('/items/{orderid}', 'HomeController@showitems');
Route::get('item/action', 'HomeController@itemAction');

Route::get('/accounting/trans','AccountingController@showTransaction');
Route::get('/accounting/cost','AccountingController@showcost');
Route::get('/accounting/summary','AccountingController@showSummary');
Route::get('/accounting/addfund','AccountingController@addfund');
Route::get('/accounting/filter','AccountingController@filter');

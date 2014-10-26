<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('uncleshop');
});



Route::get('customers','UncleshopApiController@getCustomers');

Route::get('updateCustomers','UncleshopApiController@updateCustomers');

Route::get('deleteCustomers','UncleshopApiController@deleteCustomers');

Route::get('saveBill','UncleshopApiController@saveBill');

Route::get('saveAdmin','UncleshopApiController@saveAdmin');
Route::get('checkUser','UncleshopApiController@checkUser');

Route::get('updateAdmin','UncleshopApiController@updateAdmin');
Route::get('deleteAdmin','UncleshopApiController@deleteAdmin');

Route::post('login','UncleshopApiController@loginAdmin');





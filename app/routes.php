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

Route::post('/send/print_uncleshop', function()
{
    return View::make('print_uncleshop');
});

Route::get('customers','UncleshopApiController@getCustomers');
Route::get('checkCustomersId','UncleshopApiController@checkCustomersId');
Route::post('saveCustomers','UncleshopApiController@saveCustomers');
Route::get('admin','UncleshopApiController@getAdmin');
Route::get('interest','UncleshopApiController@getAdminInterest');

Route::get('updateCustomers','UncleshopApiController@updateCustomers');
Route::get('deleteCustomers','UncleshopApiController@deleteCustomers');

Route::post('saveBill','UncleshopApiController@saveBill');
Route::get('getBill','UncleshopApiController@getBill');
Route::get('bill','UncleshopApiController@searchBill');
Route::get('timeLineBill','UncleshopApiController@timeLineBill');
////จ่ายค่างวดปกติ///
Route::post('updateBillDetail','UncleshopApiController@updateBillDetail');
////มาจ่ายงวดก่อนกำหนด///
Route::post('cutBillDetail','UncleshopApiController@cutBillDetail');
////จ่ายดอกเบี้ยเพราะไม่มีเงินจ่ายค่างวดและเพิ่มวันที่ผ่อนไปอีก///
Route::post('payOnlyInterest','UncleshopApiController@payOnlyInterest');

Route::get('saveAdmin','UncleshopApiController@saveAdmin');
Route::get('checkUser','UncleshopApiController@checkUser');

Route::get('updateAdmin','UncleshopApiController@updateAdmin');
Route::get('deleteAdmin','UncleshopApiController@deleteAdmin');

Route::post('login','UncleshopApiController@loginAdmin');







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
use App\Member;
// Route::get('/login', function () {
//     // return view('welcome');
//     return view('login');
//     //return Member::all();
// });
Route::get('/', 'View\BookController@toCategory');
Route::get('/login', 'View\MemberController@tologin');
Route::get('/register', 'View\MemberController@toRegister');
Route::get('/category', 'View\BookController@toCategory');
Route::get('/product/category_id/{category_id}', 'View\BookController@toProduct');
Route::get('/product/{product_id}', 'View\BookController@toPdtcontent');
Route::get('/cart','View\CartController@toCart');
Route::get('/order_commit/{product_ids}','View\OrderController@toOrderCommit')->middleware('check.login');
Route::get('/order_list','View\OrderController@toOrderList')->middleware('check.login');

Route::get('/alipay','View\PayController@toAlipay');

Route::post('/service/alipay','Service\PayController@alipay');
Route::get('/return_url','View\PayController@toReturnUrl');




Route::group(['prefix' => 'service'], function () {
	Route::get('validate/create','Service\ValidateController@create');
	Route::get('validate/send','Service\ValidateController@sendSMS');
	Route::get('validate_email','Service\ValidateController@validateEmail');
	Route::post('register','Service\MemberController@register');
	Route::post('login','Service\MemberController@login');
	Route::post('getcategory/parent_id/{parent_id}','Service\BookController@getChildrensById');
	Route::post('cart/add/{product_id}','Service\CartController@addCart');
	Route::post('cart/del','Service\CartController@delCart');
	
	Route::get('notify','Service\PayController@toNotify');

});
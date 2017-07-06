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
Route::get('/login', 'View\MemberController@tologin');
Route::get('/register', 'View\MemberController@toRegister');
Route::get('service/validate/create','Service\ValidateController@create');
Route::get('service/validate/send','Service\ValidateController@sendSMS');

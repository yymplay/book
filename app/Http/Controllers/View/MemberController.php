<?php 
namespace App\Http\Controllers\View;
use App\Http\Controllers\Controller;
use App\Tool\Validate\ValidateCode;

class MemberController extends Controller{
	public function toLogin(){
		return view('login');
		
	}
	public function toRegister(){
		return view('register');
	}
}
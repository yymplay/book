<?php 
namespace App\Http\Controllers\Service;
use App\Http\Controllers\Controller;
use App\Tool\Validate\ValidateCode;
use Illuminate\Http\Request;
use App\Models\M3Result;
class MemberController extends Controller{
	public function register(){
		return view('login');
		
	}
	public function toRegister(){
		return view('register');
	}
}
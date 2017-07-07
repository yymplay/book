<?php 
namespace App\Http\Controllers\Service;
use App\Http\Controllers\Controller;

use App\Tool\Validate\ValidateCode;
use App\Tool\SMS\SendTemplateSMS;

use Illuminate\Http\Request;

use App\Entity\Member;
use App\Entity\TempEmail;
use App\Entity\TempPhone;

use App\Models\M3Result;

class ValidateController extends Controller{
	public function create($value=''){
		$validateCode= new ValidateCode;
		return $validateCode->doimg();
	}
	public function sendSMS(Request $request){
		$M3Result=new M3Result;
		$phone=$request->input('phone');
		$this->validate($request, 
		[
    				'phone' => 'required|digits:11',
		],[
			'required'=>":attribute 是必填项",
			'digits'=>":attribute 超过规定范围",
		],[
			'phone'=>'手机号',
		]);

		$sendTemplateSMS = new SendTemplateSMS();
		$code=rand(000000,999999);
		$M3Result=$sendTemplateSMS ->sendTemplateSMS($phone,[$code,60],1);
		// var_dump($rst);
		$tempPhone= new TempPhone;
		$tempPhone->phone=$phone;
		$tempPhone->code=$code;
		$tempPhone->deadline=date('Y-m-d H:i:s',time()+60*60);
		$tempPhone->save();
		return $M3Result->toJson();
		

	}
}
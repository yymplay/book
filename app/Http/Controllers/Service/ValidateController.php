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
	public function create(Request $request){
		$validateCode= new ValidateCode;
		$request->session()->put('validate_code',$validateCode->getCode());
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
		if($M3Result->status==0){
			$tempPhone=TempPhone::where('phone',$phone)->first();
			if($tempPhone==null){
				$tempPhone= new TempPhone;
			}
			$tempPhone->phone=$phone;
			$tempPhone->code=$code;
			$tempPhone->deadline=date('Y-m-d H:i:s',time()+60*60);
			$tempPhone->save();
			
		}
		
		return $M3Result->toJson();
		

	}
	public function validateEmail(Request $request){
		$M3Result=new M3Result;
		$member_id=$request->input('member_id','')+0;
		$code=$request->input('code','');
		$info=[];
		$info['icon']= 'weui_icon_warn';
		if($member_id<=0 || $code==''){
			$info['msg']= '验证异常';
		}
		$tempEmail=TempEmail::where('member_id',$member_id)->first();
		if($tempEmail==null){
			$info['msg']= '验证异常';
			return view('email_result')->with('info',$info);
		}
		if($tempEmail->code==$code){
			if(strtotime($tempEmail->deadline)<time()){
				$info['msg']= '该链接已失效';
				
			}
			$member=Member::find($member_id);
			$member->active=1;
			$member->save();
			$info['msg']= '邮箱已通过验证';
			$info['icon']= 'weui_icon_success';

		}else{
			$info['msg']= '该链接已失效';
		}
		return view('email_result')->with('info',$info);
		
	}
}
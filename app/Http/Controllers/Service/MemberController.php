<?php 
namespace App\Http\Controllers\Service;
use App\Entity\TempPhone;
use App\Entity\TempEmail;
use App\Entity\Member;
use App\Http\Controllers\Controller;
use App\Tool\Validate\ValidateCode;
use Illuminate\Http\Request;
use App\Models\M3Result;
use App\Models\M3Email;
use Mail;
class MemberController extends Controller{
	public function register(Request $request){
		$m3_result=new M3Result;
		$email=$request->input('email','');
		$phone=$request->input('phone','');
		$password=$request->input('password','');
		$confirm=$request->input('confirm','');
		$phone_code=$request->input('phone_code','');
		$validate_code=$request->input('validate_code','');
		
		if($email=='' && $phone==''){
			$m3_result->status=1;
			$m3_result->message='手机号或邮箱不能为空';
			return $m3_result->toJson();
		}
		if($password == '' || strlen($password) < 6) {
	      $m3_result->status = 2;
	      $m3_result->message = '密码不少于6位';
	      return $m3_result->toJson();
	    }
	    if($confirm == '' || strlen($confirm) < 6) {
	      $m3_result->status = 3;
	      $m3_result->message = '确认密码不少于6位';
	      return $m3_result->toJson();
	    }
	    if($password != $confirm) {
	      $m3_result->status = 4;
	      $m3_result->message = '两次密码不相同';
	      return $m3_result->toJson();
	    }
		// 手机号注册
    	if($phone != '') {
      		if($phone_code == '' || strlen($phone_code) != 6) {
        		$m3_result->status = 5;
        		$m3_result->message = '手机验证码为6位';
        		return $m3_result->toJson();
      		}

      		$tempPhone = TempPhone::where('phone', $phone)->first();
      		if($tempPhone['code'] == $phone_code) {
        		if(time() > strtotime($tempPhone->deadline)) {
          			$m3_result->status = 7;
          			$m3_result->message = '手机验证码不正确';
          			return $m3_result->toJson();
        		}
        		$member=Member::where('phone',$phone)->first();
        		if($member==null){
        			$member = new Member;
        			$member->phone = $phone;
        			$member->active=1;
        			$member->password = md5('bk' + $password);
        			$member->save();
        			$m3_result->status = 0;
        			$m3_result->message = '注册成功';
        		}else{
        			$m3_result->status = 8;
        			$m3_result->message = '该用户已注册 可直接登录';
        		}
       	 		return $m3_result->toJson();
      	} else {
        		$m3_result->status = 7;
        		$m3_result->message = '手机验证码不正确';
        		return $m3_result->toJson();
      	}

    // 邮箱注册
    } else {
      if($validate_code == '' || strlen($validate_code) != 4) {
        $m3_result->status = 6;
        $m3_result->message = '验证码为4位';
        return $m3_result->toJson();
      }

      $validate_code_session = $request->session()->get('validate_code', '');
      if($validate_code_session != $validate_code) {
        $m3_result->status = 9;
        $m3_result->message = '验证码不正确';
        return $m3_result->toJson();
      }
      $member = Member::where('email',$email)->first();
      if($member==null){
      		$member = new Member;
      }
      $member->email = $email;
      $member->password = md5('bk' + $password);
      $member->save();

      $uuid = md5(uniqid());

      $m3_email = new M3Email;
      $m3_email->to = $email;
      $m3_email->cc = 'yymplayer@163.com';
      $m3_email->subject = '邮箱验证';
      $m3_email->content = '请于24小时点击该链接完成验证. http://test.izhiwo.com/service/validate_email'
                        . '?member_id=' . $member->id
                        . '&code=' . $uuid;
      $tempEmail = tempEmail::where('member_id',$member->id)->first();
      if($tempEmail==null){
      		$tempEmail = new TempEmail;
      }
      $tempEmail->member_id = $member->id;
      $tempEmail->code = $uuid;
      $tempEmail->deadline = date('Y-m-d H-i-s', time() + 24*60*60);
      $tempEmail->save();

      Mail::send('email_register', ['m3_email' => $m3_email], function ($m) use ($m3_email) {
          $m->from('yymplayer@163.com', '深夜书店');
          $m->to($m3_email->to, '尊敬的用户')
             ->cc($m3_email->cc)
            ->subject($m3_email->subject);
      });

      $m3_result->status = 0;
      $m3_result->message = '邮件发送成功,请于24小时登录邮箱完成验证';
      return $m3_result->toJson();
    }
		
	}
	public function login(Request $request){
		$username=$request->get('username','');
		$password=$request->get('password','');
		$validate_code=$request->get('validate_code','');
		$m3_result=new M3Result;
		if($validate_code!=$request->session()->get('validate_code','')){
			$m3_result->status=1;
			$m3_result->message='验证码错误';
			return $m3_result->toJson();
		}
		if(strpos($username, '@') == true) {
	      $member = Member::where('email', $username)->first();
	    } else {
	      $member = Member::where('phone', $username)->first();
	    }
	    if($member == null) {
	      $m3_result->status = 2;
	      $m3_result->message = '该用户不存在';
	      return $m3_result->toJson();
	    } else {  	  
		      if(md5('bk' + $password) != $member->password) {
		        $m3_result->status = 3;
		        $m3_result->message = '密码不正确';
		        return $m3_result->toJson();
		      }
		      if($member->active==0){
	    	  	 $m3_result->status = 4;
		         $m3_result->message = '请先登录邮箱激活';
		         return $m3_result->toJson();
	    	  }
	    	  
	    }
	    $request->session()->put('member', $member);
	    $m3_result->status = 0;
	    $m3_result->message = '登录成功';
	    return $m3_result->toJson();
	}
}
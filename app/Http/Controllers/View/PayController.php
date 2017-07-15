<?php 
namespace App\Http\Controllers\View;

use App\Entity\Member;
use App\Entity\Category;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\M3Result;
use Log;

class PayController extends Controller{
	
  public function toAlipay(){
        return 'hello';
        return view('alipay');
  }
  public function toReturn(){
        return '支付成功';
  }
}
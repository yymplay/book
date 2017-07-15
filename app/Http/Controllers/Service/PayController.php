<?php 
namespace App\Http\Controllers\Service;

use App\Entity\Member;
use App\Entity\Category;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\M3Result;
use Log;

class PayController extends Controller{
	public function alipay(Request $request){
    $m3_result=new M3Result;
    $m3_result->status=0;
    $m3_result->message='';
    // return app_path();
    
    require_once app_path().'/Tool/alipay/wappay/service/AlipayTradeService.php';
    require_once app_path().'/Tool/alipay/wappay/buildermodel/AlipayTradeWapPayContentBuilder.php';
    require app_path().'/Tool/alipay/config.php';
    if (!empty($_POST['WIDout_trade_no'])&& trim($_POST['WIDout_trade_no'])!=""){
        //商户订单号，商户网站订单系统中唯一订单号，必填
        $out_trade_no = $_POST['WIDout_trade_no'];

        //订单名称，必填
        $subject = $_POST['WIDsubject'];

        //付款金额，必填
        $total_amount = $_POST['WIDtotal_amount'];

        //商品描述，可空
        $body = $_POST['WIDbody'];

        //超时时间
        $timeout_express="1m";

        $payRequestBuilder = new \AlipayTradeWapPayContentBuilder();
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setOutTradeNo($out_trade_no);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setTimeExpress($timeout_express);

        $payResponse = new \AlipayTradeService($config);
        $result=$payResponse->wapPay($payRequestBuilder,$config['return_url'],$config['notify_url']);

        return ;
    }
    
    // return $m3_result->toJson();
  }
  public function toReturn(){
    log::info('支付回调来了'.json_encode($_POST));
  }
}
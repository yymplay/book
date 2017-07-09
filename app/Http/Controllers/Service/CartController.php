<?php 
namespace App\Http\Controllers\Service;

use App\Entity\Member;
use App\Entity\Category;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\M3Result;


class CartController extends Controller{
	public function addCart(Request $request,$product_id){
    $m3_result=new M3Result;
    //获取购物车数据
    $carts=$request->cookie('book_cart');

    $cart_arr=$carts?(explode(',',$carts)):array();
    $num=1;
    foreach ($cart_arr as  &$v) {
       //判断是否等于当前id
       $sub=strpos($v, ':');
       if(substr($v,0,$sub)==$product_id){
          //获取数量 然后+1
          $num=substr($v, $sub+1)+1;
          $v=$product_id.':'.$num;
          break;
       }
    }
    if($num==1){
      //将数据加入数组
      $cart_arr[]=$product_id.':'.$num;
    }
    $m3_result->status=0;
    $m3_result->message='添加成功';
    return response($m3_result->toJson())->withCookie('book_cart',implode(',', $cart_arr));
  }
}
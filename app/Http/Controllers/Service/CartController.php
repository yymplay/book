<?php 
namespace App\Http\Controllers\Service;

use App\Entity\Member;
use App\Entity\Category;
use App\Entity\Cart;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\M3Result;


class CartController extends Controller{
	public function addCart(Request $request,$product_id){
    $m3_result=new M3Result;
    
    // 如果当前已经登录
    $member = $request->session()->get('member', '');
    if($member != '') {
      $cart_items = Cart::where('member_id', $member->id)->get();

      $exist = false;
      foreach ($cart_items as $cart_item) {
        if($cart_item->product_id == $product_id) {
          $cart_item->count ++;
          $cart_item->save();
          $exist = true;
          break;
        }
      }

      if($exist == false) {
        $cart_item = new Cart;
        $cart_item->product_id = $product_id;
        $cart_item->count = 1;
        $cart_item->member_id = $member->id;
        $cart_item->save();
      }
      $m3_result->status=0;
      $m3_result->message='添加成功';
      return $m3_result->toJson();
    }
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
  public function delCart(Request $request){
      $m3_result=new M3Result;
      //获取product
      $pdts=$request->input('productids','');
      if($pdts==''){
        $m3_result->status=1;
        $m3_result->message='书籍ID为空';
        return $m3_result->toJson();
      }
      $member=$request->session()->get('member','');
      if ($member!='') {
          //从数据库删除
          $delResult=Cart::whereIn('product_id',$pdts)->delete();
          if($delResult>=0){
             $m3_result->status=0;
             $m3_result->message='删除成功';
             return $m3_result->toJson();
          }
      }
      //获取购物车数据
      $carts=$request->cookie('book_cart');
      $carts_arr=$carts?(explode(',',$carts)):[];
      $new_carts=[];
      foreach($carts_arr as $v){
        //获取product_id
        $sub=strpos($v, ':');
          if(in_array(substr($v, 0,$sub), $pdts)){
             continue;
          }
        //插入新cookie数组里
        $new_carts[]=$v;
      }
      //返回 并写入cookie
      $m3_result->status=0;
      $m3_result->message='删除成功';
      return response($m3_result->toJson())->withCookie('book_cart',implode(',', $new_carts));
      
  }
}
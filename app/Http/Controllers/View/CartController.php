<?php 
namespace App\Http\Controllers\View;
use App\Http\Controllers\Controller;
use App\Tool\Validate\ValidateCode;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\PdtContent;
use App\Entity\Cart;
use Log;
use Illuminate\Http\Request;
class CartController extends Controller{
	public function toCart(Request $request){
	    //获取购物车数据
	    $carts=$request->cookie('book_cart');

	    $cart_arr=$carts?(explode(',',$carts)):array();
	    $member=$request->session()->get('member','');
	    if($member!=''){
	    	$cart_items=$this->syncCart($member->id,$cart_arr);
	    	return response()->view('cart',['cart_items'=>$cart_items])->withCookie('book_cart',null);
	    }
	    $cart_items=[];
	    // $num=1;
	    foreach ($cart_arr as  $k=>$v) {
	       //判断是否等于当前id
	       $sub=strpos($v, ':');
	       $cart=new Cart;
	       $cart->id=$k;
	       $cart->product_id=substr($v,0,$sub);
	       $cart->count=substr($v, $sub+1);
	       $cart->product=Product::find(substr($v,0,$sub));
	   	   if($cart->product!=null){
	   	   		$cart_items[]=$cart;
	   	   }
	    }

		return view('cart')->with('cart_items',$cart_items);
		
	}
	private function syncCart($member_id,$carts_arr){
		//查询出数据库中 购物车数
		$DbCarts=Cart::where('member_id',$member_id)->get();
		$new_carts_arr=[];
		foreach ($carts_arr as $v) {
			$exist=false;
			$sub=strpos($v, ':');
			$product_id=substr($v, 0,$sub);
			$count=substr($v, $sub+1);
			foreach($DbCarts as $DbCart){
				if($DbCart->product_id==$product_id){
					//判断数量,cookie大于db则更新
					if($DbCart->count<$count){
						$DbCart->count=$count;
						$DbCart->save();
					}
					$exist=true;
					break;
				}
			}
			//不存在加入数据库
			if($exist==false){
				$cartModel=new Cart;
				$cartModel->product_id=$product_id;
				$cartModel->count=$count;
				$cartModel->member_id=$member_id;
				$cartModel->save();
				$cartModel->product=Product::find($product_id);
				//加入购物车数组
				$new_carts_arr[]=$cartModel;
			}
			
		}
		// 为每个对象附加产品对象便于显示
    	foreach ($DbCarts as $DbCart) {
      		$DbCart->product = Product::find($DbCart->product_id);
      		$new_carts_arr[]= $DbCart;
    	}

    	return $new_carts_arr;
	}

}
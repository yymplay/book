<?php 
namespace App\Http\Controllers\View;
use App\Http\Controllers\Controller;
use App\Tool\Validate\ValidateCode;
use App\Entity\Category;
use App\Entity\Cart;
use App\Entity\Product;
use App\Entity\PdtContent;
use App\Entity\PdtImages;
use App\Entity\Order;
use App\Entity\OrderItem;
use Log;
use Illuminate\Http\Request;
class OrderController extends Controller{
	public function toOrderCommit(Request $request,$product_ids){
		$product_ids_arr=explode(',', $product_ids);
		$member=$request->session()->get('member');
		$cart_items = Cart::where('member_id',$member->id)->whereIn('product_id',$product_ids_arr)->leftjoin('product','cart.product_id','=','product.id')->get();
		// foreach ($cart_items as $v) {
			
		// }
		//return $cart_items;
		return view('order_commit')->with('cart_items',$cart_items);
		
	}
	public function toOrderList(Request $request){
		$member=$request->session()->get('member','');
		//获取订单
		$orders=Order::where('member_id',$member->id)->get();
		foreach($orders as $v){
			//获取订单对应的订单详单
			$v->order_items=OrderItem::where('order_id',$v->id)->get();
			foreach($v->order_items as $vv){
				//获取产品详情
				$vv->product=Product::find($vv->product_id);
			}
		}
		
		return view('order_list')->with('orders',$orders);
	}
	public function toAlipay(){
		return view('alipay');
	}

}
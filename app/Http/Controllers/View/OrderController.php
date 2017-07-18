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
	public function toOrderCommit(Request $request,$order_id){
		//$product_ids_arr=explode(',', $product_ids);
		//$member=$request->session()->get('member');
		//$cart_items = Cart::where('member_id',$member->id)->whereIn('product_id',$product_ids_arr)->leftjoin('product','cart.product_id','=','product.id')->get();
		$cart_items = OrderItem::where('order_id',$order_id)->leftjoin('product','order_item.product_id','=','product.id')->get();
		$order=Order::find($order_id);
		// foreach ($cart_items as $v) {
			
		// }
		//return $cart_items;
		return view('order_commit')->with('cart_items',$cart_items)
								   ->with('total_price',$order->total_price)
								   ->with('order_no',$order->order_no);
		
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
	public function paypage(Request $request,$product_ids){
		$product_ids_arr = ($product_ids!='' ? explode(',', $product_ids) : array());

	    $member = $request->session()->get('member', '');
	    $cart_items = Cart::where('member_id', $member->id)->whereIn('product_id', $product_ids_arr)->get();

	    $order = new Order;
	    $order->member_id = $member->id;
	    $order->save();

	    $cart_items_arr = array();
	    $cart_items_ids_arr = array();
	    $total_price = 0;
	    //$name = '';
	    foreach ($cart_items as $cart_item) {
	      $cart_item->product = Product::find($cart_item->product_id);
	      if($cart_item->product != null) {
	        $total_price += $cart_item->product->price * $cart_item->count;
	        //$name .= ('《'.$cart_item->product->name.'》');
	        array_push($cart_items_arr, $cart_item);
	        array_push($cart_items_ids_arr, $cart_item->id);

	        $order_item = new OrderItem;
	        $order_item->order_id = $order->id;
	        $order_item->product_id = $cart_item->product_id;
	        $order_item->count = $cart_item->count;
	        $order_item->pdt_snapshot = json_encode($cart_item->product);
	        $order_item->save();
	      }
	    }
	    Cart::whereIn('id', $cart_items_ids_arr)->delete();

	    //$order->name = $name;
	    $order->total_price = $total_price;
	    $order->status = 1;
	    $order->order_no = 'E'.time().''.$order->id;
	    $order->save();

	    return redirect()->action('View\OrderController@toOrderCommit', [$order->id]);
	}

}
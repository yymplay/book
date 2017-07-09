<?php 
namespace App\Http\Controllers\View;
use App\Http\Controllers\Controller;
use App\Tool\Validate\ValidateCode;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\PdtContent;
use App\Entity\PdtImages;
use Log;
use Illuminate\Http\Request;
class BookController extends Controller{
	public function toCategory(){
		$categorys=Category::where('parent_id',null)->get();
		return view('category')->with('categorys',$categorys);
		
	}
	public function toProduct($category_id){
		Log::info("进入书籍列表");

		$category_id+=0;
		$products=Product::where('category_id',$category_id)->get();
		if($products->isEmpty()){

		}
		return view('product')->with('products',$products);
	}
	public function toPdtcontent(Request $request,$product_id){
		$product_id+=0;
		$product=Product::find($product_id);
		$pdt_content=PdtContent::where('product_id',$product_id)->first();
		$pdt_images=PdtImages::where('product_id',$product_id)->get();
		// if($product->isEmpty()){

		// }
		//获取数量
		$count=0;
		$carts=$request->cookie('book_cart');
		$cart_arr=$carts?(explode(',', $carts)):[];

		foreach($cart_arr as $v){
			$sub=strpos($v, ':');
			if(substr($v,0,$sub)==$product_id){
				$count=substr($v,$sub+1);
			}
		}
		return view('pdtcontent')->with('product',$product)
								 ->with('pdt_content',$pdt_content)
								 ->with('pdt_images',$pdt_images)
								 ->with('count',$count);
	}

}
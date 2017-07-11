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
class OrderController extends Controller{
	public function toPay(Request $request){
		return view('orderpay');
		
	}


}
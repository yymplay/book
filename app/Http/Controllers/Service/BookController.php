<?php 
namespace App\Http\Controllers\Service;

use App\Entity\Member;
use App\Entity\Category;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\M3Result;


class BookController extends Controller{
	public function getChildrensById(Request $request,$parent_id){
    $m3_result=new M3Result;
    $parent_id+=0;
    if($parent_id<=0){
      $m3_result->status=1;
      $m3_result->status='参数错误';
      return $m3_result->toJson();
    }
    //查询子分类
    $childrens=Category::where('parent_id',$parent_id)->get();
    if($childrens->isEmpty()){
      $m3_result->status=2;
      $m3_result->message='暂无相关书籍';
      return $m3_result->toJson();
    }
    $m3_result->status=0;
    $m3_result->message='';
    $m3_result->childrens=$childrens;
    return $m3_result->toJson();
  }
}
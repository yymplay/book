<?php 
namespace App\Http\Controllers\Service;
use App\Http\Controllers\Controller;
use App\Tool\Validate\ValidateCode;

class ValidateController extends Controller{
	public function create($value=''){
		$validateCode= new ValidateCode;
		return $validateCode->doimg();
	}
}
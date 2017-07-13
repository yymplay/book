<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogin
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];
    public function handle($request, Closure $next){
    	$member=$request->session()->get('member','');
    	if($member==''){
    		   $return_url='/';
               if(isset($_SERVER['HTTP_REFERER'])){
                    $ref=urldecode($_SERVER['HTTP_REFERER']);
                    $sub=strpos($ref, '/login?return_url=');
                    if($sub!==false)
                        $return_url=substr($ref, $sub+18);
                    else
                        $return_url=$_SERVER['HTTP_REFERER'];    
                } 

    		return redirect('/login?return_url='.urlencode($return_url));
    	}
    	return $next($request);
    }
}

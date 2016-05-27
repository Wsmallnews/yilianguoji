<?php namespace App\Http\Middleware;

use Closure;
use AuthUser;
use Route;
use App\User;
use App\OutQueue;
use App\InQueue;
use App\WaitQueue;
use Hp;
class HomeMiddleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
	    $route = Route::currentRouteName();

	    if(!AuthUser::check()){
	        if($route != 'login' && $route != 'doLogin'){
	            return redirect('home/login');
	        }
	    }else{
	        if($route == 'login' || $route == 'doLogin'){
	            return redirect('home/index');
	        }
	    }
		return $next($request);
	}
}

<?php namespace App\Http\Middleware;

use Closure;
use AuthUser;
use Route;
use App\User;
use App\CronLog;
use Hp;
use Queue;
use App\Commands\ShareMoney;
use View;

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

		View::share('l_web', app('l_web'));

	    if(!AuthUser::check()){
	        if($route != 'login' && $route != 'doLogin'){
	            return redirect('home/login');
	        }
	    }else{
			View::share('l_user', AuthUser::user());
	        if($route == 'login' || $route == 'doLogin'){
	            return redirect('home/index');
	        }
	    }

		return $next($request);
	}
}

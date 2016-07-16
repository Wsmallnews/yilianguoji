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
use Request;
use Response;

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
				if(Request::ajax()){
					return Response::json(array('error'=>1,'info' => '您已退出登录，请重新登录'));
				}else{
					return redirect('home/login');
				}
	        }
	    }else{
			$user = AuthUser::user();
			View::share('l_user', $user);
			if(!$user){
				//如果用户在已经登录的情况下，被管理员删除，则退出登录
				AuthUser::logout();

				if(Request::ajax()){
					return Response::json(array('error'=>0,'info' => '您已退出登录，请重新登录'));
				}else{
					return redirect('home/login');
				}
			}
	        if($route == 'login' || $route == 'doLogin'){
	            return redirect('home/index');
	        }
	    }

		return $next($request);
	}
}

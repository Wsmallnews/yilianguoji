<?php namespace App\Http\Middleware;

use Closure;
use AuthUser;
use Route;
use App\User;
use App\OutQueue;
use App\InQueue;
use App\WaitQueue;
use Hp;
use Session;
use Redirect;

class AdminMiddleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{

	    if(Session::get('laravel_user_id') === 1){
			return $next($request);
	    }else{
			return redirect('home/index')->withErrors('对不起，您没有操作权限');
		}
	}
}

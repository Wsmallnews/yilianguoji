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

	    if(Session::get('laravel_user_id') != 0 || Session::get('laravel_user_id') === null){
	        // return Redirect::back()->withErrors('对不起，您没有操作权限');
			return redirect('home/index')->withErrors('对不起，您没有操作权限');
	    }

		return $next($request);
	}
}

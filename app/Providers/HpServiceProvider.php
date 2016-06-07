<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;
use App\Setting;
use Session;

class HpServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{

		// Session::forget('l_web');
		// $l_web = Setting::find(1);
		//
		// Session::put('l_web',$l_web);
		// //所有视图共享数据
	    View::share('l_web', $this->app['l_web']);
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Illuminate\Contracts\Hp\Hp',
			'App\Services\Hp'
		);

		$this->app->singleton('l_web',function($app){
			// if($app->l_web){
			// 	return $app->l_web;
			// }
			return Setting::find(1);
		});

	}

}

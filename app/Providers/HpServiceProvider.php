<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;
class HpServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//所有视图共享数据
	    View::share('l_web', [
	       'web_name' => '123'
	       ]
	    );
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
	}

}

<?php namespace Illuminate\Support\Facades;

/**
 * @see \Illuminate\Foundation\Application
 */
class AuthUser extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'Illuminate\Contracts\AuthUser\AuthUser'; }

}

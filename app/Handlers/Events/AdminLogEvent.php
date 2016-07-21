<?php namespace App\Handlers\Events;

use App\Events\LogEvent;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use App\AdminLog;
use Request;
use Session;

class AdminLogEvent {

	// private $data = array(
	// 	'u_id',
	// 	'log_info'
	// );
	/**
	 * Create the event handler.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
		// $this->data = $data;
	}

	/**
	 * Handle the event.
	 *
	 * @param  Log  $event
	 * @return void
	 */
	public function handle(LogEvent $event)
	{
		//记录日志
		$data = $event->log_data;

		$adminLog = new AdminLog();
		$adminLog->u_id = isset($data['u_id']) ? $data['u_id'] : Session::get('laravel_user_id');
		$adminLog->log_info = $data['log_info'];
		$adminLog->ip_address = Request::ip();
		$adminLog->save();
		return true;
	}

}

<?php namespace App\Handlers\Events;

use App\Events\LogEvent;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class AdminLogEvent {

	private $data = array(
		'u_id',
		'log_info'
	);
	/**
	 * Create the event handler.
	 *
	 * @return void
	 */
	public function __construct($data)
	{
		//
		$this->data = $data;
	}

	/**
	 * Handle the event.
	 *
	 * @param  Log  $event
	 * @return void
	 */
	public function handle(Log $event)
	{
		//
		print_r($this->data);exit;
	}

}

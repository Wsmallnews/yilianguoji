<?php namespace App\Events;

use App\Events\Event;

use Illuminate\Queue\SerializesModels;
use Hp;

class LogEvent extends Event {

	use SerializesModels;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct($log_data)
	{
		$this->log_data = $log_data;
	}
}

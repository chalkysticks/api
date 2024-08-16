<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

/**
 * @class PurgeRequest
 * @package Events
 * @project ChalkySticks API
 */
class PurgeRequest extends Event {
	use SerializesModels;

	/**
	 * @var string[]
	 */
	public $urls;

	/**
	 * Create a new event instance.
	 *
	 * @param  []  $urls
	 * @return void
	 */
	public function __construct($urls) {
		$this->urls = $urls;
	}
}

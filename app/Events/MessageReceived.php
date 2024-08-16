<?php

namespace App\Events;

use App\Models;
use Illuminate\Queue\SerializesModels;

/**
 * @class MessageReceived
 * @package Events
 * @project ChalkySticks API
 */
class MessageReceived extends Event {
	use SerializesModels;

	/**
	 * @var Models\User
	 */
	public $from_user;

	/**
	 * @var number[]
	 */
	public $user_ids;

	/**
	 * @var string
	 */
	public $message;

	/**
	 * @param  Models\User    $from_user
	 * @param  string  $message
	 * @return void
	 */
	public function __construct(Models\User $from_user, $user_ids, $message) {
		$this->from_user = $from_user;
		$this->user_ids = $user_ids;
		$this->message = $message;
	}
}

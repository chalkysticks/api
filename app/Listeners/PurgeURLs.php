<?php

namespace App\Listeners;

use App\Events;
use Log;

/**
 * @class PurgeURLs
 * @package Listeners
 * @project ChalkySticks API
 */
class PurgeURLs {
	/**
	 * Handle the event.
	 *
	 * @param Events\PurgeRequest $event
	 * @return void
	 */
	public function handle(Events\PurgeRequest $event) {
		foreach ($event->urls as $url) {
			Log::info("[listener] Purging a URL: $url");

			purge($url);
		}
	}
}

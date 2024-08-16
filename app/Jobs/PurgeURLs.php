<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * @class PurgeURLs
 * @package Job
 * @project ChalkySticks API
 */
class PurgeURLs extends Job implements ShouldQueue {
	use InteractsWithQueue, SerializesModels;

	/**
	 * @var string[]
	 */
	public $urls;

	/**
	 * Create a new event instance.
	 *
	 * @param string[] $urls
	 * @return void
	 */
	public function __construct($urls) {
		$this->urls = $urls;
	}

	/**
	 * Execute the job. Delete after two failed attempts.
	 *
	 * @return void
	 */
	public function handle() {
		// Cancel job after two failed attempts
		if ($this->attempts() > 2) {
			$this->delete();
		}

		// Purge the URLs
		foreach ($this->urls as $url) {
			purge($url);
		}
	}
}

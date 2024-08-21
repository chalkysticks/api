<?php

namespace App\Console\Commands\Tv;

use App\Models;
use App\Utilities;
use Illuminate\Console\Command;

/**
 * Looks up a URL, finds out who the channel is, then creates an association in
 * our database for that channel.
 *
 * php artisan tv:reversefetch --all=true
 *
 * @class ReverseFetch
 * @package Console/Commands/Tv
 * @project ChalkySticks API
 */
class ReverseFetch extends Command {
	/**
	 * @var string
	 */
	protected $signature = 'tv:reversefetch  {youtubeUrl?} {--all=false}';

	/**
	 * @var string
	 */
	protected $description = 'Fetches channel data from a YouTube URL';

	/**
	 * @return mixed
	 */
	public function handle() {
		$youtubeUrl = $this->argument('youtubeUrl');
		$all = $this->option('all');

		if ($youtubeUrl) {
			$this->processSingle($youtubeUrl);
		} else if ($all) {
			$this->processAll();
		}
	}

	/**
	 * @return void
	 */
	protected function processAll() {
		$models = Models\TvSchedule::all();

		// Run through models
		foreach ($models as $model) {
			$this->processSingle($model);
			echo "$model->title\n";
		}
	}

	/**
	 * @param string $youtubeUrl
	 * @return void
	 */
	private function processSingle(string|Models\TvSchedule $youtubeUrl) {
		if (is_string($youtubeUrl)) {
			$id = parseYoutubeId($youtubeUrl);
			$model = Models\TvSchedule::where('embed_url', "https://youtube.com/embed/$id")->first();
		} else {
			$model = $youtubeUrl;
		}

		// Get details from the video
		$json = Utilities\YouTube::fetchVideo($model->embed_url);

		// No results, skip
		if ($json->pageInfo->totalResults === 0) {
			return;
		}

		$item = $json->items[0];
		$channel_id = $item->snippet->channelId;

		// Create or update channel itself
		Models\TvChannel::createFromChannelId($channel_id);

		// Update the TvSchedule model
		$model->youtube_channel_id = $channel_id;
		$model->save();
	}
}

<?php

namespace App\Console\Commands\Tv;

use App\Models;
use App\Utilities;
use DB;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

/**
 * php artisan tv:getlivechannel --id=UC_abcdefg
 *
 * @class FetchLive
 * @package Console/Commands/Tv
 * @project ChalkySticks API
 */
class GetLiveChannel extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'tv:getlivechannel {--id=}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Fetch Live tv data from YouTube channel';


	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {
		$channelId = $this->option('id');
		$videos = [];
		$embeddable = [];

		// Log to laravel.log
		Log::info("Fetching live videos from YouTube at " . date('Y-m-d H:i:s'));

		// Get IDs from the database
		$model = Models\TvChannel::where(DB::raw('LOWER(channel_id)'), strtolower($channelId))->first();
		$youtubeId = $model ? $model->youtube_id : $channelId;

		// Fetch videos
		$videos = array_merge($videos, $this->getSource($youtubeId));

		// Filter out non-embeddable videos
		foreach ($videos as $video) {
			$works = Utilities\YouTube::isEmbeddable($video->video_url);

			if ($works) {
				$embeddable[] = $video;
				$this->line(" ✅ Embeddable: $video->title");
				print_r($video);
			} else {
				$this->line(" ❌ Not embeddable: $video->title");
			}
		}
	}

	/**
	 * Fetch videos from user accounts or playlists and format them into a
	 * video object
	 *
	 * @param string channel
	 * @return array
	 */
	private function getSource(string $channel) {
		$videos = [];

		// Get all live videos
		$json = Utilities\YouTube::fetchLiveChannel($channel);

		// Bork
		$this->line("Getting live channel: $channel");

		// If we received items from our API call...
		if ($json !== false && isset($json->items) && count($json->items)) {
			foreach ($json->items as $video) {
				$data = (object) [
					'air_at' => @$video->snippet->publishTime,
					'channel_id' => @$video->snippet->channelId,
					'description' => $video->snippet->description,
					'duration' => 0,
					'thumbnail_url' => @$video->thumbnail ?? @$video->snippet->thumbnails->standard->url ?? @$video->snippet->thumbnails->medium->url,
					'title' => $video->snippet->channelTitle,
					'video_id' => $video->id,
					'video_url' => 'https://www.youtube.com/embed/' . $video->id,
				];

				$videos[] = $data;
			}
		}

		return $videos;
	}
}

<?php

namespace App\Console\Commands\Tv;

use App\Models;
use App\Utilities;
use DB;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;

/**
 * php artisan tv:fetchlive --create=true
 *
 * @class FetchLive
 * @package Console/Commands/Tv
 * @project ChalkySticks API
 */
class FetchLive extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'tv:fetchlive {--create=}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Fetch live items from YouTube for TV';


	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {
		$channels = config('chalkysticks.tv.live');
		$videos = [];

		foreach ($channels as $channelId) {
			$model = Models\TvChannel::where(DB::raw('LOWER(channel_id)'), strtolower($channelId))->first();
			$youtubeId = $model ? $model->youtube_id : $channelId;

			// Fetch videos
			$videos = array_merge($videos, $this->getSource($youtubeId));
		}

		// Remove old videos
		$this->removeOldVideos($videos);

		// Add new videos
		foreach ($videos as $video) {
			$this->addVideoToSchedule($video);
		}

		print_r($videos);
	}

	/**
	 * Add a VideoMeta to the TV Schedule database
	 *
	 * @param VideoMeta $videoMeta
	 * @return void
	 */
	protected function addVideoToSchedule($video) {
		// Convert the video URL into a normalized YouTube embed
		$url = $this->convertYoutubeUrl($video->video_url);

		// Add title and description
		$title = $video->title;
		$description = $video->description;

		// Model data
		$data = [
			'air_at' => $video->air_at,
			'description' => $description,
			'duration' => 0,
			'embed_url' => $url,
			'is_live' => true,
			'title' => $title,
			'video_meta' => '',
			'youtube_channel_id' => $video->channel_id,
		];

		// We're not supposed to create
		if (!!!$this->option('create')) {
			$this->line(" 🔸 Would have added: \n $video->title\n$title\n\n");

			return;
		}

		// Create a TvSchedule entry
		try {
			Models\TvSchedule::updateOrCreate(['embed_url' => $url], $data);

			$this->info("Added: $title");
		} catch (QueryException $e) {
			$this->line("Exists $title");
		}
	}

	/**
	 * @param array $newVideos
	 * @return void
	 */
	private function removeOldVideos(array $newVideos = []) {
		if (!!!$this->option('create')) {
			return;
		}

		// Remove anything NOT in the list
		Models\TvSchedule::where('is_live', true)
			->whereNotIn('embed_url', array_map(function ($video) {
				return $this->convertYoutubeUrl($video->video_url);
			}, $newVideos))
			->delete();
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
					'thumbnail_url' => @$video->snippet->thumbnails->standard->url ?? @$video->snippet->thumbnails->medium->url,
					'title' => $video->snippet->channelTitle,
					'video_id' => $video->id,
					'video_url' => 'https://www.youtube.com/embed/' . $video->id,
				];

				$videos[] = $data;
			}
		}

		return $videos;
	}

	/**
	 * Convert a YouTube URL into an embed URL
	 *
	 * @param string $url
	 * @return string
	 */
	private function convertYoutubeUrl(string $url): string {
		if (strpos($url, '?v')) {
			parse_str(parse_url($url, PHP_URL_QUERY), $get_parameters);
			$video_id = $get_parameters['v'];
			$url = 'https://youtube.com/embed/' . $video_id;
		}

		return $url;
	}
}

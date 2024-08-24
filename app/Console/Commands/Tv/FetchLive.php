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
		$channels = config('chalkysticks.tv.channels');
		$videos = [];

		foreach ($channels as $channelId) {
			$model = Models\TvChannel::where(DB::raw('LOWER(channel_id)'), strtolower($channelId))->first();
			$youtubeId = $model ? $model->youtube_id : '';

			if (!empty($youtubeId)) {
				$videos = array_merge($videos, $this->getSource($youtubeId));
			}
		}


		echo "We would save these live videos.";

		print_r($videos);
	}

	/**
	 * Add a VideoMeta to the TV Schedule database
	 *
	 * @param VideoMeta $videoMeta
	 * @return void
	 */
	protected function addVideoToSchedule(VideoMeta $videoMeta) {
		// If there are no players or game, then escape
		if ($this->isVideoWorthSaving($videoMeta) === false) {
			$this->line("Skipping: $videoMeta->title");

			return;
		}

		// Convert the video URL into a normalized YouTube embed
		$url = $this->convertYoutubeUrl($videoMeta->video_url);

		// Add video meta if we have some
		$video_meta = "{ \"game_type\": \"$videoMeta->game_type\" }";

		// Add title and description
		$title = $this->createTitleFromVideoMeta($videoMeta);
		$description = $this->createDescriptionFromVideoMeta($videoMeta);

		// Model data
		$data = [
			'description' => $description,
			'duration' => $videoMeta->duration,
			'embed_url' => $url,
			'title' => $title,
			'video_meta' => $video_meta,
		];

		// We're not supposed to create
		if (!!!$this->option('create')) {
			$this->line(" 🔸 Would have added: \n $videoMeta->title\n$title\n\n");

			return;
		}

		// Create a TvSchedule entry
		try {
			Models\TvSchedule::create($data);

			$this->info("Added: $title");
		} catch (QueryException $e) {
			$this->line("Exists $title");
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
					'description' => $video->snippet->description,
					'duration' => 0,
					'thumbnail_url' => @$video->snippet->thumbnails->standard->url ?? @$video->snippet->thumbnails->medium->url,
					'title' => $video->snippet->channelTitle,
					'video_id' => $video->id->videoId,
					'video_url' => 'https://www.youtube.com/embed/' . $video->id->videoId,
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

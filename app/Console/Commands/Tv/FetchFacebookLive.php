<?php

namespace App\Console\Commands\Tv;

use App\Models;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

/**
 * php artisan tv:fetchfacebooklive --create=true
 *
 * @class FetchFacebookLive
 * @package Console/Commands/Tv
 * @project ChalkySticks API
 */
class FetchFacebookLive extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'tv:fetchfacebooklive {--create=}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Fetch live items from Facebook for TV';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {
		// Log to laravel.log
		Log::info("Fetching live videos from Facebook at " . date('Y-m-d H:i:s'));

		// Only has a URL and title
		$videos = $this->getFacebookVideos();

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
	protected function addVideoToSchedule(object $video) {
		$description = $video->title;
		$thumbnail_url = $video->thumbnail_url;
		$title = $video->title;
		$url = $video->url;

		// Model data
		$data = [
			'description' => $description,
			'duration' => 0,
			'embed_url' => $url,
			'thumbnail_url' => $thumbnail_url,
			'is_live' => true,
			'title' => $title,
			'video_meta' => '',
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
				return $video->url;
			}, $newVideos))
			->where('embed_url', 'like', '%facebook.com%')
			->delete();
	}

	/**
	 * Fetch videos from user accounts or playlists and format them into a
	 * video object
	 *
	 * @return array
	 */
	private function getFacebookVideos() {
		$videos = [];

		// Get all live videos
		$PAGE_ACCESS_TOKEN = config('services.facebook.page.access_token');
		$PAGE_ID = 'chalkysticks';
		$url = "https://graph.facebook.com/v20.0/{$PAGE_ID}/feed?fields=message,attachments,created_time,is_hidden,is_expired,is_published&access_token={$PAGE_ACCESS_TOKEN}";

		$response = file_get_contents($url);
		$json = (object) json_decode($response);
		$posts = $json->data;

		// Find the shared video post
		$embeddable = array_filter(array_map(function ($post) {
			$item = @$post->attachments->data[0];
			$timeSince = time() - strtotime($post->created_time);

			// Was posted within last 3 days
			if ($timeSince > 60 * 60 * 24 * 3) {
				return null;
			}

			// Validate the content
			if (
				isset($item->target)
				&& strpos($item->type, 'video') !== false
				&& $post->is_hidden === false
				&& $post->is_expired === false
				&& $post->is_published
			) {
				return (object) [
					'created_at' => $post->created_time,
					'description' => $post->message ?? '',
					'thumbnail_url' => $item->media->image->src ?? '',
					'title' => $item->title ?? '',
					'url' => $item->target->url,
					'video_id' => $item->target->id,
				];
			}
			return null;
		}, $posts));

		// Remove items that don't have a title
		$embeddable = array_filter($embeddable, function ($item) {
			return !!$item->title;
		});

		$output = [];

		// Fetch all videos to make sure they're embeddable and dont have duration
		foreach ($embeddable as $item) {
			// including "embeddable" fails sometimes
			$url = "https://graph.facebook.com/v20.0/{$item->video_id}?fields=format,length,embeddable&access_token={$PAGE_ACCESS_TOKEN}";

			try {
				$response = file_get_contents($url);
				$json = (object) json_decode($response);

				// Less than an hour
				if ($json->length > 60 * 60 || $json->length < 1) {
					$output[] = $item;
				}
			} catch (\Exception $e) {
				// Do nothing
			}
		}

		return $output;
	}
}

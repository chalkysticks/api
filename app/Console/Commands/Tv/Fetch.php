<?php

namespace App\Console\Commands\Tv;

use App\Models;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;

class VideoMeta {
	public $duration;
	public $game_type;
	public $player1;
	public $player2;
	public $players;
	public $thumbnail;
	public $title;
	public $video_url;
	public $year;
}

class VideoObject {
	public $description;
	public $duration;
	public $publishedAt;
	public $statistics;
	public $thumbnail_url;
	public $title;
	public $video_id;
	public $video_url;
}

/**
 * @todo Can we add a YouTube search to this as well?
 *
 * @class Fetch
 * @package Console/Commands/News
 * @project ChalkySticks API
 */
class Fetch extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'tv:fetch {--cache=} {--create=}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Fetch sources from YouTube for TV';

	/**
	 * Email recipients.
	 *
	 * @var array
	 */
	protected $emails = [
		'matt@chalkysticks.com',
	];

	/**
	 * Where to store our fetch videos JSON
	 *
	 * @var string
	 */
	private $fetchedVideosPath;

	/**
	 * @constructor
	 */
	public function __construct() {
		parent::__construct();

		$this->fetchedVideosPath = storage_path('app/fetched_videos.json');
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {
		$channels = config('tv.youtube.channels');
		$videos = [];

		// Get cached videos so we don't call YouTube too often
		if ($this->isCached()) {
			$videos = json_decode(file_get_contents($this->fetchedVideosPath));
		}

		// Fetch new data from YouTube
		else {
			foreach ($channels as $channel) {
				$videos = array_merge($videos, $this->getSource($channel));
			}

			// Save videos to cached file
			$content = json_encode($videos);
			file_put_contents($this->fetchedVideosPath, $content);
		}

		// Save videos to our database
		foreach ($videos as $video) {
			$videoMeta = $this->parseVideoObject($video);

			// Create a new schedule item
			$this->addVideoToSchedule($videoMeta);
		}
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
	 * @return bool
	 */
	private function isCached() {
		return $this->option('cache')
			&& file_exists($this->fetchedVideosPath)
			&& time() - filemtime($this->fetchedVideosPath) <= 500;
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

		// If it's too long, it may not be a channel
		if (strlen($channel) > 22) {
			$json = (object) [
				'items' => [
					(object) [
						'contentDetails' => (object) [
							'relatedPlaylists' => (object) [
								'uploads' => $channel
							]
						]
					]
				]
			];

			$this->line("Getting channel $channel");
		}

		// It's probably a user's channel
		else {
			$json = $this->fetchJson('https://www.googleapis.com/youtube/v3/channels?part=contentDetails&forUsername=' . $channel . '&key=' . config('google.youtube.api_key'));

			$this->line("Getting user $channel");
		}

		// If we received items from our API call...
		if ($json !== false && isset($json->items) && count($json->items)) {
			$playlist_id = $json->items[0]->contentDetails->relatedPlaylists->uploads;

			// Debug to channel
			$this->info("  + Items from $playlist_id");

			// Fetch items from playlist
			if (!empty($playlist_id)) {
				$playlist_url = 'https://www.googleapis.com/youtube/v3/playlistItems?maxResults=50&part=snippet,status,contentDetails&playlistId=' . $playlist_id . '&key=' . config('google.youtube.api_key');

				// Merge videos from the playlist
				$videos = array_merge($videos, $this->getVideoDataFromPlaylist($playlist_url));

				// Debug
				$this->line("  + Items Received.");
			}
		}

		return $videos;
	}

	/**
	 * Get video data from playlist
	 *
	 * @param string playlist_url
	 * @return array
	 */
	private function getVideoDataFromPlaylist(string $playlist_url) {
		$videos = [];

		// Request JSON data from YouTube playlist url
		$json = (object) $this->fetchJson($playlist_url);

		// There were no videos available
		if ($json === false || (array) $json === []) {
			return $videos;
		}

		// cycle through items
		foreach ($json->items as $item) {
			// We can only accept publicly viewable videos
			if ($item->status->privacyStatus == 'public') {
				$videoId = $item->contentDetails->videoId;
				$videoUrl = "https://www.googleapis.com/youtube/v3/videos?id=$videoId&part=status,snippet,contentDetails,statistics&key=" . config('google.youtube.api_key');
				$videoJson = $this->fetchJson($videoUrl);

				// Get first video object
				$video = $videoJson->items[0];

				// Parse duration
				$duration = $this->convertYoutubeDuration($video->contentDetails->duration);

				// It's a usable object
				if ($this->isVideoSourceUsable($video)) {
					$data = (object) [
						'description' => $video->snippet->description,
						'duration' => $duration,
						'publishedAt' => $video->snippet->publishedAt,
						'statistics' => $video->statistics,
						'thumbnail_url' => @$video->snippet->thumbnails->standard->url,
						'title' => $video->snippet->title,
						'video_id' => $videoId,
						'video_url' => 'https://www.youtube.com/embed/' . $videoId,
					];

					$videos[] = $data;
				}
			}

			// Not public
			else {
				$this->line("  - Video is not public: $item->contentDetails->videoId");
			}
		}

		return $videos;
	}

	/**
	 * Cleans the title of a video to normalize it
	 *
	 * @param string $name
	 * @return string
	 */
	private function cleanName(string $name): string {
		$name = preg_replace('/[^a-zA-Z ]/', '', $name);
		$name = preg_replace('/(qf|set|gambling|gamble|classic|tournament|qualifying|qualifier|semi-final|semifinal|ball|part|final|finals|Championship|8-ball|9-ball|10-ball|snooker|blackball|billiards|team|teams|match|matches|world)/is', '', $name);
		$name = preg_replace('/ (?![vs])[a-z]{1,2}[^a-zA-Z]/is', ' ', $name);
		$name = preg_replace('/ [a-zA-Z] ?$/is', ' ', $name);

		return (string) $name;
	}

	/**
	 * Convert the YouTube style duration to a more reasonable one
	 *
	 * @param string $duration
	 * @return float|int
	 */
	private function convertYoutubeDuration(string $duration): float|int {
		preg_match('/PT(?:(\d+)H)?(?:(\d+)M)?(?:(\d+)S)?/is', $duration, $matches);
		array_shift($matches);
		$matches[0] = @$matches[0] ?: 0;
		$matches[1] = @$matches[1] ?: 0;
		$matches[2] = @$matches[2] ?: 0;
		$duration = ($matches[0] * 60 * 60) + ($matches[1] * 60) + $matches[2];

		return $duration;
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

	/**
	 * Create a description for the video file
	 *
	 * @param VideoMeta $videoMeta
	 * @return string
	 */
	private function createDescriptionFromVideoMeta(VideoMeta $videoMeta): string {
		$description = trim($videoMeta->year . ' ' . ucwords($videoMeta->game_type));
		$description = preg_replace('/\s+/', ' ', $description);
		return $description;
	}

	/**
	 * Create a title for the video file
	 *
	 * @param VideoMeta $videoMeta
	 * @return string
	 */
	private function createTitleFromVideoMeta(VideoMeta $videoMeta): string {
		$title = trim("$videoMeta->player1 vs $videoMeta->player2");
		$title = preg_replace('/\s+/', ' ', $title);
		return $title;
	}

	/**
	 * Fetch JSON from remote url
	 *
	 * @param string $url
	 * @return array
	 */
	private function fetchJson(string $url): object {
		try {
			$response = file_get_contents($url);
		} catch (\Exception $e) {
			return (object) [];
		}

		return json_decode($response);
	}

	/**
	 * Check if a video is usable
	 *
	 * @param object $video
	 * @return bool
	 */
	private function isVideoSourceUsable(object $video): bool {
		return $video->status->embeddable == true && $video->status->privacyStatus == 'public';
	}

	/**
	 * Video isn't worth saving if we don't have players and a game type
	 *
	 * @param VideoMeta $videoMeta
	 * @return bool
	 */
	private function isVideoWorthSaving(VideoMeta $videoMeta): bool {
		return (empty($videoMeta->player1) || empty($videoMeta->player2) || empty($videoMeta->game_type)) === false;
	}

	/**
	 * Parse our video object content
	 *
	 * @param VideoObject
	 * @return VideoMeta
	 */
	private function parseVideoObject($video): VideoMeta {
		// Defaults
		$type = '8-ball';
		$players = $player1 = $player2 = '';

		// Remove non alpha numeric characters, periods, and # signs
		$tmp_title = preg_replace('/[^0-9a-zA-Z -\/.:\!#\|\']/', '', $video->title);

		// Normalize the versus
		$tmp_title = preg_replace('/ (v|V|vs|Vs)\.? /', ' vs ', $tmp_title);
		$tmp_title = str_replace(' Vs ', ' vs ', $tmp_title);

		// Reduce spaces
		$tmp_title = preg_replace('/\s+/', ' ', $tmp_title);

		// Try to determine the type of game we're playing
		if (preg_match('/(8|9|10)[ -]?ball/im', $tmp_title, $m)) {
			$type = $m[1] . '-ball';
		} else if (preg_match('/14\.1/im', $tmp_title)) {
			$type = 'straight pool';
		} else if (preg_match('/snooker/im', $tmp_title)) {
			$type = 'snooker';
		} else if (preg_match('/(3[ -]cushion|billiards)/im', $tmp_title)) {
			$type = 'billiards';
		} else if (preg_match('/(1[ -]pocket| 1p|1pocket)/im', $tmp_title)) {
			$type = '1-pocket';
		}

		// Try to extract the year if it exists
		if (preg_match('/(19|20)[0-9]{2}/im', $tmp_title, $m)) {
			$year = $m[0];
		} else {
			$year = '';
		}

		// Extract the player names
		preg_match('/((([a-zA-Z\.\-\']+)[ \/]?){1,5}) (?:(vs|v)) ((([a-zA-Z\.\-\']+)[ \/]?){1,5})/im', $tmp_title, $p);

		if (count($p)) {
			$players = $this->cleanName($p[0]);
			$player1 = $this->cleanName($p[1]);
			$player2 = $this->cleanName($p[5]);
		} else {
			preg_match('/((([a-zA-Z\.\-\']+)[ \/]?){1,5}) (?:(-)) ((([a-zA-Z\.\-\']+)[ \/]?){1,5})/im', $tmp_title, $p);

			if (count($p)) {
				$players = $this->cleanName($p[0]);
				$player1 = $this->cleanName($p[1]);
				$player2 = $this->cleanName($p[5]);
			}
		}

		// Clean up the player names
		$player1 = ucwords(strtolower($player1));
		$player2 = ucwords(strtolower($player2));

		// Create a VideoMeta struct
		$videoMeta = new VideoMeta();
		$videoMeta->duration = $video->duration;
		$videoMeta->game_type = $type;
		$videoMeta->player1 = $player1;
		$videoMeta->player2 = $player2;
		$videoMeta->players = $players;
		$videoMeta->thumbnail = $video->thumbnail_url;
		$videoMeta->title = $video->title;
		$videoMeta->video_url = $video->video_url;
		$videoMeta->year = @$year;

		return $videoMeta;
	}
}

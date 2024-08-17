<?php

namespace App\Console\Commands\Tv;

use App\Models;
use Illuminate\Console\Command;

/**
 * @todo Can we add a YouTube search to this as well?
 *
 * @class Fetch
 * @package Console/Commands/News
 * @project ChalkySticks API
 */
class Channels extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'tv:channels';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Get data from the channels we use';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {

		$channels = config('tv.youtube.channels');
		$videos = [];

		foreach ($channels as $channelId) {
			$json = $this->fetchYouTube($channelId);

			// No results, skip
			if ($json->pageInfo->totalResults === 0) {
				continue;
			}

			$item = $json->items[0];
			$data = [
				'title' => $item->snippet->title,
				'description' => $item->snippet->description,
				'channel_id' => $item->snippet->customUrl,
				'image_url' => ($item->snippet->thumbnails->medium ?: $item->snippet->thumbnails->default)->url,
			];

			Models\TvChannel::updateOrCreate(['youtube_id' => $item->id], $data);
		}
	}

	/**
	 * @param string channelId
	 * @param int $attempt
	 * @return object
	 */
	private function fetchYouTube(string $channelId, int $attempt = 0): object {
		$apiKey = config('google.youtube.api_key');
		$queryString = ['forUsername', 'forHandle'];
		$url = "https://www.googleapis.com/youtube/v3/channels?part=snippet&$queryString[$attempt]=$channelId&key=$apiKey";

		$json = $this->fetchJson($url);

		if ($json->pageInfo->totalResults === 0 && $attempt < count($queryString) - 1) {
			return $this->fetchYouTube($channelId, $attempt + 1);
		}

		return $json;
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
}

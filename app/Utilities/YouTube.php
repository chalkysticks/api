<?php

namespace App\Utilities;

/**
 * mk: Look into this: https://www.youtube.com/feeds/videos.xml?channel_id=UCKrCJRIeICr4VyYbDL5KwSA
 * And this: https://developers.google.com/youtube/v3/guides/push_notifications
 *
 * @class YouTube
 * @package Utilities
 * @project ChalkySticks API
 */
class YouTube {
	/**
	 * @param string $channelId
	 * @param string $part
	 * @param int $attempt
	 * @return object
	 */
	public static function fetchChannel(string $channelId, string $part = 'snippet', int $attempt = 0): object {
		$apiKey = config('google.youtube.api_key');
		$queryString = ['id', 'forUsername', 'forHandle'];
		$url = "https://www.googleapis.com/youtube/v3/channels?part={$part}&$queryString[$attempt]=$channelId&key=$apiKey";
		$json = fetchJson($url);

		if (!$json) {
			throw new \Exception("Quota may have expired. Could not fetch $channelId");
		}

		if (!@$json->pageInfo && $attempt < count($queryString) - 1) {
			return self::fetchChannel($channelId, $part, $attempt + 1);
		} else if (@$json->pageInfo->totalResults === 0 && $attempt < count($queryString) - 1) {
			return self::fetchChannel($channelId, $part, $attempt + 1);
		}

		return $json;
	}

	/**
	 * @param string $channelId
	 * @return object
	 */
	public static function fetchLiveChannel(string $channelId = ''): object {
		// If it's a username instead of a channel ID, convert it
		if (strlen($channelId) != 24) {
			$channelId = self::getChannelIdFromIdentifier($channelId);
		}

		// If not channel id, return empty
		if (empty($channelId)) {
			return (object) [
				'items' => []
			];
		}

		try {
			$rssUrl = "https://www.youtube.com/feeds/videos.xml?channel_id=$channelId";
			$rssContent = file_get_contents($rssUrl);

			if ($rssContent === false) {
				throw new \Exception('Failed to fetch RSS feed');
			}

			$xml = new \SimpleXMLElement($rssContent);
			$videos = [];

			foreach ($xml->entry as $entry) {
				$videoId = (string) $entry->children('yt', true)->videoId;
				$videos[$videoId] = (object) [
					'url' => "https://www.youtube.com/watch?v=$videoId",
					'entry' => $entry
				];
			}

			$liveStreams = self::checkLiveStreamsParallel($videos);

			return (object) [
				'items' => $liveStreams
			];

		} catch (\Exception $e) {
			\Log::error('Error checking for live streams: ' . $e->getMessage());
			return (object) [
				'items' => []
			];
		}
	}

	// public static function fetchLiveChannel(string $channelId, string $part = 'snippet'): object {
	// 	$apiKey = config('google.youtube.api_key');

	// 	// Wrong type of channel ID
	// 	if (strlen($channelId) < 20) {
	// 		$channel = self::fetchChannel($channelId);
	// 		$channelId = @$channel->items[0]->id;
	// 	}

	// 	try {
	// 		// Step 1: Get the channel's uploads playlist ID
	// 		$channelUrl = "https://www.googleapis.com/youtube/v3/channels?part=contentDetails&id=$channelId&key=$apiKey";
	// 		$channelJson = fetchJson($channelUrl);

	// 		if (empty($channelJson->items)) {
	// 			throw new \Exception('Channel not found');
	// 		}

	// 		$uploadsPlaylistId = $channelJson->items[0]->contentDetails->relatedPlaylists->uploads;

	// 		// Step 2: Get the latest videos from the uploads playlist
	// 		$playlistUrl = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId=$uploadsPlaylistId&maxResults=10&key=$apiKey";
	// 		$playlistJson = fetchJson($playlistUrl);

	// 		// Step 3: Check each video for live status
	// 		$liveStreams = [];
	// 		foreach ($playlistJson->items as $item) {
	// 			$videoId = $item->snippet->resourceId->videoId;
	// 			$videoUrl = "https://www.googleapis.com/youtube/v3/videos?part=snippet,liveStreamingDetails&id=$videoId&key=$apiKey";
	// 			$videoJson = fetchJson($videoUrl);

	// 			if (!empty($videoJson->items) &&
	// 				!empty($videoJson->items[0]->liveStreamingDetails) &&
	// 				!empty($videoJson->items[0]->liveStreamingDetails->actualStartTime)) {

	// 				$now = new \DateTime();
	// 				$startTime = new \DateTime($videoJson->items[0]->liveStreamingDetails->actualStartTime);
	// 				$endTime = !empty($videoJson->items[0]->liveStreamingDetails->actualEndTime)
	// 					? new \DateTime($videoJson->items[0]->liveStreamingDetails->actualEndTime)
	// 					: null;

	// 				if ($startTime <= $now && (!$endTime || $endTime > $now)) {
	// 					$liveStreams[] = (object) $videoJson->items[0];
	// 				}
	// 			}
	// 		}

	// 		return (object) [
	// 			'items' => $liveStreams
	// 		];

	// 	} catch (\Exception $e) {
	// 		\Log::error('Error checking for live streams: ' . $e->getMessage());
	// 		return (object) [
	// 			'items' => []
	// 		];
	// 	}
	// }

	/**
	 * We removed Search because it costs YouTube APIs 100 units per call.
	 * The new one should cost up to 10.
	 */
	// public static function fetchLiveChannel(string $channelId, string $part = 'snippet'): object {
	// 	$apiKey = config('google.youtube.api_key');

	// 	// Wrong type of channel ID
	// 	if (strlen($channelId) < 20) {
	// 		$channel = self::fetchChannel($channelId);
	// 		$channelId = @$channel->items[0]->id;
	// 	}

	// 	// Fetch channel
	// 	$url = "https://www.googleapis.com/youtube/v3/search?part=$part&channelId=$channelId&videoEmbeddable=true&eventType=live&type=video&key=$apiKey";
	// 	$json = fetchJson($url);

	// 	return $json;
	// }

	/**
	 * @param string $youtubeUrl
	 * @param int $attempt
	 * @return object
	 */
	public static function fetchVideo(string $youtubeUrl): object {
		$apiKey = config('google.youtube.api_key');
		$youtubeId = self::parseId($youtubeUrl);
		$url = "https://www.googleapis.com/youtube/v3/videos?part=snippet&id=$youtubeId&key=$apiKey";
		$json = fetchJson($url);

		return $json;
	}

	/**
	 * @param string $youtubeUrl
	 * @return string
	 */
	public static function parseId(string $youtubeUrl): string {
		$regexp = '/(?:youtube(?:-nocookie)?\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i';

		if (preg_match($regexp, $youtubeUrl, $matches)) {
			return $matches[1];
		}

		return '';
	}

	private static function checkLiveStreamsParallel(array $videos): array {
		$mh = curl_multi_init();
		$curlHandles = [];
		$liveStreams = [];

		// Setup curl handles
		foreach ($videos as $videoId => $video) {
			$ch = curl_init($video->url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 5);
			curl_multi_add_handle($mh, $ch);
			$curlHandles[$videoId] = $ch;
		}

		// Execute parallel requests
		$running = null;

		do {
			curl_multi_exec($mh, $running);
		} while ($running);

		// Process results
		foreach ($curlHandles as $videoId => $ch) {
			$html = curl_multi_getcontent($ch);

			if (self::isLiveStream($html)) {
				$liveStreams[] = (object) [
					'id' => $videoId,
					'liveStreamingDetails' => (object) ['actualStartTime' => date('c')],
					'snippet' => (object) [
						'channelTitle' => (string) $video->entry->author->name,
						'description' => (string) $video->entry->author->name,
						'duration' => 0,
						'publishTime' => (string) $video->entry->published,
						'resourceId' => (object) ['videoId' => $videoId],
						'thumbnail' => "https://i.ytimg.com/vi/$videoId/hqdefault.jpg",
						'title' => (string) $video->entry->title,
					],
				];
			}

			curl_multi_remove_handle($mh, $ch);
		}

		curl_multi_close($mh);

		return $liveStreams;
	}

	/**
	 * Attempt to get channel id from the username
	 *
	 * @param string $username
	 * @throws \Exception
	 * @return string
	 */
	private static function getChannelIdFromIdentifier(string $identifier): string {
		// If it's already a channel ID, return it
		if (preg_match('/^UC[a-zA-Z0-9_-]{22}$/', $identifier)) {
			return $identifier;
		}

		$possibleUrls = [
			"https://www.youtube.com/c/$identifier",
			"https://www.youtube.com/user/$identifier",
			"https://www.youtube.com/@$identifier",
			"https://www.youtube.com/channel/$identifier"
		];

		foreach ($possibleUrls as $url) {
			$html = @file_get_contents($url);
			if ($html !== false) {
				if (preg_match('/"channelId":"(UC[a-zA-Z0-9_-]{22})"/', $html, $matches)) {
					return $matches[1];
				}
			}
		}

		return '';
	}

	/**
	 * Fetch a webpage to see if it says anything about streaming
	 *
	 * @param string $html
	 * @return bool
	 */
	private static function isLiveStream(string $html): bool {
		$liveIndicators = [
			'started streaming',
			// 'is live',
			// 'live now',
			// '"isLive":true'
		];

		foreach ($liveIndicators as $indicator) {
			if (stripos($html, $indicator) !== false) {
				return true;
			}
		}

		return false;
	}
}

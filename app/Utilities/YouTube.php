<?php

namespace App\Utilities;

/**
 * @class YouTube
 * @package Utilities
 * @project ChalkySticks API
 */
class YouTube {
	/**
	 * @param string channelId
	 * @param int $attempt
	 * @return object
	 */
	public static function fetchChannel(string $channelId, int $attempt = 0): object {
		$apiKey = config('google.youtube.api_key');
		$queryString = ['id', 'forUsername', 'forHandle'];
		$url = "https://www.googleapis.com/youtube/v3/channels?part=snippet&$queryString[$attempt]=$channelId&key=$apiKey";
		$json = fetchJson($url);

		if ($json->pageInfo->totalResults === 0 && $attempt < count($queryString) - 1) {
			return self::fetchChannel($channelId, $attempt + 1);
		}

		return $json;
	}

	/**
	 * @param string youtubeUrl
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
}

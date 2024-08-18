<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\ModelInterfaces;
use App\Models;
use Illuminate\Support\Collection;

/**
 * @class Tv
 * @package Http/Controllers/v1
 * @project ChalkySticks API
 */
class Tv extends Controller {
	/**
	 * @return \Illuminate\Http\Response
	 */
	public function getSchedule() {
		$payload = (object) $this->payload([
			'order' => ['string'],
			'channel' => ['string']
		]);

		$idMin = $this->getMinID();
		$idMax = $this->getMaxID();
		$channel = $payload->channel ?? '';

		// the 18000 represents -5 hours
		// if we reset it at midnight UTC, that's 5am East and 2am West.
		// which is a bad time to reset the playlist.
		$collection = Models\TvSchedule::where('is_live', null)
			->where('flags', '<', '3')
			->where('video_meta', 'like', "%$channel%")
			->where('id', '>=', $idMin)
			->where('id', '<=', $idMax)
			->get();

		// Randomize
		$shuffledCollection = $this->randomize($collection);

		// Slice down to 24 hours
		$reducedCollection = $this->reduce($shuffledCollection);

		return $this->collection($reducedCollection, new ModelInterfaces\TvSchedule);
	}

	/**
	 * @return \Illuminate\Http\Response
	 */
	public function postSchedule() {
		$payload = (object) $this->payload([
			'description' => ['string'],
			'game_type' => ['string'],
			'title' => ['string'],
			'youtube_video_url' => ['required', 'string'],
		]);

		// Get YouTube URL
		$url = $payload->youtube_video_url;

		// Convert url to an embed URL
		if (strpos($url, '?v')) {
			parse_str(parse_url($url, PHP_URL_QUERY), $get_parameters);
			$video_id = $get_parameters['v'];
			$url = 'https://youtube.com/embed/' . $video_id;
		}

		// Data
		$description = @$payload->description;
		$seconds = $this->youtubeVideoDuration($url);
		$title = @$payload->title;
		$videoMeta = isset($payload->game_type) ? '{ "game_type": "' . $payload->game_type . '" }' : '';

		$model = Models\TvSchedule::create([
			'description' => $description,
			'duration' => $seconds,
			'embed_url' => $url,
			'title' => $title,
			'video_meta' => $videoMeta,
		]);

		return $this->model($model, new ModelInterfaces\TvSchedule);
	}

	/**
	 * @param mixed $id
	 * @return \Illuminate\Http\Response
	 */
	public function deleteSchedule(string|int $id) {
		$payload = (object) $this->payload([
			'force' => ['string']
		]);

		// Actually remove the item
		if (isset($payload->force)) {
			$model = Models\TvSchedule::find($id);
			$model->delete();
		}

		// Flag it for removal later
		else {
			$model = Models\TvSchedule::find($id);
			$model->flags = (int) $model->flags + 1;
			$model->save();
		}

		return $this->model($model, new ModelInterfaces\TvSchedule);
	}


	// Helpers
	// ---------------------------------------------------------------------

	/**
	 * Get duration of a YouTube video from the API in seconds
	 *
	 * @param string $videoUrl
	 * @return int
	 */
	protected function youtubeVideoDuration(string $videoUrl): int {
		$apiKey = config('google.youtube.api_key');

		// VideoID from url
		if (strpos($videoUrl, '?v')) {
			parse_str(parse_url($videoUrl, PHP_URL_QUERY), $get_parameters);
			$videoId = $get_parameters['v'];
		} else {
			$parts = explode('embed/', $videoUrl);
			$videoId = end($parts);
		}

		// JSON data from API
		$json_result = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=contentDetails&id=$videoId&key=$apiKey");
		$result = json_decode($json_result, true);

		// video duration data
		if (!count($result['items'])) {
			return 0;
		}

		$duration_encoded = $result['items'][0]['contentDetails']['duration'];
		$interval = new \DateInterval($duration_encoded);
		$seconds = $interval->days * 86400 + $interval->h * 3600 + $interval->i * 60 + $interval->s;

		return $seconds;
	}

	/**
	 * Reduce the collection to fit within 24 hours.
	 *
	 * @param Collection $collection
	 * @return Collection
	 */
	protected function reduce(Collection $collection): Collection {
		$dayInSeconds = 86400; // 24 hours in seconds
		$currentTime = 0;

		// Use Laravel's collection takeWhile method for clarity and efficiency
		return $collection->takeWhile(function ($model) use (&$currentTime, $dayInSeconds) {
			$currentTime += $model->duration;
			return $currentTime <= $dayInSeconds;
		});
	}

	/**
	 * Randomize the collection based on a seeded key.
	 *
	 * @param Collection $collection
	 * @return Collection
	 */
	protected function randomize(Collection $collection): Collection {
		$key = $this->getRandomKey();
		$seed = crc32($key);

		// Seed the random number generator and shuffle the collection
		mt_srand($seed);

		// Convert the collection to an array and manually shuffle it
		$models = $collection->all();
		usort($models, function () {
			return mt_rand(-1, 1);
		});

		// Reset the RNG
		mt_srand();

		return collect($models);
	}

	/**
	 * @return float
	 */
	protected function getStartTime(): float {
		return floatval($this->_filter('start-time'));
	}

	/**
	 * @return float
	 */
	protected function getEndTime(): float {
		return floatval($this->_filter('end-time'));
	}

	/**
	 * @return int
	 */
	protected function getMinID() {
		return $this->_filter('id-min') ?? 1;
	}

	/**
	 * @return int
	 */
	protected function getMaxID() {
		return $this->_filter('id-max') ?? 999999;
	}

	/**
	 * @return string
	 */
	protected function getRandomKey() {
		return date('Y-m-d') ?? $this->_filter('random-key');
	}

	/**
	 * @return int
	 */
	/**
	 * @return int
	 */
	protected function getTimeDifference(): int {
		return time() - strtotime("today");
	}

	/**
	 * @param string $key
	 * @return mixed
	 */
	protected function _filter(string $key) {
		$settings = Models\TvSetting::all();

		foreach ($settings as $model) {
			if ($model->key == $key)
				return $model->value;
		}
	}
}

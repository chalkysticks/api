<?php

namespace App\ModelInterfaces;

use App\Core\Data\ModelInterface;
use App\Models;

/**
 * @class Feed
 * @package ModelInterfaces
 * @project ChalkySticks API
 */
class Feed extends ModelInterface {
	/**
	 * @param Models\Feed $model
	 * @param object $json
	 * @return string
	 */
	protected function formatVenueAdd(Models\Feed $model, object $json): string {
		$data = [
			'name' => $json->name,
			'type' => $json->type,
			'url' => '/places/' . $json->id,
		];

		return $this->translate(Models\Feed::TYPE_VENUE_ADD, $data);
	}

	/**
	 * @param Models\Feed $model
	 * @param object $json
	 * @return string
	 */
	protected function formatVenueMediaAdd(Models\Feed $model, object $json): string {
		$data = [
			'name' => $json->name,
			'url' => '/places/' . $json->id,
		];

		return $this->translate(Models\Feed::TYPE_VENUEMEDIA_ADD, $data);
	}

	/**
	 * @param Models\Feed $model
	 * @param object $json
	 * @return string
	 */
	protected function formatVenueUpdate(Models\Feed $model, object $json): string {
		$data = [
			'name' => $json->name,
			'type' => $json->type,
			'url' => '/places/' . $json->id,
		];

		return $this->translate(Models\Feed::TYPE_VENUE_UPDATE, $data);
	}

	/**
	 * @param Models\Feed $model
	 * @param object $json
	 * @return string
	 */
	protected function formatVenueCheckin(Models\Feed $model, object $json): string {
		$data = [
			'user_name' => $json->user->name,
			'user_url' => '/users/' . $json->user->id,
			'venue_name' => $json->venue->name,
			'venue_url' => '/places/' . $json->venue->id,
		];

		return $this->translate(Models\Feed::TYPE_VENUE_CHECKIN, $data);
	}

	/**
	 * @param Models\Feed $model
	 * @param object $json
	 * @return string
	 */
	protected function formatBeaconAdd(Models\Feed $model, object $json): string {
		$data = [
			'name' => $json->user->name,
			'url' => '/users/' . $json->user->id,
		];

		return $this->translate(Models\Feed::TYPE_BEACON_ADD, $data);
	}

	/**
	 * @param Models\Feed $model
	 * @param object $json
	 * @return string
	 */
	protected function formatLeagueAdd(Models\Feed $model, object $json): string {
		$data = [];

		return $this->translate(Models\Feed::TYPE_LEAGUE_ADD, $data);
	}

	/**
	 * @param Models\Feed $model
	 * @param object $json
	 * @return string
	 */
	protected function formatContentAdd(Models\Feed $model, object $json): string {
		$data = [
			'name' => $json->title,
			'url' => '/news/' . $json->id,
		];

		if (isset($json->tags) && $this->hasTag($json->tags->data, 'pool-pad')) {
			$data['url'] = '/poolpad/' . $json->id;
			return $this->translate(Models\Feed::TYPE_CONTENT_PAD, $data);
		} else if (isset($json->tags) && $this->hasTag($json->tags->data, 'news')) {
			return $this->translate(Models\Feed::TYPE_CONTENT_NEWS, $data);
		} else if (isset($json->tags) && $json->media_type == 'video') {
			$data['url'] = '/videos/' . $json->id;
			return $this->translate(Models\Feed::TYPE_CONTENT_VIDEO, $data);
		}

		return $this->translate(Models\Feed::TYPE_CONTENT_ADD, $data);
	}

	/**
	 * @param array $tags
	 * @param string $type
	 * @return bool
	 */
	protected function hasTag(array $tags, string $type): bool {
		foreach ($tags as $tag) {
			if ($tag->tag == $type) {
				return true;
			}
		}

		return false;
	}

	/**
	 * @param int $type
	 * @param array $data
	 * @return string
	 */
	protected function translate(int $type, array $data): string {
		$message = trans('feed.' . $type);

		foreach ($data as $k => $v) {
			$message = str_replace("{{ $k }}", $v, $message);
		}

		return $message;
	}

	/**
	 * Turn this item object into a generic array
	 *
	 * @param Models\Feed $model
	 * @return array
	 */
	public function transform($model) {
		$json = json_decode($model->data);

		switch ($model->type) {
			case Models\Feed::TYPE_VENUE_ADD:
				$message = $this->formatVenueAdd($model, $json);
				break;

			case Models\Feed::TYPE_VENUEMEDIA_ADD:
				$message = $this->formatVenueMediaAdd($model, $json);
				break;

			case Models\Feed::TYPE_VENUE_UPDATE:
				$message = $this->formatVenueUpdate($model, $json);
				break;

			case Models\Feed::TYPE_VENUE_CHECKIN:
				$message = $this->formatVenueCheckin($model, $json);
				break;

			case Models\Feed::TYPE_BEACON_ADD:
				$message = $this->formatBeaconAdd($model, $json);
				break;

			case Models\Feed::TYPE_LEAGUE_ADD:
				$message = $this->formatLeagueAdd($model, $json);
				break;

			case Models\Feed::TYPE_CONTENT_ADD:
				$message = $this->formatContentAdd($model, $json);
				break;
		}

		return [
			'created_at' => (string) $model->created_at,
			'distance' => (float) $model->distance,
			'html_message' => $message ?? '',
			'lat' => (float) $model->lat,
			'lon' => (float) $model->lon,
			'plain_message' => strip_tags($message),
			'type' => (float) $model->type,
			'updated_at' => (string) $model->updated_at,
		];
	}
}

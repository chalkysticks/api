<?php

namespace App\ModelInterfaces;

use App\Core\Data\ModelInterface;
use App\Models;

/**
 * @class User
 * @package ModelInterfaces
 * @project ChalkySticks API
 */
class User extends ModelInterface {
	/**
	 * @var array
	 */
	protected $availableIncludes = [
		'accomplishments',
		'checkins',
		'friends',
	];

	/**
	 * @var array
	 */
	protected $defaultIncludes = [
		'games',
		'media',
		'meta',
	];

	/**
	 * @param Models\User $model
	 * @return \League\Fractal\Resource\Collection
	 */
	public function includeAccomplishments(Models\User $model) {
		$list = [];
		$accomplishments = $model->accomplishments;

		foreach ($accomplishments as $accomplishment) {
			$list[] = $accomplishment->accomplishment;
		}

		return $this->collection($list, new Accomplishment);
	}

	/**
	 * @param Models\User $model
	 * @return \League\Fractal\Resource\Collection
	 */
	public function includeCheckins(Models\User $model) {
		$list = [];
		$checkins = $model->checkins->take(4);

		foreach ($checkins as $checkin) {
			$venue = $checkin->venue;
			$venue->checkin_at = $checkin->created_at;
			$list[] = $venue;
		}

		return $this->collection($list, new Venue);
	}

	/**
	 * @param Models\User $model
	 * @return \League\Fractal\Resource\Collection
	 */
	public function includeFriends(Models\User $model) {
		$friends = $model->friends()->get();

		return $this->collection($friends, new UserFriend);
	}

	/**
	 * @param Models\User $model
	 * @return \League\Fractal\Resource\Collection
	 */
	public function includeGames(Models\User $model) {
		$games = $model->gamesPreferred;

		return $this->collection($games, new Meta);
	}

	/**
	 * @param Models\User $model
	 * @return \League\Fractal\Resource\Collection
	 */
	public function includeMedia(Models\User $model) {
		$media = $model->media;

		return $this->collection($media, new Media);
	}

	/**
	 * @param Models\User $model
	 * @return \League\Fractal\Resource\Collection
	 */
	public function includeMeta(Models\User $model) {
		$meta = $model->profile;

		return $this->collection($meta, new Meta);
	}

	/**
	 * @return array
	 */
	public function transform($model) {
		if (!$model) {
			return [];
		}

		$wallet_balance = $model->walletBalance();
		$last_collection = $model->lastCollection();

		return [
			'id' => (int) $model->id,
			'name' => (string) $model->name,
			'slug' => (string) $model->slug,
			'phone' => (string) $model->phone,
			'lat' => (double) $model->lat,
			'lon' => (double) $model->lon,
			'status' => (string) $model->status,
			'last_collection' => (object) $last_collection,
			'wallet_balance' => (int) $wallet_balance,
			'is_social' => isset($model->social_id),
			'is_facebook' => isset($model->social_id) && strpos($model->social_id, 'facebook') > -1,
			'is_twitter' => isset($model->social_id) && strpos($model->social_id, 'twitter') > -1
		];
	}
}

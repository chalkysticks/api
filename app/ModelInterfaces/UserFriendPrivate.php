<?php

namespace App\ModelInterfaces;

use App\Core\Data\ModelInterface;
use App\Models;

/**
 * @class UserFriendPrivate
 * @package ModelInterfaces
 * @project ChalkySticks API
 */
class UserFriendPrivate extends ModelInterface {
	/**
	 * @var array
	 */
	protected array $defaultIncludes = [
		'friend'
	];

	/**
	 * @param  $model
	 * @return \League\Fractal\Resource\Item
	 */
	public function includeFriend(Models\UserFriend $model) {
		$user = Models\User::fromJWT();

		if ($user->id == $model->user_id) {
			$friend = Models\User::find($model->friend_id);
		} else if ($user->id == $model->friend_id) {
			$friend = Models\User::find($model->user_id);
		} else {
			$friend = new Models\User;
		}

		return $this->model($friend, new UserSimpleWithMedia);
	}

	/**
	 * @return array
	 */
	public function transform($model) {
		return [
			'id' => (int) $model->id,
			'user_id' => (int) $model->user_id,
			'friend_id' => (int) $model->friend_id,
			'status' => (string) $model->status,
			'created_at' => (string) $model->created_at
		];
	}
}

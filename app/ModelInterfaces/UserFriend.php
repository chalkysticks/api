<?php

namespace App\ModelInterfaces;

use App\Core\Data\ModelInterface;
use App\Models;

/**
 * @class UserFriend
 * @package ModelInterfaces
 * @project ChalkySticks API
 */
class UserFriend extends ModelInterface {
	/**
	 * @var array
	 */
	protected array $defaultIncludes = [
		'friend'
	];

	/**
	 * @param Models\UserFriend $model
	 * @return \League\Fractal\Resource\Item
	 */
	public function includeFriend(Models\UserFriend $model) {
		$user = Models\User::fromJWT();
		$friend = null;

		if (isset($user) && isset($model)) {
			if ($user->id == $model->user_id) {
				$friend = Models\User::find($model->friend_id);
			} else if ($user->id == $model->friend_id) {
				$friend = Models\User::find($model->user_id);
			}

			if ($friend) {
				return $this->model($friend, new UserSimpleWithMedia);
			}
		}

		return $this->model(new Models\User, new UserSimpleWithMedia);
	}

	/**
	 * Turn this item object into a generic array
	 *
	 * @return array
	 */
	public function transform($model) {
		return [

		];
	}

}

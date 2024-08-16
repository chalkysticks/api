<?php

namespace App\Collections;

use App\Core\Data\Collection;
use App\Models;

/**
 * @class UserMeta
 * @package Collections
 * @project ChalkySticks API
 */
class UserMeta extends Collection {
	/**
	 * @param mixed $user_id
	 * @param mixed $group
	 * @param mixed $key
	 * @return void
	 */
	public function increment($user_id = null, $group = "", $key = "") {
		$found = $this->filter(function ($model) use ($group, $key) {
			return $model->group = $group && $model->key == $key;
		});

		if (count($found)) {
			foreach ($found as $model) {
				$model->user_id = $user_id;
				$model->group = $group;
				$model->key = $key;
				$model->value = (@$model->value ?: 0) + 1;
				$model->save();
			}
		} else {
			$model = Models\UserMeta::create([
				'user_id' => $user_id,
				'group' => $group,
				'key' => $key,
				'value' => 1
			]);
		}
	}

}

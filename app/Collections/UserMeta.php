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
	 * @param int $user_id
	 * @param string $group
	 * @param string $key
	 * @return void
	 */
	public function increment(int $user_id = null, string $group = '', string $key = '') {
		$found = $this->filter(function ($model) use ($group, $key) {
			return $model->group = $group && $model->key == $key;
		});

		if (count($found)) {
			foreach ($found as $model) {
				$model->group = $group;
				$model->key = $key;
				$model->user_id = $user_id;
				$model->value = (@$model->value ?: 0) + 1;
				$model->save();
			}
		} else {
			$model = Models\UserMeta::create([
				'group' => $group,
				'key' => $key,
				'user_id' => $user_id,
				'value' => 1,
			]);
		}
	}

}

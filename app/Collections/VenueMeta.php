<?php

namespace App\Collections;

use App\Core\Data\Collection;
use App\Models;

/**
 * @class VenueMeta
 * @package Collections
 * @project ChalkySticks API
 */
class VenueMeta extends Collection {
	/**
	 * @param int $venue_id
	 * @param string $group
	 * @param string $key
	 * @return void
	 */
	public function increment(int $venue_id = null, string $group = '', string $key = '') {
		$found = $this->filter(function ($model) use ($group, $key) {
			return $model->group = $group && $model->key == $key;
		});

		if (count($found)) {
			foreach ($found as $model) {
				$model->group = $group;
				$model->key = $key;
				$model->venue_id = $venue_id;
				$model->value = (@$model->value ?: 0) + 1;
				$model->save();
			}
		} else {
			$model = Models\VenueMeta::create(array(
				'group' => $group,
				'key' => $key,
				'value' => 1,
				'venue_id' => $venue_id,
			));
		}
	}
}

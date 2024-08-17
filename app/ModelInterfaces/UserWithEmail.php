<?php

namespace App\ModelInterfaces;

use App\Core\Data\ModelInterface;

/**
 * @class UserWithEmail
 * @package ModelInterfaces
 * @project ChalkySticks API
 */
class UserWithEmail extends ModelInterface {
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
			'email' => (string) $model->email,
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

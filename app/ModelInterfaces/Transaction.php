<?php

namespace App\ModelInterfaces;

use App\Core\Data\ModelInterface;

/**
 * @class Transaction
 * @package ModelInterfaces
 * @project ChalkySticks API
 */
class Transaction extends ModelInterface {
	/**
	 * @return array
	 */
	public function transform($model) {
		return [
			'id' => $model->id,
			'type' => $model->type,
			'type_id' => $model->type_id,
			'status' => $model->status,
			'amount' => $model->amount,
			'currency' => $model->currency,
			'user_id' => $model->user_id,
			'user_email' => $model->user_email,
			'notes' => $model->notes,
			'created_at' => (string) $model->created_at,
			'updated_at' => (string) $model->updated_at,
		];
	}
}

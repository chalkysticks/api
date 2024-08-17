<?php

namespace App\ModelInterfaces;

use App\Core\Data\ModelInterface;

/**
 * @class UserPaymentAccount
 * @package ModelInterfaces
 * @project ChalkySticks API
 */
class UserPaymentAccount extends ModelInterface {
	/**
	 * @return array
	 */
	public function transform($model) {
		return [
			'id' => $model->id,
			'user_id' => $model->user_id,
			'first_name' => $model->first_name,
			'last_name' => $model->last_name,
			'email' => $model->email,
			'country' => $model->country,
			'currency' => $model->currency,
			'dob_month' => $model->dob_month,
			'dob_day' => $model->dob_day,
			'dob_year' => $model->dob_year
		];
	}
}

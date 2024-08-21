<?php

namespace App\ModelInterfaces;

use App\Core\Data\ModelInterface;
use App\Models;

/**
 * @class UserWallet
 * @package ModelInterfaces
 * @project ChalkySticks API
 */
class UserWallet extends ModelInterface {
	/**
	 * @var array
	 */
	protected array $defaultIncludes = [
		'challenger',
	];

	/**
	 * @param Models\User $model
	 * @return \League\Fractal\Resource\Item
	 */
	public function includeChallenger(Models\UserWallet $model) {
		$challenger = $model->challenger ?: new Models\User;

		return $this->model($challenger, new UserSimple);
	}

	/**
	 * @return array
	 */
	public function transform($model) {
		$challenger = $model->challenger;

		return [
			'id' => (int) $model->id,
			'transaction' => (int) $model->transaction,
			'source' => (string) $model->source,
			'source_id' => (int) $model->source_id,
			'created_at' => (string) $model->created_at,
			'updated_at' => (string) $model->updated_at
		];
	}
}

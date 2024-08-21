<?php

namespace App\ModelInterfaces;

use App\Core\Data\ModelInterface;
use App\Models;

/**
 * @class GameMatch
 * @package ModelInterfaces
 * @project ChalkySticks API
 */
class GameMatch extends ModelInterface {
	/**
	 * @var array
	 */
	protected array $availableIncludes = [
		'games',
		'user1',
		'user2'
	];

	/**
	 * @param Models\GameMatch $model
	 * @return \League\Fractal\Resource\Item
	 */
	public function includeUser1(Models\GameMatch $model) {
		return $this->model($model->user1, new User);
	}

	/**
	 * @param Models\GameMatch $model
	 * @return \League\Fractal\Resource\Item
	 */
	public function includeUser2(Models\GameMatch $model) {
		return $this->model($model->user2, new User);
	}

	/**
	 * @param Models\GameMatch $model
	 * @return \League\Fractal\Resource\Collection
	 */
	public function includeGames(Models\GameMatch $model) {
		return $this->collection($model->games, new Game);
	}

	/**
	 * @return array
	 */
	public function transform($model) {
		return [
			'id' => $model->id,
			'is_win' => $model->is_win,
			'is_loss' => $model->is_loss,
			'created_at' => (string) $model->created_at,
			'updated_at' => (string) $model->updated_at,
			'ended_at' => (string) $model->ended_at,
		];
	}
}

<?php

namespace App\Models;

use App\Core\Data\Model;

/**
 * @class GameInning
 * @package Models
 * @project ChalkySticks API
 */
class GameInning extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'innings';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['game_id', 'user_id', 'shots_taken', 'is_win', 'is_loss'];

	// Relationships
	// -----------------------------------------------------------------------

	public function game() {
		return $this->hasOne(Game::class, 'id', 'game_id');
	}

	public function user() {
		return $this->hasOne(User::class, 'id', 'user_id');
	}
}

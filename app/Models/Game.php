<?php

namespace App\Models;

use App\Core\Data\Model;

/**
 * @class Game
 * @package Models
 * @project ChalkySticks API
 */
class Game extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'games';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['match_id', 'user1_id', 'user2_id', 'is_win', 'is_loss'];

	// Relationships
	// -----------------------------------------------------------------------

	public function innings() {
		return $this->hasMany(GameInning::class, 'game_id', 'id');
	}

	public function match() {
		return $this->hasOne(GameMatch::class, 'id', 'match_id');
	}

	public function user1() {
		return $this->hasOne(User::class, 'id', 'user1_id');
	}

	public function user2() {
		return $this->hasOne(User::class, 'id', 'user2_id');
	}
}

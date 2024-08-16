<?php

namespace App\Models;

use App\Core\Data\Model;

/**
 * mk: Unfortunately we have to use GameMatch here instead of Match
 * because it has become a reserved word in PHP 8
 *
 * @class GameMatch
 * @package Models
 * @project ChalkySticks API
 */
class GameMatch extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'matches';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['night_id', 'user1_id', 'user2_id', 'is_win', 'is_loss'];

	// Relationships
	// -----------------------------------------------------------------------

	public function games() {
		return $this->hasMany(Game::class, 'match_id', 'id');
	}

	public function night() {
		return $this->hasOne(GameNight::class, 'id', 'night_id');
	}

	public function user1() {
		return $this->hasOne(User::class, 'id', 'user1_id');
	}

	public function user2() {
		return $this->hasOne(User::class, 'id', 'user2_id');
	}
}

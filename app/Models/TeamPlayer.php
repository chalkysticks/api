<?php

namespace App\Models;

use App\Core\Data\Model;

/**
 * @class TeamPlayer
 * @package Models
 * @project ChalkySticks API
 */
class TeamPlayer extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'teamsplayers';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['team_id', 'user_id'];

	// Relationships
	// -----------------------------------------------------------------------

	public function team() {
		return $this->hasOne(Team::class, 'id', 'team_id');
	}

	public function user() {
		return $this->hasOne(User::class, 'id', 'user_id');
	}
}

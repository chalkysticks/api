<?php

namespace App\Models;

use App\Core\Data\Model;

/**
 * @class Team
 * @package Models
 * @project ChalkySticks API
 */
class Team extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'teams';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['owner_id', 'name', 'league_type', 'league_id', 'rank', 'wins', 'losses'];

	// Relationships
	// -----------------------------------------------------------------------

	public function owner() {
		return $this->hasOne(User::class, 'id', 'owner_id');
	}
}

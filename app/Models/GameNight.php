<?php

namespace App\Models;

use App\Core\Data\Model;

/**
 * @class GameNight
 * @package Models
 * @project ChalkySticks API
 */
class GameNight extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'nights';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [];

	// Relationships
	// -----------------------------------------------------------------------

	public function matches() {
		return $this->hasMany(GameMatch::class, 'night_id', 'id');
	}
}

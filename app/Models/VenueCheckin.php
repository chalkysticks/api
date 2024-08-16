<?php

namespace App\Models;

use App\Core\Data\Model;

/**
 * @class VenueCheckin
 * @package Models
 * @project ChalkySticks API
 */
class VenueCheckin extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'venuescheckins';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['venue_id', 'user_id'];

	// Relationships
	// -----------------------------------------------------------------------

	public function user() {
		return $this->hasOne(User::class, 'id', 'user_id');
	}

	public function venue() {
		return $this->hasOne(Venue::class, 'id', 'venue_id');
	}
}

<?php

namespace App\Models;

use App\Core\Data\Model;

/**
 * @class VenueRevision
 * @package Models
 * @project ChalkySticks API
 */
class VenueRevision extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'venuesrevisions';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['venue_id', 'user_id', 'hash', 'data', 'image_url'];

	// Relationships
	// -----------------------------------------------------------------------

	public function user() {
		return $this->hasOne(User::class, 'id', 'user_id');
	}

	public function venue() {
		return $this->hasOne(Venue::class, 'id', 'venue_id');
	}
}

<?php

namespace App\Models;

use App\Core\Data\Model;

/**
 * @class VenueMedia
 * @package Models
 * @project ChalkySticks API
 */
class VenueMedia extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'venuesmedia';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['venue_id', 'type', 'url'];

	// Relationships
	// -------------------------------------------------------------------------

	public function venue() {
		return $this->hasOne(Venue::class, 'id', 'venue_id');
	}
}

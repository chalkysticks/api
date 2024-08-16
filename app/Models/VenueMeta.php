<?php

namespace App\Models;

use App\Collections;
use App\Core\Data\Model;

/**
 * @class VenueMeta
 * @package Models
 * @project ChalkySticks API
 */
class VenueMeta extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'venuesmeta';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['venue_id', 'group', 'key', 'value'];

	// Relationships
	// -----------------------------------------------------------------------

	public function venue() {
		return $this->hasOne(Venue::class, 'id', 'venue_id');
	}

	// Override Collection
	// -----------------------------------------------------------------------

	public function newCollection(array $models = []) {
		return new Collections\VenueMeta($models);
	}
}

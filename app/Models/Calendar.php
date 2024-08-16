<?php

namespace App\Models;

use App\Core\Data\Model;

/**
 * @class Calendar
 * @package Models
 * @project ChalkySticks API
 */
class Calendar extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'calendar';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['venue_id', 'type', 'type_detail', 'title', 'description', 'start_at', 'end_at'];

	// Relationships
	// -----------------------------------------------------------------------

	public function venue() {
		return $this->hasSingle(Venue::class, 'venue_id', 'id');
	}
}

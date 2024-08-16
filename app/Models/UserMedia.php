<?php

namespace App\Models;

use App\Core\Data\Model;

/**
 * @class UserMedia
 * @package Models
 * @project ChalkySticks API
 */
class UserMedia extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'usersmedia';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['user_id', 'type', 'url'];

	// Relationships
	// -----------------------------------------------------------------------

	public function user() {
		return $this->hasOne(User::class, 'id', 'user_id');
	}
}

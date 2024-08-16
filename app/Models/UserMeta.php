<?php

namespace App\Models;

use App\Collections;
use App\Core\Data\Model;

/**
 * @class UserMeta
 * @package Models
 * @project ChalkySticks API
 */
class UserMeta extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'usersmeta';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['user_id', 'group', 'key', 'value'];


	// Relationships
	// -----------------------------------------------------------------------

	public function user() {
		return $this->hasOne(User::class, 'id', 'user_id');
	}


	// Override Collection
	// -----------------------------------------------------------------------

	public function newCollection(array $models = []) {
		return new Collections\UserMeta($models);
	}
}

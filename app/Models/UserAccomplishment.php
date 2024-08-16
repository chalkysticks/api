<?php

namespace App\Models;

use App\Core\Data\Model;

/**
 * @class UserAccomplishments
 * @package Models
 * @project ChalkySticks API
 */
class UserAccomplishment extends Model {
	const FIRST_PHOTO = 1;
	const FIRST_BEACON = 2;
	const FIRST_REVISION = 3;
	const VOLUNTEER = 4;
	const FIRST_SUGGESTION = 5;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'usersaccomplishments';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['user_id', 'accomplishment_id'];

	// Relationships
	// -----------------------------------------------------------------------

	public function accomplishment() {
		return $this->hasOne(Accomplishment::class, 'id', 'accomplishment_id');
	}

	public function user() {
		return $this->hasOne(User::class, 'id', 'user_id');
	}
}

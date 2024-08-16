<?php

namespace App\Models;

use App\Core\Data\Model;

/**
 * @class UserPrize
 * @package Models
 * @project ChalkySticks API
 */
class UserPrize extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'usersprizes';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['user_id', 'prize_id', 'value', 'created_at', 'updated_at'];
}

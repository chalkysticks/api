<?php

namespace App\Models;

use App\Core\Data\Model;

/**
 * @class UserFriend
 * @package Models
 * @project ChalkySticks API
 */
class UserFriend extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'usersfriends';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['user_id', 'friend_id', 'status', 'created_at', 'updated_at'];
}

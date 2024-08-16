<?php

namespace App\Models;

use App\Core\Data\Model;

/**
 * @class Accomplishment
 * @package Models
 * @project ChalkySticks API
 */
class Accomplishment extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'accomplishments';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['icon_url', 'banner_url', 'description'];
}

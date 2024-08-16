<?php

namespace App\Models;

use App\Core\Data\Model;

/**
 * @class TvSetting
 * @package Models
 * @project ChalkySticks API
 */
class TvSetting extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tv_settings';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['key', 'value'];
}

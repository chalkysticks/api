<?php

namespace App\Models;

use App\Core\Data\Model;

/**
 * @class TvChannel
 * @package Models
 * @project ChalkySticks API
 */
class TvChannel extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tvchannels';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id', 'youtube_id', 'title', 'description', 'channel_id', 'image_url'];
}

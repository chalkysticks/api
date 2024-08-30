<?php

namespace App\Models;

use App\Core\Data\Model;

/**
 * @class TvSchedule
 * @package Models
 * @project ChalkySticks API
 */
class TvSchedule extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tvschedule';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id', 'title', 'description', 'duration', 'video_meta', 'embed_url', 'thumbnail_url', 'is_live', 'flags', 'air_at', 'end_air_at', 'youtube_channel_id'];

	/**
	 * @return void
	 */
	public function enable() {
		$this->flags = 0;
		$this->end_air_at = null;
		$this->save();
	}

	/**
	 * @return void
	 */
	public function disable() {
		$this->flags = 9999;
		$this->end_air_at = date('Y-m-d H:i:s');
		$this->save();
	}

	// Relationships
	// -------------------------------------------------------------------------

	public function channel() {
		return $this->hasOne(TvChannel::class, 'youtube_id', 'youtube_channel_id');
	}
}

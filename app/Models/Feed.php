<?php

namespace App\Models;

use App\Core\Data\DistanceModel;
use App\Core\Data\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @class Feed
 * @package Models
 * @project ChalkySticks API
 */
class Feed extends Model {
	use DistanceModel;

	const TYPE_VENUE_ADD = 100;
	const TYPE_VENUEMEDIA_ADD = 105;
	const TYPE_VENUE_UPDATE = 110;
	const TYPE_VENUE_CHECKIN = 120;
	const TYPE_BEACON_ADD = 200;
	const TYPE_TOURNAMENT_ADD = 300;
	const TYPE_LEAGUE_ADD = 400;
	const TYPE_CONTENT_ADD = 500;
	const TYPE_CONTENT_PAD = 510;
	const TYPE_CONTENT_NEWS = 520;
	const TYPE_CONTENT_VIDEO = 530;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'feed';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['lat', 'lon', 'type', 'data', 'notes', 'created_at'];

	/**
	 * Scope to filter feeds by distance and lat/lon.
	 *
	 * @param Builder $query
	 * @param int $distance
	 * @param int $latitude
	 * @param int $longitude
	 * @return Builder
	 */
	public function scopeWithDistanceFilter(Builder $query, int $distance = 0, int $latitude = 0, int $longitude = 0): Builder {
		return $query->where(function ($query) use ($distance, $latitude, $longitude) {
			$query->distance($distance, $latitude . ',' . $longitude)
				->orWhere('lat', '=', 0);
		});
	}

	/**
	 * Scope to filter by creation date.
	 *
	 * @param Builder $query
	 * @param string $created_at
	 * @return Builder
	 */
	public function scopeCreatedBefore(Builder $query, string $created_at): Builder {
		return $query->where('created_at', '<=', $created_at);
	}
}

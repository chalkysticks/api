<?php

namespace App\Models;

use App\Core\Data\DistanceModel;
use App\Core\Data\Model;

/**
 * @class BeaconArchive
 * @package Models
 * @project ChalkySticks API
 */
class BeaconArchive extends Model {
	use DistanceModel;

	/*
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'beaconsarchive';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['user_id', 'lat', 'lon', 'status', 'keepalive', 'created_at', 'updated_at'];
}

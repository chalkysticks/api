<?php

namespace App\Models;

use App\Jobs;
use Carbon\Carbon;
use Config;
use Core\Data\DistanceModel;
use Core\Data\Model;
use Queue;

class Beacon extends Model {
	use DistanceModel;

	/**
	 * How long in minutes until we should create a new beacon
	 */
	public static $updateThreshold = 15;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'beacons';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['user_id', 'lat', 'lon', 'status', 'keepalive'];

	// Core
	// -----------------------------------------------------------------------

	public function purge() {
		Queue::push(new Jobs\PurgeURLs([
			'v1/beacons'
		]));
	}

	// Relationships
	// -----------------------------------------------------------------------

	public function user() {
		return $this->hasOne('App\Models\User', 'id', 'user_id');
	}

	// Actions
	// -----------------------------------------------------------------------

	public static function shouldUpdate($user_id) {
		$time = Carbon::now(Config::get('app.timezone'))
			->subMinutes(static::$updateThreshold)
			->toDateTimeString();

		$model = static::where('user_id', $user_id)
			->where('created_at', '>', $time)
			->get();

		if ($model->count() > 0) {
			return $model->first();
		}

		return false;
	}
}

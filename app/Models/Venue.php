<?php

namespace App\Models;

use App\Core\Data\DistanceModel;
use App\Core\Data\Model;
use Carbon\Carbon;
use Config;

/**
 * @class Venue
 * @package Models
 * @project ChalkySticks API
 */
class Venue extends Model {
	use DistanceModel;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'venues';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'slug', 'address', 'type', 'phone', 'lat', 'lon', 'status', 'owner_id', 'city', 'state', 'country', 'zip', 'description', 'notes', 'updated_at'];

	// Relationships
	// -----------------------------------------------------------------------

	public function checkins() {
		$time = Carbon::now(Config::get('app.timezone'))
			->subMinutes(60 * 3)
			->toDateTimeString();

		return $this->hasMany(VenueCheckin::class, 'venue_id', 'id')
			->where('created_at', '>', $time)
			->groupBy('user_id')
			->orderBy('created_at', 'desc');
	}

	public function basic() {
		return $this->hasMany(VenueMeta::class, 'venue_id', 'id')->where('group', 'basic');
	}

	public function details() {
		return $this->hasMany(VenueMeta::class, 'venue_id', 'id')->where('group', 'details');
	}

	public function hasMedia() {
		return $this->media()->where('type', 'image')->exists();
	}

	public function match() {
		return $this->hasOne(GameMatch::class, 'id', 'match_id');
	}

	public function media() {
		return $this->hasMany(VenueMedia::class, 'venue_id', 'id');
	}

	public function meta() {
		return $this->hasMany(VenueMeta::class, 'venue_id', 'id');
	}

	// Actions
	// -----------------------------------------------------------------------

	/**
	 * @param string $key
	 * @param string $value
	 * @return VenueMeta
	 */
	public function addBasicMeta(string $key, string $value) {
		$meta = $this->basic->where('key', $key)->first();

		if ($meta && $meta->id) {
			$meta->value = $value;
			$meta->save();
		} else {
			$meta = VenueMeta::create([
				'group' => 'basic',
				'key' => $key,
				'value' => $value,
				'venue_id' => $this->id,
			]);
		}

		return $meta;
	}

	/**
	 * @param string $key
	 * @param string $value
	 * @return VenueMeta
	 */
	public function addDetailsMeta(string $key, string $value) {
		$meta = $this->details->where('key', $key)->first();

		if ($meta && $meta->id) {
			$meta->value = $value;
			$meta->save();
		} else {
			$meta = VenueMeta::create([
				'venue_id' => $this->id,
				'group' => 'details',
				'key' => $key,
				'value' => $value
			]);
		}

		return $meta;
	}

	/**
	 * @return boolean
	 */
	public function isAutomated() {
		return $this->status == 30;
	}

	/**
	 * @return boolean
	 */
	public function isDisabled() {
		return $this->status == 20;
	}

	/**
	 * @return boolean
	 */
	public function isDraft() {
		return $this->status < 40;
	}

	/**
	 * @return boolean
	 */
	public function isPublished() {
		return $this->status == 101 || $this->status == 130;
	}

	/**
	 * @return boolean
	 */
	public function isReview() {
		return $this->status == 40;
	}

	// Override
	// ----------------------------------------------------------------------

	/**
	 * @param array $options
	 * @return bool
	 */
	public function save(array $options = []) {
		$this->slug = to_slug($this->name);
		return parent::save($options);
	}

	/**
	 * @param array $options
	 * @return bool
	 */
	public static function create(array $attributes = []) {
		$attributes['slug'] = to_slug($attributes['name']);

		return parent::create($attributes);
	}
}

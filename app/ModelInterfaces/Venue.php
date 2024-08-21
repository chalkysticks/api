<?php

namespace App\ModelInterfaces;

use App\Core\Data\ModelInterface;
use App\Models;

/**
 * @class Venue
 * @package ModelInterfaces
 * @project ChalkySticks API
 */
class Venue extends ModelInterface {
	/**
	 * @var array
	 */
	protected array $availableIncludes = [
		'checkins',
	];

	/**
	 * @var array
	 */
	protected array $defaultIncludes = [
		'details',
		'media',
		'meta',
	];

	/**
	 * @param Models\Venue $model
	 * @return \League\Fractal\Resource\Collection
	 */
	public function includeCheckins(Models\Venue $model) {
		return $this->collection($model->checkins, new VenueCheckin);
	}

	/**
	 * @param Models\Venue $model
	 * @return \League\Fractal\Resource\Collection
	 */
	public function includeDetails(Models\Venue $model) {
		return $this->collection($model->details, new Meta);
	}

	/**
	 * @param Models\Venue $model
	 * @return \League\Fractal\Resource\Collection
	 */
	public function includeMedia(Models\Venue $model) {
		return $this->collection($model->media, new Media);
	}

	/**
	 * @param Models\Venue $model
	 * @return \League\Fractal\Resource\Collection
	 */
	public function includeMeta(Models\Venue $model) {
		return $this->collection($model->basic, new Meta);
	}

	/**
	 * @return array
	 */
	public function transform($model) {
		$website = @$model->meta->where('key', 'website')->first() ?: "";
		$phone = preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $model->phone);

		$obj = [
			'id' => (int) $model->id,
			'created_at' => (string) $model->created_at,
			'name' => (string) $model->name,
			'slug' => (string) $model->slug,
			'status' => (int) $model->status,
			'address' => (string) $model->address,
			'city' => (string) $model->city,
			'state' => (string) $model->state,
			'country' => (string) $model->country,
			'zip' => (int) $model->zip,
			'distance' => $model->distance,
			'type' => (string) $model->type,
			'phone' => (string) $model->phone,
			'phone_formatted' => (string) $phone,
			'lat' => (double) $model->lat,
			'lon' => (double) $model->lon,
			'description' => (string) $model->description,
			'website' => (string) $website ? $website->value : '',
			'notes' => (string) $model->notes,
		];

		// special checkin tag time for users
		if (isset($model->checkin_at)) {
			$obj['checkin_at'] = (string) $model->checkin_at;
		}

		return $obj;
	}
}

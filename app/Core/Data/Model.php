<?php

namespace Core\Data;

use Carbon\Carbon;
use Core\Data\Collection;
use Core\Database\Query\Builder as Builder;
use League\Fractal;
use League\Fractal\Serializer;

/**
 * @class Model
 * @package Core/Data
 * @project ChalkySticks API
 */
abstract class Model extends \Illuminate\Database\Eloquent\Model {
	/**
	 * @var string[]
	 */
	protected $dates = ['deleted_at'];

	/**
	 * @param  array  $attributes
	 * @return void
	 */
	public function __construct(array $attributes = []) {
		parent::__construct($attributes);

		//
		if (@$_SERVER['HTTP_HOST'] == 'staging-api.chalkysticks.com') {
			$this->connection = 'staging';
		}
	}

	/**
	 * Get a new query builder instance for the connection.
	 *
	 * @return \Core\Database\Query\Builder
	 */
	protected function newBaseQueryBuilder() {
		$conn = $this->getConnection();
		$grammar = $conn->getQueryGrammar();

		return new Builder($conn, $grammar, $conn->getPostProcessor());
	}

	public function transformToArray($modelInterface, $includes = '') {
		$resource = $this->transform($modelInterface);
		$resource->setResourceKey('data');

		$manager = new Fractal\Manager;
		$manager->setSerializer(new Serializer\ArraySerializer());
		$manager->parseIncludes($includes);

		$content = $manager->createData($resource)->toArray();

		return $content;
	}

	public function transformToJSON($modelInterface, $includes = '') {
		$resource = $this->transform($modelInterface);
		$resource->setResourceKey('data');

		$manager = new Fractal\Manager;
		$manager->setSerializer(new Serializer\ArraySerializer());
		$manager->parseIncludes($includes);

		$content = $manager->createData($resource)->toJSON();

		return $content;
	}

	/**
	 * transform
	 *
	 * Convenience method that transforms this model using a specified
	 * ModelInterface
	 *
	 * @param ModelInterface $modelInterface  Object describing how to transform model
	 *
	 * @return Fractal\Resource\Item
	 */
	public function transform($modelInterface) {
		$resource = new Fractal\Resource\Item($this, $modelInterface);

		return $resource;
	}

	/**
	 * @return number
	 */
	public function getAgeInMinutes() {
		$dt = Carbon::now();
		$diff = $this->created_at->diffInMinutes($dt);

		return $diff;
	}

	/**
	 * @return number
	 */
	public function getAgeInHours() {
		$startTime = Carbon::parse($this->created_at);
		$nowTime = Carbon::now();
		$diffTime = $startTime->diffInHours($nowTime);

		return $diffTime;
	}

	/**
	 * @return string
	 */
	public function getCreatedAgo() {
		$startTime = Carbon::parse($this->created_at);
		$nowTime = Carbon::now();
		$diffTime = $startTime->diffForHumans($nowTime);

		return $diffTime;
	}

	/**
	 * @param array $models
	 * @return Collection
	 */
	public function newCollection(array $models = array()) {
		return new Collection($models);
	}
}

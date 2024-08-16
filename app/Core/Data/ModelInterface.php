<?php

namespace App\Core\Data;

use League\Fractal;

/**
 * @class ModelInterface
 * @package Core/Data
 * @project ChalkySticks API
 */
class ModelInterface extends Fractal\TransformerAbstract {
	/**
	 * @var array
	 */
	protected $properties = array();

	// Actionable
	// ----------------------------------------------------------------------

	/**
	 * @param object $model
	 * @return array
	 */
	public function transform($model) {
		$response = [];

		foreach ($this->properties as $value) {
			$response[$value] = $model->{$value};
		}

		return $response;
	}


	public function toArray($resource) {
		$fractal = new Fractal\Manager;
		$content = $fractal->createData($resource)->toArray();

		return $content;
	}

	public function toJson($resource) {
		$fractal = new Fractal\Manager;
		$content = $fractal->createData($resource)->toJson();

		return $content;
	}

	public function model($model, $transformer) {
		return $this->item($model, $transformer);
	}

	// Internal
	// ----------------------------------------------------------------------

	public function __construct(array $data = array()) {
		$this->properties = array_merge($this->properties, $data);
	}
}

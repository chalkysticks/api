<?php

namespace App\Core\Data;

use App\Core\Exception\ApiException;
use League\Fractal;

/**
 * @class DataModel
 * @package Core/Data
 * @project ChalkySticks API
 */
class DataModel {

	protected $properties = array();

	/**
	 * load
	 *
	 * Load a local JSON file into data model and returns instantiated class.
	 *
	 * @param string $path  Path (after base_path()) of JSON resource
	 *
	 * @return DataModel
	 */
	public static function load($path = null) {
		$class = get_called_class();
		$instance = new $class;

		// test string
		if (is_string($path)) {
			$path = trim($path);

			// load by file or content
			if (strpos($path, '.json') > 0) {
				$data = file_get_contents(base_path() . '/resources/data' . $path);

				if (strpos($data, '{') === 0 || strpos($data, '[') === 0) {
					$json = json_decode($data);
				} else {
					throw new ApiException('File malformed. JSON may not be formed correctly.');
				}
			}

			// load json
			else if (strpos($path, '{') === 0 || strpos($path, '[') === 0) {
				$json = json_decode($path);
			} else {
				throw new ApiException('String could not be converted to JSON object.');
			}
		}

		// might be an object
		else {
			$json = $path;
		}

		// do we have anything?
		if (count(array_keys((array) $json)) <= 0) {
			throw new ApiException('Malformed request. JSON object may not be formed correctly.');
		}

		// set properties
		foreach ($json as $key => $value) {
			$instance->{$key} = $value;
		}

		return $instance;
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
	 * Transforms data to array.
	 *
	 * @param ModelInterface $modelInterface  Object describing how to transform model
	 * @return array
	 */
	public function transformToArray($modelInterface) {
		$resource = $this->transform($modelInterface);

		$fractal = new Fractal\Manager;
		$content = $fractal->createData($resource)->toArray();

		return $content;
	}

	public function toArray() {
		return get_object_vars($this);
	}


	// Internal
	// ----------------------------------------------------------------------

	public function __construct(array $data = array()) {
		$this->properties = array_merge($this->properties, $data);
	}

	public function __set($name, $value) {
		$this->properties[$name] = $value;
	}

	public function __get($name) {
		if (array_key_exists($name, $this->properties)) {
			return $this->properties[$name];
		}

		return null;
	}
}

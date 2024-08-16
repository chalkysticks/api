<?php

namespace Core\Data;

/**
 * @class Collection
 * @package Core/Data
 * @project ChalkySticks API
 */
class Collection extends \Illuminate\Support\Collection {
	/**
	 * Delete all models in collection
	 * @return void
	 */
	public function delete() {
		foreach (static::all() as $model) {
			$model->delete();
		}
	}

	/**
	 * Search a collection's model field for a value
	 *
	 * @param string $key    Model column to search
	 * @param string $value  Value to compare to column
	 * @return
	 */
	public function findWhere(string $key, string $value) {
		return $this->filter(function ($model) use ($key, $value) {
			if ($model->{$key} == $value) {
				return true;
			}
		});
	}

	/**
	 * firstWhere
	 *
	 * Run findWhere and return singular, first, model
	 *
	 * @param string $key    Model column to search
	 * @param string $value  Value to compare to column
	 * @return
	 */
	public function firstWhere(string $key, string $value) {
		return $this->findWhere($key, $value)->first();
	}
}

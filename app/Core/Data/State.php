<?php

namespace Core\Data;

/**
 * @class State
 * @package Core/Data
 * @project ChalkySticks API
 */
class State {

	protected static $properties = array();

	public static function header($key, $value = NULL) {
		if (isset($value)) {
			self::$properties["header.$key"] = $value;
		}

		return @self::$properties["header.$key"] ?: '';
	}
}

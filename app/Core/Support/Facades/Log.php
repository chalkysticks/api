<?php

namespace Core\Support\Facades;

/**
 * @class Log
 * @package Core/Support/Facades
 * @project ChalkySticks API
 */
class Log extends \Illuminate\Support\Facades\Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() {
		return '\Core\Console\Log';
	}

}

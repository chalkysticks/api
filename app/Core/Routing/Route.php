<?php

namespace Core\Routing;

/**
 * @class Route
 * @package Core/Routing
 * @project ChalkySticks API
 */
class Route {
	/**
	 * @param string $endpoint
	 * @param string $controller
	 * @return void
	 */
	public static function api(string $endpoint, string $controller) {
		// @todo mk: this doesn't seem like the best way to do this
		if (strpos($endpoint, "{code}")) {
			\Route::get("$endpoint", "$controller@getWithCode");
			\Route::get("$endpoint/{id}", "$controller@getWithCode_single");
		} else {
			\Route::get("$endpoint", "$controller@get_index");
			\Route::get("$endpoint/{id}", "$controller@get_single");
		}

		\Route::post("$endpoint", "$controller@post_index");
		\Route::put("$endpoint/{id}", "$controller@put_single");
		\Route::delete("$endpoint/{id}", "$controller@delete_single");
	}
}

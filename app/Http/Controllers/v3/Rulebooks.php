<?php

namespace App\Http\Controllers\v3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

/**
 * @class Rulebooks
 * @package Http/Controllers/v3
 * @project ChalkySticks API
 */
class Rulebooks extends Controller {
	/**
	 * @return Response
	 */
	public function getIndex(): Response {
		$data = config('chalkysticks.rulebooks.game_types');

		return $this->simpleResponse($data);
	}

	/**
	 * @param string $id
	 * @return Response
	 */
	public function getSingle(string $id = '8_ball_bca'): Response {
		$content = $this->getRulebookContent($id);

		return $this->simpleResponse($content);
	}

	/**
	 * Get the content of a specific rulebook.
	 *
	 * @param string $id
	 * @return string
	 */
	private function getRulebookContent(string $id): string {
		$path = resource_path("views/rulebooks/{$id}.php");

		if (!File::exists($path)) {
			$path = resource_path('views/rulebooks/default.php');
		}

		return File::get($path);
	}
}

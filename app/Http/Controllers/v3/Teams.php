<?php

namespace App\Http\Controllers\v3;

use App\Http\Controllers\Controller;
use App\ModelInterfaces;
use App\Models;
use Illuminate\Http\Response;

/**
 * @class Teams
 * @package Http/Controllers/v3
 * @project ChalkySticks API
 */
class Teams extends Controller {
	/**
	 * @return Response
	 */
	public function getIndex() {
		$paginator = Models\Team::paginate($this->limit);

		return $this->paginate($paginator, new ModelInterfaces\Team);
	}

	/**
	 * @return Response
	 */
	public function getSingle($id) {
		$model = Models\Team::find($id);

		return $this->model($model, new ModelInterfaces\Team);
	}
}

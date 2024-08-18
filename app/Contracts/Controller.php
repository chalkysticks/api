<?php

namespace App\Contracts;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

/**
 * @class Controller
 * @package Contracts
 * @project ChalkySticks API
 */
interface Controller {
	/**
	 * Handle the index request with a FormRequest payload.
	 *
	 * @param FormRequest $request
	 * @return Response
	 */
	// public function getIndex(FormRequest $request): Response;

	/**
	 * Returns a collection of models. Should return with a method
	 * not allowed unless overriden.
	 *
	 * @param string $code
	 * @return \Response|void
	 */
	// public function getWithCode($code);

	/**
	 * Returns specific model. Should return with a method
	 * not allowed unless overriden.
	 *
	 * @param int $id
	 * @return \Response|void
	 */
	// public function getSingle($id);

	/**
	 * Returns specific model. Should return with a method
	 * not allowed unless overriden.
	 *
	 * @param int $code
	 * @param int $id
	 * @return \Response|void
	 */
	// public function getWithCodeSingle($code, $id);

	/**
	 * Updates a specific model. Should return with a method
	 * not allowed unless overriden.
	 *
	 * @param int $id
	 * @return \Response|void
	 */
	// public function putSingle($id);

	/**
	 * Creates a new model. Should return with a method
	 * not allowed unless overriden.
	 *
	 * @return \Response|void
	 */
	// public function postIndex();

	/**
	 * Deletes a specific model. Should return with a method
	 * not allowed unless overriden.
	 *
	 * @param int $id
	 * @return \Response|void
	 */
	// public function deleteSingle($id);
}

<?php

namespace App\Core\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @class Payload
 * @package Core/Requests
 * @project ChalkySticks API
 */
abstract class Payload extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool {
		return false;
	}

	/**
	 * @return string[]
	 */
	public function messages() {
		return [];
	}

	/**
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
	 */
	public function rules(): array {
		return [];
	}

	/**
	 * @return object
	 */
	public function validatedPayload() {
		return (object) [];
	}
}

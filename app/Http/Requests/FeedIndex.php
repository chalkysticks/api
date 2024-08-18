<?php

namespace App\Http\Requests;

use App\Core\Requests\Payload;

/**
 * @class FeedIndex
 * @package Http/Requests
 * @project ChalkySticks API
 */
class FeedIndex extends Payload {
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool {
		return true;
	}

	/**
	 * @return string[]
	 */
	public function messages() {
		return [
			'lat.required' => 'Latitude is required.',
			'lon.required' => 'Longitude is required.',
		];
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
	 */
	public function rules(): array {
		return [
			'lat' => ['required', 'numeric'],
			'lon' => ['required', 'numeric'],
			'd' => ['numeric', 'nullable'], // Nullable if not required
		];
	}

	/**
	 * @return object
	 */
	public function validatedPayload() {
		$data = $this->validate($this->rules()) + ['d' => $this->input('d', 100)];
		return (object) $data;
	}
}

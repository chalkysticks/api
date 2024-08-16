<?php

namespace App\Core\Translation;

use Illuminate\Translation\Translator as LaravelTranslator;

/**
 * @class Translator
 * @package Core/Translation
 * @project ChalkySticks API
 */
class Translator extends LaravelTranslator {
	/**
	 * Loaded JSON lang file
	 *
	 * @var object
	 */
	private object $_jsonLang;

	/**
	 * For custom JSON files
	 *
	 * @param string key
	 * @return mixed
	 */
	public function json(string $key = null) {
		// get key
		if ($key && isset($this->_jsonLang->$key)) {
			return $this->_jsonLang->$key;
		}

		// get key from fallback
		else if ($key) {
			$fallback = $this->getJson(\Config::get('app.fallback_locale'));

			return $fallback->$key;
		}

		// get all json
		else {
			return $this->_jsonLang;
		}
	}

	/**
	 * @param string $locale
	 * @return void
	 */
	public function loadJson(string $locale = 'en') {
		$this->_jsonLang = $this->getJson($locale);
	}

	/**
	 * Get JSON file
	 *
	 * @param string $locale
	 * @return object
	 */
	protected function getJson(string $locale = 'en') {
		$path = base_path() . '/' . \Config::get('app.json_lang_path') . '/' . $locale;
		$file = 'compiled.json';
		$filepath = "$path/$file";
		$contents = file_get_contents($filepath);

		return json_decode($contents);
	}
}

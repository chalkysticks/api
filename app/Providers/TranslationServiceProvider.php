<?php

namespace Core\Provider;

use App;
use App\Core\Translation\Translator;
use Config;
use Illuminate\Translation\TranslationServiceProvider as TSP;

/**
 * @class TranslationServiceProvider
 * @package Providers
 * @project ChalkySticks API
 */
class TranslationServiceProvider extends TSP {
	/**
	 * @return void
	 */
	public function boot() {
		$this->load();

		$this->app->bindShared('translator', function ($app) {
			$loader = $app['translation.loader'];
			$locale = $app['config']['app.locale'];

			$trans = new Translator($loader, $locale);
			$trans->loadJson($locale);
			$trans->setFallback($app['config']['app.fallback_locale']);

			return $trans;
		});
	}

	/**
	 * @return void
	 */
	protected function load() {
		$locales = json_decode(file_get_contents(base_path() . '/resources/lang/locales.json'));
		$headers = \getallheaders();
		$headers['X-Akamai-Edgescape'] = isset($headers['X-Akamai-Edgescape']) ? $headers['X-Akamai-Edgescape'] : "";

		parse_str(str_replace(',', '&', $headers['X-Akamai-Edgescape']), $edgescape);

		// get country from Akamai
		if (isset($edgescape) && isset($edgescape['country_code'])) {
			$this->edgescape = $edgescape;

			Config::set('app.country_code', $edgescape['country_code']);
		}

		// default country
		else {
			Config::set('app.country_code', 'US');
		}

		// override country
		if ($country = \Request::get('country')) {
			App::setLocale("EN");
			Config::set('app.country_code', strtoupper($country));
		}

		// get cookie (if we don't have country)
		else if (isset($_COOKIE['country'])) {
			$country = $_COOKIE['country'];
			Config::set('app.country_code', strtoupper($country));
		}


		// convert locale
		if ($lang = \Request::get('lang')) {
			App::setLocale($lang);
		}

		// get cookie (if we don't have country)
		else if (isset($_COOKIE['language']) && !isset($country)) {
			App::setLocale($_COOKIE['language']);
		}

		// facebook hit
		else if (
			isset($_SERVER["HTTP_USER_AGENT"]) &&
			(
				strpos($_SERVER["HTTP_USER_AGENT"], "facebookexternalhit/") !== false ||
				strpos($_SERVER["HTTP_USER_AGENT"], "Facebot") !== false
			)
		) {
			App::setLocale("en");
		}

		// use locale
		else {
			$locale = $locales->{Config::get('app.country_code')};

			if (isset($locale) && isset($locale->iso)) {
				$iso = $locale->iso;
			} else {
				$iso = Config::get('app.fallback_locale');
			}

			// locale
			App::setLocale($iso);
		}
	}
}

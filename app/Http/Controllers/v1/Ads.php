<?php

namespace App\Http\Controllers\v1;

use App\ModelInterfaces;
use App\Http\Controllers\Controller;

/**
 * @class AdsController
 * @package Http/Controllers/v1
 * @project ChalkySticks API
 */
class Ads extends Controller {
	/**
	 * @return \Illuminate\Http\Response
	 */
	public function getIndex() {
		$ads = [
			(object) [
				'caption' => 'Get a new cue from<br>FCI Billiards',
				'company' => 'FCI Billiards',
				'title' => 'FCI Billiards',
				'image' => 'https://static.chalkysticks.com/image/anuns/fci-01.png',
				'url' => 'http://fcibilliards.com/'
			],
			(object) [
				'caption' => 'FCI Billiards',
				'company' => 'FCI Billiards',
				'title' => 'FCI Billiards',
				'image' => 'https://static.chalkysticks.com/image/anuns/fci-02.png',
				'url' => 'http://fcibilliards.com/'
			],
			(object) [
				'caption' => 'FCI Billiards',
				'company' => 'FCI Billiards',
				'title' => 'FCI Billiards',
				'image' => 'https://static.chalkysticks.com/image/anuns/fci-03.png',
				'url' => 'http://fcibilliards.com/'
			],
			(object) [
				'caption' => 'Poison Cues @ FCI Billiards',
				'company' => 'FCI Billiards',
				'title' => 'Poison Cues @ FCI Billiards',
				'image' => 'https://static.chalkysticks.com/image/anuns/fci-04.png',
				'url' => 'http://fcibilliards.com/poison-vx4-stky-playing-cue-yellow/'
			],

			(object) [
				'caption' => '',
				'company' => 'Reddit',
				'title' => 'Reddit',
				'image' => 'https://static.chalkysticks.com/image/anuns/reddit-01.png',
				'url' => 'http://reddit.com/r/billiards'
			]
		];

		return $this->collection($ads, new ModelInterfaces\Ads);
	}
}

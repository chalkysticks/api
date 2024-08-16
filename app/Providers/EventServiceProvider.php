<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * @class EventServiceProvider
 * @package Providers
 * @project ChalkySticks API
 */
class EventServiceProvider extends ServiceProvider {
	/**
	 * The event listener mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		'App\Events\BeaconWasSent' => [
			'App\Listeners\UpdateUserViaBeacon',
		],

		'App\Events\PurgeRequest' => [
			'App\Listeners\PurgeURLs',
		],

		// 'App\Events\MessageReceived' => [
		// 	'App\Listeners\BroadcastPushNotifications',
		// ],
	];
}

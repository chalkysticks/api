<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	return view('welcome');
});

Route::prefix('v3')->group(function () {
	Route::get('/ads', [App\Http\Controllers\v3\Ads::class, 'getIndex']);
	Route::get('/feed', [App\Http\Controllers\v3\Feed::class, 'getIndex']);

	Route::get('/rulebooks', [App\Http\Controllers\v3\Rulebooks::class, 'getIndex']);
	Route::get('/rulebooks/{id}', [App\Http\Controllers\v3\Rulebooks::class, 'getSingle']);

	Route::get('/statistics', [App\Http\Controllers\v3\Statistics::class, 'getIndex']);

	Route::get('/teams', [App\Http\Controllers\v3\Teams::class, 'getIndex']);
	Route::get('/teams/{id}', [App\Http\Controllers\v3\Teams::class, 'getSingle']);

	Route::get('/tv/channels', [App\Http\Controllers\v3\Tv::class, 'getChannels']);
	Route::get('/tv/channel-map', [App\Http\Controllers\v3\Tv::class, 'getChannelMap']);
	Route::get('/tv/live', [App\Http\Controllers\v3\Tv::class, 'getLive']);
	Route::get('/tv/schedule', [App\Http\Controllers\v3\Tv::class, 'getSchedule']);
	Route::post('/tv/schedule', [App\Http\Controllers\v3\Tv::class, 'postSchedule']);
	Route::delete('/tv/schedule', [App\Http\Controllers\v3\Tv::class, 'deleteSchedule']);
});

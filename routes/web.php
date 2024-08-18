<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	return view('welcome');
});


Route::prefix('v1')->group(function () {
	Route::get('/ads', [App\Http\Controllers\v1\Ads::class, 'getIndex']);
	Route::get('/feed', [App\Http\Controllers\v1\Feed::class, 'getIndex']);

	Route::get('/statistics', [App\Http\Controllers\v1\Statistics::class, 'getIndex']);

	Route::get('/teams', [App\Http\Controllers\v1\Teams::class, 'getIndex']);
	Route::get('/teams/{id}', [App\Http\Controllers\v1\Teams::class, 'getSingle']);

	Route::get('/tv/schedule', [App\Http\Controllers\v1\Tv::class, 'getSchedule']);
	Route::post('/tv/schedule', [App\Http\Controllers\v1\Tv::class, 'postSchedule']);
	Route::delete('/tv/schedule', [App\Http\Controllers\v1\Tv::class, 'deleteSchedule']);
});

<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	return view('welcome');
});


Route::prefix('v1')->group(function () {
	Route::get('/ads', [App\Http\Controllers\v1\Ads::class, 'getIndex']);
});

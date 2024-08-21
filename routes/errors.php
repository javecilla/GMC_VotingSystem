<?php

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

//Unauthorized
//Route::fallback(function () {abort(401);});

//Payment Required
//Route::fallback(function () {abort(402);});

//Access Forbidden
//Route::fallback(function () {abort(403);});

//Page Not Found
//Route::fallback(function () {abort(404);});

//Page Expired
//Route::fallback(function () {abort(419);});

//Too Many Requests
Route::get('/e429' . now()->year, function () {
	return response()->view('errors.429', [], 429);
});

//Internal Server Error
//Route::fallback(function () {abort(500);});

//Service Unavailable
//Route::fallback(function () {abort(503);});

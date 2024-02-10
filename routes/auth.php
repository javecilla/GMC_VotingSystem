<?php

use App\Http\Controllers\App\Auth\LoginController;
use App\Http\Controllers\App\Auth\SessionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'guest'])->group(function () {
	Route::get('/auth/login', [LoginController::class, 'create'])
		->name('login.create');
	Route::delete('/session/{sessionName}/delete', [SessionController::class, 'destroy']);

	Route::middleware('throttle:web')->group(function () {
		Route::post('/validate/user', [LoginController::class, 'store'])
			->name('login.validate');
	});
});
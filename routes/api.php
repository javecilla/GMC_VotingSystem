<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\SessionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|-------------------------------------------------------------------------
 */
Route::middleware(['web', 'guest'])->group(function () {
	Route::post('/validate/user', [LoginController::class, 'store']);

	Route::delete('/session/delete/{sessionName}', [SessionController::class, 'destroy']);
});

/*
|--------------------------------------------------------------------------
| Voting System [ADMIN PANEL] API Routes
|--------------------------------------------------------------------------
 */
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
	Route::post('/logout/user', [LogoutController::class, 'destroy']);
});

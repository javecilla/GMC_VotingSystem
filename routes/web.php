<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Guest\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Voting System [GUEST] Routes
|--------------------------------------------------------------------------
 */

Route::middleware(['guest'])->group(function () {
	Route::get('/', [PageController::class, 'main'])->name('main.page');
	Route::prefix('testing-title-voting')->group(function () {
		Route::get('/candidates', [PageController::class, 'index'])->name('index.page');
	});

	// Show login form
	Route::get('/auth/login', [LoginController::class, 'create'])->name('login.create');
});

/*
|--------------------------------------------------------------------------
| Voting System [ADMIN PANEL] Web Routes
|--------------------------------------------------------------------------
 */
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
	Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
});
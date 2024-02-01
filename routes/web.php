<?php

use App\Http\Controllers\App\Admin\AppVersionController;
use App\Http\Controllers\App\Admin\CandidatesController;
use App\Http\Controllers\App\Admin\CategoryController;
use App\Http\Controllers\App\Admin\ConfigurationController;
use App\Http\Controllers\App\Admin\DashboardController;
use App\Http\Controllers\App\Admin\VotesController;
use App\Http\Controllers\App\Auth\LoginController;
use App\Http\Controllers\App\Auth\LogoutController;
use App\Http\Controllers\App\Auth\SessionController;
use App\Http\Controllers\App\Guest\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| [GUEST] Routes
|--------------------------------------------------------------------------
 */

Route::middleware(['web', 'guest'])->group(function () {
	Route::get('/', [PageController::class, 'main'])
		->name('main.page');
	Route::prefix('testing-title-voting')->group(function () {
		Route::get('/candidates', [PageController::class, 'index'])
			->name('index.page');
	});

	Route::get('/auth/login', [LoginController::class, 'create'])
		->name('login.create');
	Route::post('/validate/user', [LoginController::class, 'store']);
	Route::delete('/session/{sessionName}/delete', [SessionController::class, 'destroy']);
});

/*
|--------------------------------------------------------------------------
| [ADMIN PANEL] Routes
|--------------------------------------------------------------------------
 */
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
	Route::prefix('{version}/admin')->group(function () {
		Route::prefix('configuration')->group(function () {
			Route::get('/', [ConfigurationController::class, 'index'])->name('configuration.index');

			Route::prefix('app-versions')->group(function () {
				Route::get('/all', [AppVersionController::class, 'retrieve']);
				Route::patch('/{appVersion}/update', [AppVersionController::class, 'update']);
				Route::post('/store', [AppVersionController::class, 'store']);
				Route::delete('/{appVersion}/destroy', [AppVersionController::class, 'destroy']);
			});

			#TODO: CQRS to CRUD
			Route::prefix('category')->group(function () {
				Route::get('/all', [CategoryController::class, 'retrieve']);
			});
		});

		Route::get('/dashboard', [DashboardController::class, 'index'])
			->name('dashboard.index');

		Route::get('/manage/votes', [VotesController::class, 'index'])
			->name('votes.index');

		Route::get('/manage/candidates', [CandidatesController::class, 'index'])
			->name('candidates.index');
		Route::get('/manage/candidates/create', [CandidatesController::class, 'create'])
			->name('candidates.create');
	});

	Route::post('/logout/user', [LogoutController::class, 'destroy']);
});
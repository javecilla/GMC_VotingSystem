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
	Route::delete('/session/delete/{sessionName}', [SessionController::class, 'destroy']);
});

/*
|--------------------------------------------------------------------------
| [ADMIN PANEL] Routes
|--------------------------------------------------------------------------
 */
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
	Route::prefix('{version}/admin/')->group(function () {
		Route::get('/dashboard', [DashboardController::class, 'index'])
			->name('dashboard.index');

		Route::get('/manage/votes', [VotesController::class, 'index'])
			->name('votes.index');

		Route::get('/manage/candidates', [CandidatesController::class, 'index'])
			->name('candidates.index');
		Route::get('/manage/candidates/create', [CandidatesController::class, 'create'])
			->name('candidates.create');

		Route::get('/configuration', [ConfigurationController::class, 'index'])
			->name('configuration.index');

		Route::get('/app-versions', [AppVersionController::class, 'index']);
		Route::patch('/app-versions/{appVersion}/update', [AppVersionController::class, 'update']);

		Route::get('/category', [CategoryController::class, 'index']);
	});

	Route::post('/logout/user', [LogoutController::class, 'destroy']);
});
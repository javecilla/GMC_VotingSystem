<?php

use App\Http\Controllers\Admin\CandidatesController;
use App\Http\Controllers\Admin\ConfigurationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\VotesController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Guest\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Voting System Web Routes v1.3 (Dev: Jerome Avecilla)
|--------------------------------------------------------------------------
 */

/*
|--------------------------------------------------------------------------
| [GUEST] Routes
|--------------------------------------------------------------------------
 */

Route::middleware(['guest'])->group(function () {
	Route::get('/', [PageController::class, 'main'])->name('main.page');
	Route::prefix('testing-title-voting')->group(function () {
		Route::get('/candidates', [PageController::class, 'index'])->name('index.page');
	});
	Route::get('/auth/login', [LoginController::class, 'create'])->name('login.create');
});

/*
|--------------------------------------------------------------------------
| [ADMIN PANEL] Routes
|--------------------------------------------------------------------------
 */
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
	Route::prefix('{version}/admin/')->group(function () {
		Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

		Route::get('/manage/votes', [VotesController::class, 'index'])->name('votes.index');

		Route::get('/manage/candidates', [CandidatesController::class, 'index'])->name('candidates.index');
		Route::get('/manage/candidates/create', [CandidatesController::class, 'create'])
			->name('candidates.create');

		Route::get('/configuration', [ConfigurationController::class, 'index'])
			->name('configuration.index');
	});
});
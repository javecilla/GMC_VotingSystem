<?php

use App\Http\Controllers\App\Admin\AppVersionController;
use App\Http\Controllers\App\Admin\CandidatesController;
use App\Http\Controllers\App\Admin\CategoryController;
use App\Http\Controllers\App\Admin\ConfigurationController;
use App\Http\Controllers\App\Admin\DashboardController;
use App\Http\Controllers\App\Admin\VotePointController;
use App\Http\Controllers\App\Admin\VotesController;
use App\Http\Controllers\App\Auth\LoginController;
use App\Http\Controllers\App\Auth\LogoutController;
use App\Http\Controllers\App\Auth\SessionController;
use App\Http\Controllers\App\Guest\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest Routes
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
| Admin Panel Routes
|--------------------------------------------------------------------------
 */
Route::middleware(['web', 'auth', 'verified', 'admin'])->group(function () {
	Route::prefix('{version}')->group(function () {
		Route::prefix('admin')->group(function () {
			# Configuration
			Route::prefix('configuration')->group(function () {
				Route::get('/', [ConfigurationController::class, 'index'])->name('configuration.index');

				// App Versions
				Route::controller(AppVersionController::class)->prefix('app-versions')->group(function () {
					Route::get('/', 'retrieve');
					Route::post('/store', 'store');
					Route::patch('/{appVersion}/update', 'update');
					Route::delete('/{appVersion}/destroy', 'destroy');
				});

				// Categories
				Route::controller(CategoryController::class)->prefix('category')->group(function () {
					Route::get('/', 'retrieve');
					Route::post('/store', 'store');
					Route::patch('/{category}/update', 'update');
					Route::delete('/{category}/destroy', 'destroy');
				});

				// Vote Points
				Route::controller(VotePointController::class)->prefix('vote-points')->group(function () {
					Route::get('/', 'retrieve');
					Route::post('/store', 'store');
					Route::patch('/{votePoint}/update', 'update');
					Route::delete('/{votePoint}/destroy', 'destroy');
				});
			});

			# Dashboard
			Route::get('/dashboard', [DashboardController::class, 'index'])
				->name('dashboard.index');

			# Votes Management
			Route::get('/manage/votes', [VotesController::class, 'index'])
				->name('votes.index');

			# Candidates Management
			Route::get('/manage/candidates', [CandidatesController::class, 'index'])
				->name('candidates.index');
			Route::get('/manage/candidates/create', [CandidatesController::class, 'create'])
				->name('candidates.create');
		});
		# Logout
		Route::post('/logout/user', [LogoutController::class, 'destroy']);
	});
});
<?php

use App\Http\Controllers\App\Admin\AppVersionController;
use App\Http\Controllers\App\Admin\CampusController;
use App\Http\Controllers\App\Admin\CandidatesController;
use App\Http\Controllers\App\Admin\CategoryController;
use App\Http\Controllers\App\Admin\ConfigurationController;
use App\Http\Controllers\App\Admin\DashboardController;
use App\Http\Controllers\App\Admin\VotePointController;
use App\Http\Controllers\App\Admin\VotesController;
use App\Http\Controllers\App\Auth\LogoutController;
use App\Http\Controllers\App\Auth\SessionController;
use App\Http\Controllers\App\Guest\PageController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
	/*
		|--------------------------------------------------------------------------
		| Guest Routes
		|--------------------------------------------------------------------------
	*/
	Route::middleware(['guest'])->group(function () {
		Route::get('/', [PageController::class, 'main'])->name('main.page');
		Route::prefix('testing-title-voting')->group(function () {
			Route::get('/candidates', [PageController::class, 'index'])->name('index.page');
		});
	});

	require __DIR__ . '/auth.php';

	/*
		|--------------------------------------------------------------------------
		| Admin Panel Routes
		|--------------------------------------------------------------------------
	*/
	Route::middleware(['auth', 'verified', 'admin'])->group(function () {
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

					// School/Campus
					Route::controller(CampusController::class)->prefix('campus')->group(function () {
						Route::get('/', 'retrieve');
						//Route::post('/store', 'store');
						//Route::patch('/{campus}/update', 'update');
						//Route::delete('/{campus}/destroy', 'destroy');
					});
				});

				# Candidates Management
				Route::controller(CandidatesController::class)
					->prefix('manage/candidates')->group(function () {
					Route::get('/', 'index')->name('candidates.index');
					Route::get('/create', 'create')->name('candidates.create');
					Route::post('/store', 'store');
					Route::get('/retrieves', 'retrieves'); //get all
					Route::get('/{candidate}/show', 'show')->name('candidates.show');
					Route::get('/{candidate}/edit', 'edit')->name('candidates.edit');
					Route::get('/{candidate}/retrieve', 'retrieve'); //get one
				});

				# Dashboard
				Route::get('/dashboard', [DashboardController::class, 'index'])
					->name('dashboard.index');

				# Votes Management
				Route::get('/manage/votes', [VotesController::class, 'index'])
					->name('votes.index');

			});

			# Logout
			Route::post('/logout/user', [LogoutController::class, 'destroy']);
			Route::post('/check/user/session', [SessionController::class, 'check']);
		});
	});

	require __DIR__ . '/errors.php';
});

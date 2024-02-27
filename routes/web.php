<?php

use App\Http\Controllers\App\Admin\AppVersionController;
use App\Http\Controllers\App\Admin\CampusController;
use App\Http\Controllers\App\Admin\CandidatesController;
use App\Http\Controllers\App\Admin\CategoryController;
use App\Http\Controllers\App\Admin\ConfigurationController;
use App\Http\Controllers\App\Admin\DashboardController;
use App\Http\Controllers\App\Admin\TicketReportController;
use App\Http\Controllers\App\Admin\VotePointController;
use App\Http\Controllers\App\Admin\VotesController;
use App\Http\Controllers\App\Auth\LogoutController;
use App\Http\Controllers\App\Auth\SessionController;
use App\Http\Controllers\App\Guest\ViewController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
	/*
		|--------------------------------------------------------------------------
		| Guest Routes
		|--------------------------------------------------------------------------
	*/
	Route::middleware(['guest'])->group(function () {
		Route::get('/', [ViewController::class, 'main'])->name('main.page');
		Route::prefix('{title}')->group(function () {
			Route::get('/candidates', [ViewController::class, 'index'])->name('index.page');
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
						Route::post('/store', 'store');
						Route::patch('/{campus}/update', 'update');
						Route::delete('/{campus}/destroy', 'destroy');
					});
				});

				# Candidates Management
				Route::controller(CandidatesController::class)
					->prefix('manage/candidates')->group(function () {
					Route::get('/', 'index')->name('candidates.index');
					Route::get('/create', 'create')->name('candidates.create');
					Route::post('/store', 'store');
					Route::get('/load/{limit}/offset/{offset}', 'loadMoreData');
					Route::get('/retrieves', 'retrieves');
					Route::get('/{query}/search', 'search');
					Route::get('/{ctid}/category', 'category');
					Route::get('/{candidate}/show', 'show')->name('candidates.show');
					Route::get('/{candidate}/retrieve', 'retrieve');
					Route::get('/{candidate}/edit', 'edit')->name('candidates.edit');
					Route::patch('/{candidate}/update', 'update');
					Route::delete('/{candidate}/destroy', 'destroy');
					Route::get('/candidates/ranking/overall/{limit}', 'getOverallRanking');
					Route::get('/candidates/ranking/category/{limit}', 'getCategoryRanking');
				});
				Route::get('/candidates/ranking', [CandidatesController::class, 'ranking'])
					->name('candidates.ranking');

				# Dashboard
				Route::controller(DashboardController::class)
					->prefix('dashboard')->group(function () {
					Route::get('/', 'index')->name('dashboard.index');
					Route::get('/most/votes/candidates/limit/{limit}', 'getMostVotes');
					Route::get('/count/all', 'counts');
					Route::get('/load/limit/{limit}/offset/{offset}', 'retrievesLimit');
					Route::get('/count/reports', 'counts');
				});

				# Votes Management
				Route::controller(VotesController::class)
					->prefix('/manage/votes')->group(function () {
					Route::get('/', 'index')->name('votes.index');
					Route::get('/get/all', 'retrieves');
					Route::get('/load/{limit}/offset/{offset}', 'loadMoreData');
					Route::get('/{vid}/get', 'retrieve');
					Route::get('/count/all', 'counts');
					Route::patch('/update/status', 'updateByStatus');
					Route::get('/get/all/{status}/status', 'getByStatus');
					Route::get('/get/all/{search}/search', 'getBySearch');
					Route::post('/store', 'store');
					Route::patch('/update', 'update');
					Route::delete('/{vid}/destroy', 'destroy');
				});

				#Ticket Report
				Route::controller(TicketReportController::class)
					->prefix('/manage/ticket/reports')->group(function () {
					Route::get('/', 'index')->name('reports.index');
					Route::get('/load/{limit}/offset/{offset}', 'loadMoreData');
					Route::get('/count/all', 'counts');
				});
			});

			# Logout
			Route::post('/logout/user', [LogoutController::class, 'destroy']);
			Route::post('/check/user/session', [SessionController::class, 'check']);
		});
	});

	require __DIR__ . '/errors.php';
});

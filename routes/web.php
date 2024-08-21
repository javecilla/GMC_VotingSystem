<?php

use App\Http\Controllers\App\Admin\AppVersionController;
use App\Http\Controllers\App\Admin\CandidatesController;
use App\Http\Controllers\App\Admin\ConfigurationController;
use App\Http\Controllers\App\Admin\DashboardController;
use App\Http\Controllers\App\Admin\TicketReportController;
use App\Http\Controllers\App\Admin\VotesController;
use App\Http\Controllers\App\Auth\LoginController;
use App\Http\Controllers\App\Auth\LogoutController;
use App\Http\Controllers\App\Auth\SessionController;
use App\Http\Controllers\App\Guest\ViewController;
use Illuminate\Support\Facades\Route;

Route::get('/dev', function (){
  Artisan::call('route:clear');
  Artisan::call('cache:clear');
  Artisan::call('config:clear');
  Artisan::call('config:cache');

  Artisan::call('storage:link');
});

Route::middleware(['web'])->group(function () {
	/*
		|--------------------------------------------------------------------------
		| Guest Web Routes
		|--------------------------------------------------------------------------
	*/
	Route::middleware(['guest'])->group(function () {
		Route::get('/', [ViewController::class, 'main'])->name('main.page');
		Route::prefix('{title}')->group(function () {
			Route::get('/candidates', [ViewController::class, 'index'])->name('index.page');
		});
		Route::get('/auth/login', [LoginController::class, 'create'])->name('login.create');
	});

	/*
		|--------------------------------------------------------------------------
		| Admin Web Routes
		|--------------------------------------------------------------------------
	*/
	Route::middleware(['auth', 'verified', 'admin'])->group(function () {
		Route::prefix('{version}')->group(function () {
			Route::prefix('admin')->group(function () {
				# Dashboard
				Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

				# Votes Management
				Route::get('/manage/votes', [VotesController::class, 'index'])
					->name('votes.index');

				# Candidates Management
				Route::controller(CandidatesController::class)
					->prefix('manage/candidates')->group(function () {
					Route::get('/', 'index')->name('candidates.index');
					Route::get('/{candidate}/show', 'show')->name('candidates.show');
					Route::get('/create', 'create')->name('candidates.create');
					Route::get('/{candidate}/edit', 'edit')->name('candidates.edit');
				});
				Route::get('/candidates/ranking', [CandidatesController::class, 'ranking'])
					->name('candidates.ranking');

				#TODO: (CRUD) Ticket Report
				Route::controller(TicketReportController::class)
					->prefix('/manage/ticket/reports')->group(function () {
					Route::get('/', 'index')->name('reports.index');
				});

				# Configuration
				Route::get('/configuration',
					[ConfigurationController::class, 'index'])->name('configuration.index');

				# Switching App Version
				Route::get('/switching/version', [AppVersionController::class, 'show']);
			});

			# Logout
			Route::post('/logout/user', [LogoutController::class, 'destroy']);
			Route::post('/check/user/session', [SessionController::class, 'check']);
		});

	});

	require __DIR__ . '/errors.php';
});

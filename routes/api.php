<?php

use App\Http\Controllers\Api\V1\AppVersionController;
use App\Http\Controllers\Api\V1\CampusController;
use App\Http\Controllers\Api\V1\CandidatesController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\DashboardController;
use App\Http\Controllers\Api\V1\SessionController;
use App\Http\Controllers\Api\V1\TicketReportController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\ViewController;
use App\Http\Controllers\Api\V1\VotePointController;
use App\Http\Controllers\Api\V1\VotesController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
	/*
		|--------------------------------------------------------------------------
		| Guest API Routes
		|--------------------------------------------------------------------------
	*/
	Route::middleware('guest')->group(function () {
		Route::prefix('{version}')->group(function () {
			Route::get('/candidates', [CandidatesController::class, 'getRecordsAll']);
			Route::get('/{candidate}/candidates', [CandidatesController::class, 'getRecordsOne']);
			Route::get('/{searchQuery}/search', [CandidatesController::class, 'getBySearch']);
			Route::get('/{categoryQuery}/category', [CandidatesController::class, 'getByCategory']);

			Route::get('/category', [CategoryController::class, 'getRecordsAll']);

			Route::get('/amount/vote-points', [VotePointController::class, 'getRecordsAll']);
			Route::get('/{votePointsId}/vote-points', [VotePointController::class, 'getRecordsOne']);

			Route::post('/vote/client/store', [VotesController::class, 'storeClient']);
			Route::get('/count/all/votes', [VotesController::class, 'countPendingVerifiedSpam']);

			Route::get('/count/page/views', [ViewController::class, 'count']);

			Route::post('/report/store', [TicketReportController::class, 'store']);
			Route::delete('/session/{sessionName}/delete', [SessionController::class, 'destroy']);
		});
	});

  #Login
	Route::middleware('throttle:api')->group(function () {
		Route::post('/validate/user', [UserController::class, 'store']);
	});

	/*
		|--------------------------------------------------------------------------
		| Admin API Routes
		|--------------------------------------------------------------------------
	*/
	Route::middleware(['auth:sanctum', 'verified', 'admin'])->group(function () {
		Route::prefix('{version}')->group(function () {
			Route::prefix('admin')->group(function () {
				# Dashboard
				Route::controller(DashboardController::class)->prefix('dashboard')->group(function () {
					Route::get('/count/pending/verified/amount', 'countPendingVerifiedAmount');
					Route::get('/get/recently/voters/{limit}/{offset}', 'getRecentlyVoters');
					Route::get('/most/votes/candidates/{limit}', 'getOverallRanking');
					Route::get('/count/total/page/views/{limit}/perday', 'countPageViewsPerDay');
				});

				# Votes Management
				Route::controller(VotesController::class)->prefix('/manage/votes')->group(function () {
					Route::get('/all/records', 'getRecordsAll');
					Route::get('/limit/records/{limit}/{offset}', 'getRecordsLimit');
					Route::get('/id/{votes}', 'getRecordsOne');
					Route::get('/status/{status}', 'getRecordsByStatus');
					Route::get('/search/{search}', 'getRecordsBySearch');
					Route::get('/count/pending/verified/spam', 'countPendingVerifiedSpam');
					Route::get('/summary', 'getTotalOfSummaryVotes');
					Route::post('/store', 'storeAdmin');
					Route::patch('/id/{votes}/update', 'update');
					Route::patch('/id/{votes}/status/{status}/update', 'updateByStatus');
					Route::delete('/id/{votes}/destroy', 'destroy');
				});

				# Candidates Management
				Route::controller(CandidatesController::class)->prefix('manage/candidates')->group(function () {
					Route::get('/all/records', 'getRecordsAll');
					Route::get('/limit/records/{limit}/{offset}', 'getRecordsLimit');
					Route::get('/id/{candidate}', 'getRecordsOne');
					Route::get('/search/{search}', 'getBySearch');
					Route::get('/category/{category}', 'getByCategory');
					Route::get('/ranking/overall/{limit}', 'getOverallRanking');
					Route::get('/ranking/category/{limit}', 'getCategoryRanking');
					Route::post('/store', 'store');
					Route::patch('/id/{candidate}/update', 'update');
					Route::delete('/id/{candidate}/destroy', 'destroy');
				});

				#Ticket Report
				Route::controller(TicketReportController::class)->prefix('/manage/ticket/reports')->group(function () {
					Route::get('/limit/records/{limit}/{offset}', 'getRecordsLimit');
					Route::get('/count/not/fix', 'countNotFixReport');
					Route::get('/status/{status}', 'getRecordsByStatus');
					Route::get('/search/{search}', 'getRecordsBySearch');
					Route::get('/id/{ticketReport}', 'getRecordsOne');
					Route::patch('/send/email', 'update');
				});
				# Configuration
				Route::prefix('configuration')->group(function () {
					// App Versions
					Route::controller(AppVersionController::class)->prefix('app-versions')->group(function () {
						Route::get('/all/records', 'getRecordsAll');
						Route::post('/store', 'store');
						Route::patch('/id/{appVersion}/update', 'update');
						Route::delete('/id/{appVersion}/destroy', 'destroy');
					});

					// School/Campus
					Route::controller(CampusController::class)->prefix('campus')->group(function () {
						Route::get('/all/records', 'getRecordsAll');
						Route::post('/store', 'store');
						Route::patch('/id/{campus}/update', 'update');
						Route::delete('/id/{campus}/destroy', 'destroy');
					});

					// Categories
					Route::controller(CategoryController::class)->prefix('category')->group(function () {
						Route::get('/all/records', 'getRecordsAll');
						Route::post('/store', 'store');
						Route::patch('/id/{category}/update', 'update');
						Route::delete('/id/{category}/destroy', 'destroy');
					});

					// Vote Points
					Route::controller(VotePointController::class)->prefix('vote-points')->group(function () {
						Route::get('/all/records', 'getRecordsAll');
						Route::post('/store', 'store');
						Route::patch('/id/{votePoint}/update', 'update');
						Route::delete('/id/{votePoint}/destroy', 'destroy');
					});
				});
			});
		});
	});
});
<?php

use App\Http\Controllers\Api\CandidateController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\VotePointController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'guest'])->group(function () {
	Route::prefix('{version}')->group(function () {
		Route::get('/candidates', [CandidateController::class, 'index']);
		Route::get('/{candidate}/candidates', [CandidateController::class, 'retrieve']);
		Route::get('/{searchQuery}/search', [CandidateController::class, 'search']);
		Route::get('/category', [CategoryController::class, 'retrieve']);
		Route::get('/{categoryQuery}/category', [CandidateController::class, 'category']);
		Route::get('/amount/vote-points', [VotePointController::class, 'retrieve']);
		Route::get('/{votePointsId}/vote-points', [VotePointController::class, 'show']);
		Route::post('/vote/store', [VotePointController::class, 'store']);
	});
});
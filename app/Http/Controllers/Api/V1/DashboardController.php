<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\ViewService;
use App\Services\VoteService;
use Illuminate\Support\Facades\ModelNotFoundException;

class DashboardController extends Controller {

	public function __construct(protected VoteService $voteService,
		protected ViewService $viewService) {}

	public function countPendingVerifiedAmount(String $appVersionName) {
		try {
			return $this->voteService->countAllVotesByStatus($appVersionName);
		} catch (ModelNotFoundException $e) {
			return response()->json(['success' => false, $e->getMessage()]);
		} catch (\Throwable $e) {
			return response()->json(['success' => false, $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured. Code[VID-D]']);
		}
	}

	public function getRecentlyVoters(String $appVersionName, int $limit, int $offset) {
		try {
			return $this->voteService->loadMoreVotes($appVersionName, $limit, $offset);
		} catch (ModelNotFoundException $e) {
			return response()->json(['success' => false, $e->getMessage()]);
		} catch (\Throwable $e) {
			return response()->json(['success' => false, $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured. Code[VID-D]']);
		}
	}

	public function getMostVotesCandidates(String $appVersionName, int $limit) {
		try {
			return $this->voteService->getMostVotesCandidates($appVersionName, $limit);
		} catch (ModelNotFoundException $e) {
			return response()->json(['success' => false, $e->getMessage()]);
		} catch (\Throwable $e) {
			return response()->json(['success' => false, $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured. Code[VID-D]']);
		}
	}

	public function countPageViewsPerDay(String $appVersionName, int $limit) {
		try {
			return $this->viewService->getPageViewsPerDay($appVersionName, $limit);
		} catch (ModelNotFoundException $e) {
			return response()->json(['success' => false, $e->getMessage()]);
		} catch (\Throwable $e) {
			return response()->json(['success' => false, $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured. Code[VID-D]']);
		}
	}
}

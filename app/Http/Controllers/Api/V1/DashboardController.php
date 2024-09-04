<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CandidateResource;
use App\Http\Resources\Api\VoteResource;
use App\Services\CandidateService;
use App\Services\ViewService;
use App\Services\VoteService;
use Illuminate\Support\Facades\ModelNotFoundException;
use Illuminate\Support\Facades\Response;

class DashboardController extends Controller {

	public function __construct(
		protected VoteService $voteService,
		protected ViewService $viewService,
		protected CandidateService $candidateService) {}

	public function countPendingVerifiedAmount(string $appVersionName) {
		try {
			$vote = $this->voteService->countAllVotesByStatus($appVersionName);

			return Response::json($vote);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, $e->getMessage()]);
		} catch (\Throwable $e) {
			return Response::json(['success' => false, $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured. Code[VID-D]']);
		}
	}

	public function getRecentlyVoters(string $appVersionName, int $limit, int $offset) {
		try {
			$votes = $this->voteService->getAllVotes($appVersionName, $limit, $offset);

			#\Log::info(json_encode(VoteResource::collection($votes), JSON_PRETTY_PRINT));

			return VoteResource::collection($votes);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, $e->getMessage()]);
		} catch (\Throwable $e) {
			return Response::json(['success' => false, $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured. Code[VID-D]']);
		}
	}

	public function getOverallRanking(string $appVersionName, int $limit) {
		try {
			$candidates = $this->candidateService->getCandidatesWithMostVotes($appVersionName, $limit);

			return CandidateResource::collection($candidates);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured. Code[VID-CDID]']);
		}
	}

	public function countPageViewsPerDay(string $appVersionName, int $limit) {
		try {
			$views = $this->viewService->getPageViewsPerDay($appVersionName, $limit);

			return Response::json(['success' => true, 'message' => 'Tested',
				'totalPageViews' => $views,
			]);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, $e->getMessage()]);
		} catch (\Throwable $e) {
			return Response::json(['success' => false, $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured. Code[VID-D]']);
		}
	}
}

<?php

namespace App\Services;

use App\Exceptions\App\Admin\UpdateDataException;
use App\Models\AppVersion;
use App\Models\Candidate;
use App\Models\Category;
use App\Models\Vote;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class VoteService {

	public function getAllVotes(String $appVersionName) {
		$appVersion = AppVersion::where('name', $appVersionName)->firstOrFail();
		return Cache::remember('votes', 60 * 60 * 24, function () use ($appVersion) {
			$votes = Vote::with(['appVersion', 'candidate', 'votePoint'])
				->where('app_version_id', $appVersion->avid)
				->orderBy('created_at', 'desc')
				->get();
			//\Illuminate\Support\Facades\Log::info($votes);
			return $votes;
		});
	}

	public function loadMoreVotes(String $appVersionName, int $limit, int $offset) {
		$appVersion = AppVersion::where('name', $appVersionName)->firstOrFail();
		return Cache::remember('votesMore', 60 * 60 * 24,
			function () use ($appVersion, $limit, $offset) {
				$votes = Vote::with(['appVersion', 'candidate', 'votePoint'])
					->where('app_version_id', $appVersion->avid)
					->orderBy('created_at', 'desc')
					->skip($offset)
					->take($limit)
					->get();
				//\Illuminate\Support\Facades\Log::info($votes);
				return $votes;
			});
	}

	public function getOneVotes(int $voteId) {
		$vote = Vote::findOrFail($voteId);
		$cacheKey = 'votesId:' . $voteId;
		return Cache::remember($cacheKey, 60 * 60 * 24, function () use ($vote) {
			$votes = $vote->with(['appVersion', 'candidate', 'votePoint'])
				->where('vid', $vote->vid)
				->get();

			return $votes;
		});
	}

	public function getVotesByStatus(String $appVersionName, int $status) {
		$appVersion = AppVersion::where('name', $appVersionName)->firstOrFail();
		$cacheKey = 'votesByStatus:' . $status;
		return Cache::remember($cacheKey, 60 * 60 * 24, function () use ($appVersion, $status) {
			$votes = Vote::with(['appVersion', 'candidate', 'votePoint'])
				->where('app_version_id', $appVersion->avid)
				->where('status', $status)
				->orderBy('created_at', 'desc')
				->get();

			return $votes;
		});
	}

	public function getVotesBySearch(String $appVersionName, String $search) {
		$appVersion = AppVersion::where('name', $appVersionName)->firstOrFail();
		return Cache::remember('votesBySearch', 60 * 60 * 24, function () use ($appVersion, $search) {
			$votes = Vote::with(['appVersion', 'candidate', 'votePoint'])
				->where('app_version_id', $appVersion->avid)
				->where(function ($query) use ($search) {
					$query->where('referrence_no', 'like', '%' . $search . '%');
				})
				->orderBy('created_at', 'desc')
				->get();

			return $votes;
		});
	}

	public function getMostVotesCandidates(String $appVersionName, int $limit) {
		//group the votes by candidates. Candidates must be unique candidates
		// for example there is 2 votes that is categorize in  candidate 1
		// this 2 votes will be in candidate 1, so that candidate 1 will
		// now have 2 votes.

		//then each candidate, will calculate and sum the total vote points

		//then rank the each canditates base on their total vote poiints

		//then return to the client side the 5 candidates with highest vote points and with its
		//calculated vote points for each 5 candidates
		$appVersion = AppVersion::where('name', $appVersionName)->firstOrFail();
		return Cache::remember('mostVotesCandidates', 60 * 60 * 24,
			function () use ($appVersion, $limit) {
				$mostVotesCandidates = Vote::with(['candidate', 'votePoint'])
					->join('vote_points', 'votes.vote_points_id', '=', 'vote_points.vpid')
					->where('votes.app_version_id', $appVersion->avid)
					->where('votes.status', 0) //verified
					->groupBy('votes.candidate_id')
					->selectRaw('votes.candidate_id, COUNT(votes.vid) as total_voters')
					->selectRaw('votes.candidate_id, SUM(vote_points.point) as total_points')
					->selectRaw('votes.candidate_id, SUM(vote_points.amount) as total_amount')
					->orderByDesc('total_points')
					->limit($limit)
					->get();
				//\Illuminate\Support\Facades\Log::info($mostVotesCandidates);
				return $mostVotesCandidates;
			});
	}

	public function getMostVotesCandidatesByCategory(String $appVersionName, int $limit) {
		//group the votes by category. Category must be unique for each candidates

		//then each candidate perc ategory, will calculate and sum the total vote points
		// for example:
		//category (male) sum the total vote points
		//category (female) sum the total vote points
		//category (pride) sum the total vote points

		//then rank the each canditates per category base on their total vote poiints
		// for example:
		//category (male)
		//Jayce - with 900 vote points
		//Zed - with 870 vote points
		//Darius - with 400 vote points

		//category (female) sum the total vote points
		//Lux - with 1540 vote points
		//Morgana - with 1005 vote points
		//Tristana - with 980 vote points

		//category (pride) sum the total vote points
		//Taric - with 1020 vote points
		//Ezreal - with 810 vote points
		//TwistedFate - with 720 vote points

		//then return to the client side the 3 candidates with highest vote points per category
		//for specified app version and with its calculated vote points for each 3 candidates per category

		//map app version
		$appVersion = AppVersion::where('name', $appVersionName)->firstOrFail();
		return Cache::remember('mostVotesCandidatesByCategory', 60 * 60 * 24,
			function () use ($appVersion, $limit) {
				$mostVotesCandidatesCategory = [];

				//get all categories for specific app version
				$categories = Category::where('app_version_id', $appVersion->avid)->get();

				//get all candidates (na may votes) for each category
				foreach ($categories as $category) {
					$candidates = Candidate::where('category_id', $category->ctid)
						->with(['votes' => function ($query) use ($appVersion) {
							$query->where('app_version_id', $appVersion->avid)
								->where('status', 0)
								->with('votePoint');
						}])
						->get();

					$candidatesData = [];

					//calculate the sum of all votes points for each candidates
					foreach ($candidates as $candidate) {
						$totalPoints = $candidate->votes->sum('votePoint.point');
						//\Illuminate\Support\Facades\Log::info($candidate->vote);
						$candidatesData[] = [
							'candidate_name' => $candidate->name,
							'total_points' => $totalPoints,
						];
					}

					if (!empty($candidatesData)) {
						usort($candidatesData, function ($a, $b) {
							return $b['total_points'] - $a['total_points'];
						});

						$topCandidates = array_slice($candidatesData, 0, $limit);

						$categoryData = new \stdClass();
						$categoryData->category_name = $category->name;
						$categoryData->top_candidates = $topCandidates;

						$mostVotesCandidatesCategory[] = $categoryData;
					}
				}
				//\Illuminate\Support\Facades\Log::info($mostVotesCandidatesCategory);
				return (object) $mostVotesCandidatesCategory;
			});
	}

	public function countAllVotesByStatus(String $appVersionName) {
		$appVersion = AppVersion::where('name', $appVersionName)->firstOrFail();
		return Cache::remember('votesPendingVerifiedSpamAmount', 60 * 60 * 24,
			function () use ($appVersion) {
				$verified = Vote::where('app_version_id', $appVersion->avid)
					->where('status', '0')
					->count();

				$pending = Vote::where('app_version_id', $appVersion->avid)
					->where('status', '1')
					->count();

				$spam = Vote::where('app_version_id', $appVersion->avid)
					->where('status', '2')
					->count();

				$totalAmount = Vote::with(['votePoint'])
					->join('vote_points', 'votes.vote_points_id', '=', 'vote_points.vpid')
					->where('votes.app_version_id', $appVersion->avid)
					->where('votes.status', 0)
					->sum('vote_points.amount');

				$totalVotes = Vote::where('app_version_id', $appVersion->avid)->count();

				return [
					'success' => true,
					'message' => 'success',
					'verified' => $verified,
					'pending' => $pending,
					'totalAmount' => $totalAmount,
					'totalVotes' => $totalVotes,
					'spam' => $spam,
				];
			});
	}

	public function createNewVote(array $data) {
		$appVersion = AppVersion::where('name', $data['app_version_name'])->firstOrFail();
		return DB::transaction(function () use ($appVersion, $data) {
			$created = Vote::query()->create([
				'app_version_id' => $appVersion->avid,
				'candidate_id' => data_get($data, 'candidate_id', null),
				'vote_points_id' => data_get($data, 'vote_points_id', null),
				'contact_no' => data_get($data, 'contact_no', null),
				'email' => data_get($data, 'email', null),
				'referrence_no' => data_get($data, 'referrence_no', null),
				'status' => data_get($data, 'status', '1'), //pending
				'created_at' => data_get($data, 'created_at', now()),
				'updated_at' => data_get($data, 'updated_at', null),
			]);

			if (!$created) {
				throw new CreateDataException('Failed to submit votes.');
			}

			return response()->json(['success' => true, 'message' => 'Your vote has been successfully submitted.']);
		});
	}

	public function updateVote(array $data) {
		if (!$this->hasChangesOccurred($data)) {
			return response()->json(['success' => false, 'message' => 'No changes occured', 'type' => 'info']);
		}

		if ($this->isDuplicateVote($data)) {
			return response()->json(['success' => false, 'message' => 'Cannot duplicate vote.', 'type' => 'warning']);
		}

		$appVersion = AppVersion::where('name', $data['app_version_name'])->firstOrFail();
		$vote = Vote::findOrFail($data['vid']);
		return DB::transaction(function () use ($appVersion, $vote, $data) {
			$candidateId = empty($data['candidate_id'])
			|| $data['candidate_id'] == null
			|| $data['candidate_id'] == 'undefined'
			? $vote->candidate_id
			: $data['candidate_id'];

			$votePointsId = empty($data['vote_points_id'])
			|| $data['vote_points_id'] == null
			|| $data['vote_points_id'] == 'undefined'
			? $vote->vote_points_id
			: $data['vote_points_id'];

			$updated = $vote->update([
				'app_version_id' => $appVersion->avid,
				'candidate_id' => $candidateId,
				'vote_points_id' => $votePointsId,
				'contact_no' => data_get($data, 'contact_no', $vote->contact_no),
				'email' => data_get($data, 'email', $vote->email),
				'referrence_no' => data_get($data, 'referrence_no', $vote->referrence_no),
				'status' => data_get($data, 'status', $vote->status),
				'updated_at' => data_get($data, 'updated_at', now()),
			]);

			if (!$updated) {
				throw new UpdateDataException('Failed to update votes');
			}

			return response()->json(['success' => true, 'message' => 'Vote updated successfully.']);
		});
	}

	public function updateVotesByStatus(array $data) {
		$vote = Vote::findOrFail($data['vid']);
		return DB::transaction(function () use ($vote, $data) {
			$updated = $vote->update([
				'status' => data_get($data, 'status', $vote->status),
			]);
			if (!$updated) {
				throw new UpdateDataException('Failed to update status of votes');
			}

			return response()->json(['success' => true, 'message' => 'Vote status updated successfully.']);
		});
	}

	public function deleteVote(int $voteId) {
		$vote = Vote::findOrFail($voteId);
		return DB::transaction(function () use ($vote) {
			$deleted = $vote->delete();
			if (!$deleted) {
				throw new DeleteDataException('Failed to delete vote');
			}

			return response()->json(['success' => true, 'message' => 'Vote deleted successfully']);
		});
	}

	private function isDuplicateVote(array $data): bool {
		return $this->referrenceNumberExists($data['referrence_no'], $data['vid']);
	}

	private function hasChangesOccurred(array $data): bool {
		$vote = Vote::findOrFail($data['vid']);
		$vote->fill($data);
		return $vote->isDirty();
	}

	private function referrenceNumberExists(float $referrenceNo, int $voteId): bool {
		return Vote::where('referrence_no', $referrenceNo)
			->where('vid', '<>', $voteId)
			->exists();
	}
}
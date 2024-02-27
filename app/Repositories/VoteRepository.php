<?php

namespace App\Repositories;

use App\Exceptions\App\Admin\CreateDataException;
use App\Exceptions\App\Admin\DeleteDataException;
use App\Exceptions\App\Admin\UpdateDataException;
use App\Interfaces\IRepository;
use App\Models\AppVersion;
use App\Models\Candidate;
use App\Models\Category;
use App\Models\Vote;
use Illuminate\Support\Facades\DB;
use stdClass;

class VoteRepository implements IRepository {

	public function getAll(String $appVersionName = ""): object {
		$appVersion = AppVersion::where('name', $appVersionName)->first();
		$votes = Vote::with(['appVersion', 'candidate', 'votePoint'])
			->where('app_version_id', $appVersion->avid)
			->orderBy('created_at', 'desc')
			->limit(10)
			->offset(0)
			->get();

		//\Illuminate\Support\Facades\Log::info($votes);
		return $votes;
	}

	public function loadMoreData(String $appVersionName, int $limit, int $offset): object {
		$appVersion = AppVersion::where('name', $appVersionName)->first();
		$votes = Vote::with(['appVersion', 'candidate', 'votePoint'])
			->where('app_version_id', $appVersion->avid)
			->orderBy('created_at', 'desc')
			->skip($offset)
			->take($limit)
			->get();
		//\Illuminate\Support\Facades\Log::info($votes);
		return $votes;
	}

	public function getAllByStatus(String $appVersionName, int $status): object {
		$appVersion = AppVersion::where('name', $appVersionName)->first();
		$votes = Vote::with(['appVersion', 'candidate', 'votePoint'])
			->where('app_version_id', $appVersion->avid)
			->where('status', $status)
			->orderBy('created_at', 'desc')
			->get();

		return $votes;
	}

	public function getAllBySearch(String $appVersionName, String $search): object {
		$appVersion = AppVersion::where('name', $appVersionName)->first();
		$votes = Vote::with(['appVersion', 'candidate', 'votePoint'])
			->where('app_version_id', $appVersion->avid)
			->where(function ($votes) use ($search) {
				$votes->where('referrence_no', 'like', '%' . $search . '%');
			})
			->orderBy('created_at', 'desc')
			->get();

		return $votes;
	}

	public function count(String $appVersionName = "", int $status = null): array {
		$appVersion = AppVersion::where('name', $appVersionName)->first();

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
	}

	public function getMostVotes(String $appVersionName, int $limit): object {

		//group the votes by candidates. Candidates must be unique candidates
		// for example there is 2 votes that is categorize in  candidate 1
		// this 2 votes will be in candidate 1, so that candidate 1 will
		// now have 2 votes.

		//then each candidate, will calculate and sum the total vote points

		//then rank the each canditates base on their total vote poiints

		//then return to the client side the 5 candidates with highest vote points and with its
		//calculated vote points for each 5 candidates
		$appVersion = AppVersion::where('name', $appVersionName)->first();
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
	}

	public function getMostVotesCategory(String $appVersionName, int $limit): object {
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
		$mostVotesCandidatesCategory = [];

		//map app version
		$appVersion = AppVersion::where('name', $appVersionName)->first();

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

				$categoryData = new stdClass();
				$categoryData->category_name = $category->name;
				$categoryData->top_candidates = $topCandidates;

				$mostVotesCandidatesCategory[] = $categoryData;
			}
		}

		//\Illuminate\Support\Facades\Log::info($mostVotesCandidatesCategory);
		return (object) $mostVotesCandidatesCategory;
	}

	public function getOne(int $vid): object {
		$data = Vote::with(['appVersion', 'candidate', 'votePoint'])->where('vid', $vid)->get();
		return $data;
	}

	public function create(array $attributes): array {
		$appVersion = AppVersion::where('name', $attributes['app_version_name'])->first();
		return DB::transaction(function () use ($appVersion, $attributes) {
			$created = Vote::query()->create([
				'app_version_id' => $appVersion->avid,
				'candidate_id' => data_get($attributes, 'candidate_id', null),
				'vote_points_id' => data_get($attributes, 'vote_points_id', null),
				'contact_no' => data_get($attributes, 'contact_no', null),
				'email' => data_get($attributes, 'email', null),
				'referrence_no' => data_get($attributes, 'referrence_no', null),
				'status' => data_get($attributes, 'status', '1'), //pending
				'created_at' => data_get($attributes, 'created_at', now()),
				'updated_at' => data_get($attributes, 'updated_at', null),
			]);

			if (!$created) {
				throw new CreateDataException('Something went wrong! Failed to submit votes.');
			}

			return ['success' => true, 'message' => 'Your vote has been successfully submitted.'];
		});
	}

	public function updateStatus(array $attributes): array {
		$vote = $this->findVote((int) $attributes['vid']);
		return DB::transaction(function () use ($vote, $attributes) {
			$updated = Vote::where('vid', $vote->vid)->update([
				'status' => data_get($attributes, 'status', $vote->status),
			]);
			if (!$updated) {
				throw new UpdateDataException('Something went wrong! Failed to update status of votes');
			}

			return ['success' => true, 'message' => 'Vote status updated successfully.'];
		});
	}

	public function update(array $attributes): array {
		$appVersion = AppVersion::where('name', $attributes['app_version_name'])->first();
		$vote = $this->findVote((int) $attributes['vid']);
		$candidateId = empty($attributes['candidate_id'])
		|| $attributes['candidate_id'] == null
		|| $attributes['candidate_id'] == 'undefined'
		? $vote->candidate_id
		: $attributes['candidate_id'];

		$votePointsId = empty($attributes['vote_points_id'])
		|| $attributes['vote_points_id'] == null
		|| $attributes['vote_points_id'] == 'undefined'
		? $vote->vote_points_id
		: $attributes['vote_points_id'];

		return DB::transaction(function () use ($appVersion, $vote, $candidateId, $votePointsId, $attributes) {
			$updated = Vote::query()->where('vid', $vote->vid)->update([
				'app_version_id' => $appVersion->avid,
				'candidate_id' => $candidateId,
				'vote_points_id' => $votePointsId,
				'contact_no' => data_get($attributes, 'contact_no', $vote->contact_no),
				'email' => data_get($attributes, 'email', $vote->email),
				'referrence_no' => data_get($attributes, 'referrence_no', $vote->referrence_no),
				'status' => data_get($attributes, 'status', $vote->status),
				'created_at' => data_get($attributes, 'created_at', $vote->created_at),
				'updated_at' => data_get($attributes, 'updated_at', now()),
			]);

			if (!$updated) {
				throw new UpdateDataException('Something went wrong! Failed to update votes');
			}

			return ['success' => true, 'message' => 'Vote updated successfully.'];
		});
	}

	public function delete(int $vid): array {
		$vote = $this->findVote($vid);
		return DB::transaction(function () use ($vote) {
			$deleted = $vote->delete();
			if (!$deleted) {
				throw new DeleteDataException('Something went wrong! Failed to delete vote');
			}

			return ['success' => true, 'message' => 'Vote deleted successfully'];
		});
	}

	public function referrenceNumberExists(float $referrenceNo, int $vid): bool {
		return Vote::where('referrence_no', $referrenceNo)
			->where('vid', '<>', $vid)
			->exists();
	}

	public function findVote(int $vid): Vote {
		return Vote::findOrFail($vid);
	}
}
<?php

namespace App\Services;

use App\Exceptions\App\Admin\ChangesOccuredException;
use App\Exceptions\App\Admin\DuplicateDataException;
use App\Exceptions\App\Admin\UpdateDataException;
use App\Helpers\Decoder;
use App\Models\AppVersion;
use App\Models\Vote;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class VoteService {

	public function getAllVotes(string $appVersionName) {
		$appVersion = AppVersion::where('name', $appVersionName)->firstOrFail();
		return Cache::remember('votes:' . $appVersion->avid, 60 * 60 * 24, function () use ($appVersion) {
			$votes = Vote::with(['appVersion', 'candidate', 'votePoint'])
				->where('app_version_id', $appVersion->avid)
				->orderBy('created_at', 'desc')
				->skip(0)
				->take(10)
				->get();

			return $votes;
		});
	}

	public function loadMoreVotes(string $appVersionName, int $limit, int $offset) {
		$appVersion = AppVersion::where('name', $appVersionName)->firstOrFail();
		$votes = Vote::with(['appVersion', 'candidate', 'votePoint'])
			->where('app_version_id', $appVersion->avid)
			->orderBy('created_at', 'desc')
			->skip($offset)
			->take($limit)
			->get();

		return $votes;
	}

	public function getOneVotes(string $voteId) {
		$vid = Decoder::decodeIds($voteId);
		return Cache::remember('votesId:' . $vid, 60 * 60 * 24, function () use ($vid) {
			$vote = Vote::with(['appVersion', 'candidate', 'votePoint'])->findOrFail($vid);
			return $vote;
		});
	}

	public function getVotesByStatus(string $appVersionName, int $status) {
		$appVersion = AppVersion::where('name', $appVersionName)->firstOrFail();
		$votes = Vote::with(['appVersion', 'candidate', 'votePoint'])
			->where('app_version_id', $appVersion->avid)
			->where('status', $status)
			->orderBy('created_at', 'desc')
			->get();

		return $votes;
	}

	public function getVotesBySearch(string $appVersionName, string $search) {
		$appVersion = AppVersion::where('name', $appVersionName)->firstOrFail();
		$votes = Vote::with(['appVersion', 'candidate', 'votePoint'])
			->where('app_version_id', $appVersion->avid)
			->where(function ($query) use ($search) {
				$query->where('referrence_no', 'like', '%' . $search . '%');
			})
			->orderBy('created_at', 'desc')
			->get();

		return $votes;
	}

	public function countAllVotesByStatus(string $appVersionName) {
		$appVersion = AppVersion::where('name', $appVersionName)->firstOrFail();
		return Cache::remember('votesPendingVerifiedSpamAmount:' . $appVersion->avid, 60 * 60 * 24, function () use ($appVersion) {
			$votes = Vote::with(['votePoint'])->where('app_version_id', $appVersion->avid)->get();
			$counts = [
				'success' => true,
				'message' => 'success',
				'verified' => 0,
				'pending' => 0,
				'totalAmount' => 0,
				'totalVotes' => $votes->count(),
				'spam' => 0,
			];

			foreach($votes as $vote) {
				switch ($vote->status) {
					case 0: //verified
						$counts['verified']++;
						$counts['totalAmount'] += $vote->votePoint->amount;
						break;

					case 1: //pending
						$counts['pending']++;
						break;

					case 2: //spam
						$counts['spam']++;
						break;

					default:
						break;
				}
			}

			return $counts;
		});
	}

	#TODO:////
	public function getAllVotesRecordsByCandidates(int $candidateId) {
		$votes = Vote::with(['candidate', 'votePoint'])->where('candidate_id', $candidateId)->get();
		return $votes;
	}

	public function countTotalVerifiedVotesByCandidate(int $candidateId) {
		$totalVerified = Vote::where('candidate_id', $candidateId)->where('status', 0)->count();
		return $totalVerified;
	}

	public function countTotalPendingVotesByCandidate(int $candidateId) {
		$totalPending = Vote::where('candidate_id', $candidateId)->where('status', 1)->count();
		return $totalPending;
	}

	public function countTotalSpamVotesByCandidate(int $candidateId) {
		$totalSpam = Vote::where('candidate_id', $candidateId)->where('status', 2)->count();
		return $totalSpam;
	}

	public function countTotalVotesByCandidate(int $candidateId) {
		$totalVoteRecords = Vote::where('candidate_id', $candidateId)->count();
		return $totalVoteRecords;
	}

	public function calculateAmountVerifiedByCandidate(int $candidateId) {
		$totalAmount = Vote::where('candidate_id', $candidateId)
			->where('status', 0)
			->join('vote_points', 'votes.vote_points_id', '=', 'vote_points.vpid')
			->sum('vote_points.amount');
		return $totalAmount;
	}

	public function calculatePointsVerifiedByCandidate(int $candidateId) {
		$totalVotePoints = Vote::where('candidate_id', $candidateId)
			->where('status', 0)
			->join('vote_points', 'votes.vote_points_id', '=', 'vote_points.vpid')
			->sum('vote_points.point');

		return $totalVotePoints;
	}

	public function getTotalOfSummaryVotesCandidates(string $appVersionName) {
    // Retrieve the specific app version by name
    $appVersion = AppVersion::where('name', $appVersionName)->firstOrFail();

    // Fetch the summarized vote points for each candidate
    $summaryCandidatesVotes = Vote::where('votes.app_version_id', $appVersion->avid) // Specify 'votes' table explicitly
        ->where('votes.status', 0) // Filter only verified votes
        ->join('candidates', 'votes.candidate_id', '=', 'candidates.cdid')
        ->join('categories', 'candidates.category_id', '=', 'categories.ctid')
        ->join('vote_points', 'votes.vote_points_id', '=', 'vote_points.vpid')
        ->groupBy([
            'votes.candidate_id',        // Group by candidate ID
            'candidates.candidate_no',   // Group by candidate number
            'categories.name',           // Group by category name
            'candidates.name'            // Group by candidate name
        ])
        ->selectRaw('
            candidates.candidate_no as candidate_no,
            categories.name as category,
            candidates.name as candidate_name,
            SUM(vote_points.point) as total_current_points
        ')
        ->get()
        ->map(function($item) {
            return [
                'candidate_no' => $item->candidate_no,
                'category' => $item->category,
                'candidate_name' => $item->candidate_name,
                'total_current_points' => $item->total_current_points,
            ];
        });

    return $summaryCandidatesVotes;
	}



	public function createNewVote(array $data) {
		$appVersion = AppVersion::where('name', $data['app_version_name'])->firstOrFail();
		return DB::transaction(function () use ($appVersion, $data) {
			$cdid = Decoder::decodeIds($data['candidate_id']);
			$vpid = Decoder::decodeIds($data['vote_points_id']);

			$created = Vote::query()->create([
				'app_version_id' => $appVersion->avid,
				'candidate_id' => $cdid,
				'vote_points_id' => $vpid,
				'contact_no' => data_get($data, 'contact_no', null),
				'email' => data_get($data, 'email', null),
				'referrence_no' => data_get($data, 'referrence_no', null),
				'status' => data_get($data, 'status', '1'), //pending
				'created_at' => data_get($data, 'created_at', now()),
				'updated_at' => data_get($data, 'updated_at', null),
			]);

			if(!$created) {
				throw new CreateDataException('Failed to submit votes.', 422);
			}

			return;
		});
	}

	public function updateVote(array $data) {
		$vid = Decoder::decodeIds($data['vid']);
		$vote = Vote::findOrFail($vid);
		$appVersion = AppVersion::where('name', $data['app_version_name'])->firstOrFail();

		$cdid = !empty($data['candidate_id']) || $data['candidate_id'] != null ? Decoder::decodeIds($data['candidate_id']) : $vote->candidate_id;
		$vpid = !empty($data['vote_points_id']) || $data['vote_points_id'] != null ? Decoder::decodeIds($data['vote_points_id']) : $vote->vote_points_id;

		$data['vid'] = $vote->vid;
		$data['candidate_id'] = $cdid;
		$data['vote_points_id'] = $vpid;

		if (!$this->hasChangesOccurred($data)) {
			throw new ChangesOccuredException('No changes occured.');
		}

		if ($this->referrenceNumberExists($data['referrence_no'], $data['vid'])) {
			throw new DuplicateDataException('Cannot duplicate vote.');
		}

		return DB::transaction(function () use ($appVersion, $vote, $data) {
			$updated = $vote->update([
				'app_version_id' => $appVersion->avid,
				'candidate_id' => data_get($data, 'candidate_id', $vote->candidate_id),
				'vote_points_id' => data_get($data, 'vote_points_id', $vote->vote_points_id),
				'contact_no' => data_get($data, 'contact_no', $vote->contact_no),
				'email' => data_get($data, 'email', $vote->email),
				'referrence_no' => data_get($data, 'referrence_no', $vote->referrence_no),
				'status' => data_get($data, 'status', $vote->status),
				'updated_at' => data_get($data, 'updated_at', now()),
			]);

			if (!$updated) {
				throw new UpdateDataException('Failed to update votes.', 422);
			}

			return;
		});
	}

	public function updateVotesByStatus(array $data) {
		$vid = Decoder::decodeIds($data['vid']);
		$vote = Vote::findOrFail($vid);
		return DB::transaction(function () use ($vote, $data) {
			$updated = $vote->update(['status' => data_get($data, 'status', $vote->status)]);
			if (!$updated) {
				throw new UpdateDataException('Failed to update status of votes.', 422);
			}

			return;
		});
	}

	public function deleteVote(string $voteId) {
		$vid = Decoder::decodeIds($voteId);
		$vote = Vote::findOrFail($vid);
		return DB::transaction(function () use ($vote) {
			$deleted = $vote->delete();
			if (!$deleted) {
				throw new DeleteDataException('Failed to delete vote.', 422);
			}

			return;
		});
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
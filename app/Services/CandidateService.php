<?php

namespace App\Services;

use App\Exceptions\App\Admin\ChangesOccuredException;
use App\Exceptions\App\Admin\CreateDataException;
use App\Exceptions\App\Admin\DeleteDataException;
use App\Exceptions\App\Admin\UpdateDataException;
use App\Helpers\Decoder;
use App\Models\AppVersion;
use App\Models\Candidate;
use App\Models\Category;
use App\Services\VoteService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CandidateService {
	public function __construct(protected VoteService $voteService) {}

	public function getAllCandidates(string $appVersionName) {
		$appVersion = AppVersion::where('name', $appVersionName)->firstOrFail();
		return Cache::remember('candidates:' . $appVersion->avid, 60 * 60 * 24, function () use ($appVersion) {
				$candidates = Candidate::orderBy('created_at', 'desc')->where('app_version_id', $appVersion->avid)->get();
				return $candidates;
			});
	}

	public function loadMoreCandidates(string $appVersionName, int $limit, int $offset) {
		$appVersion = AppVersion::where('name', $appVersionName)->firstOrFail();
		$candidates = Candidate::where('app_version_id', $appVersion->avid)
			->orderBy('created_at', 'desc')
			->skip($offset)
			->take($limit)
			->get();

		return $candidates;
	}

	public function getOneCandidate(string $candidateId) {
		$ctid = Decoder::decodeIds($candidateId);
		$candidate = Candidate::with(['appVersion', 'campus', 'category'])->findOrFail($ctid);

		$candidate->votes = $this->voteService->getAllVotesRecordsByCandidates($candidate->cdid);
		$candidate->totalVerified = $this->voteService->countTotalVerifiedVotesByCandidate($candidate->cdid);
		$candidate->totalPending = $this->voteService->countTotalPendingVotesByCandidate($candidate->cdid);
		$candidate->totalSpam = $this->voteService->countTotalSpamVotesByCandidate($candidate->cdid);
		$candidate->totalVotes = $this->voteService->countTotalVotesByCandidate($candidate->cdid);
		$candidate->totalAmount = $this->voteService->calculateAmountVerifiedByCandidate($candidate->cdid);
		$candidate->totalPoints = $this->voteService->calculatePointsVerifiedByCandidate($candidate->cdid);

		return $candidate;
	}

	public function getFilterSearchCandidates(string $appVersionName, string $searchQuery) {
		$appVersion = AppVersion::where('name', $appVersionName)->firstOrFail();
		return Cache::remember('candidateSearch:' . $searchQuery, 60 * 60 * 24, function () use ($appVersion, $searchQuery) {
			$candidate = Candidate::where('app_version_id', $appVersion->avid)
				->where(function ($query) use ($searchQuery) {
					$query->where('name', 'like', '%' . $searchQuery . '%')
						->orWhere('candidate_no', 'like', '%' . $searchQuery . '%');
				})
				->get();

			return $candidate;
		});
	}

	public function getCandidatesByCategory(string $appVersionName, string $categoryId) {
		$appVersion = AppVersion::where('name', $appVersionName)->firstOrFail();
		$ctid = Decoder::decodeIds($categoryId);
		$category = Category::findOrFail($ctid);

		return Cache::remember('candidateCategory:' . $category->ctid, 60 * 60 * 24, function () use ($appVersion, $category) {
			$candidate = Candidate::where('app_version_id', $appVersion->avid)
				->where('category_id', $category->ctid)
				->orderBy('candidate_no', 'asc')
				->get();

			\Log::info(print_r($candidate, true));

			return $candidate;
		});
	}

	public function createCandidate(array $data) {
		return DB::transaction(function () use ($data) {
			$avid = Decoder::decodeIds($data['app_version_id']);
			$scid = !empty($data['school_campus_id']) || $data['school_campus_id'] != null ? Decoder::decodeIds($data['school_campus_id']) : null;
			$ctid = Decoder::decodeIds($data['category_id']);
			$file = $data['image'] ?? null;

			if($file instanceof \Illuminate\Http\UploadedFile  && $file->isValid()) {
				//store the uploaded file in the 'storage/candidates/filename' folder
				$path = Storage::disk('public')->put('candidates', $file);
				// Assign the stored path to the 'image' key in the data array
				$data['image'] = $path;
			}

			$created = Candidate::query()->create([
				'app_version_id' => $avid,
				'school_campus_id' => $scid,
				'category_id' => $ctid,
				'candidate_no' => data_get($data, 'candidate_no', null),
				'name' => data_get($data, 'name', null),
				'motto_description' => data_get($data, 'motto_description', null),
				'image' => $data['image'],
				'created_at' => data_get($data, 'created_at', now()),
				'updated_at' => data_get($data, 'updated_at', null),
			]);

			if (!$created) {
				throw new CreateDataException('Failed to create new candidate.', 422);
			}

			return;
		});
	}

	public function updateCandidate(array $data) {
		//check if the id's is null before decoding if not null
		//then decode if null retain the previous record
		$cdid = Decoder::decodeIds($data['cdid']);
		$candidate = Candidate::findOrFail($cdid);
		$avid = !empty($data['app_version_id']) || $data['app_version_id'] != null
		? Decoder::decodeIds($data['app_version_id']) : $candidate->app_version_id;
		$scid = !empty($data['school_campus_id']) || $data['school_campus_id'] != null
		? Decoder::decodeIds($data['school_campus_id']) : $candidate->school_campus_id;
		$ctid = !empty($data['category_id']) || $data['category_id'] != null
		? Decoder::decodeIds($data['category_id']) : $candidate->category_id;

		$data['cdid'] = $candidate->cdid;
		$data['app_version_id'] = $avid;
		$data['school_campus_id'] = $scid;
		$data['category_id'] = $ctid;

		if (!$this->hasChangesOccurred($data)) {
			throw new ChangesOccuredException('No changes occured.');
		}

		if ($this->candidateExist($data['name'], $data['app_version_id'], $candidate->cdid)) {
			throw new ChangesOccuredException('Cannot duplicate candidate.');
		}

		return DB::transaction(function () use ($candidate, $data) {
			$file = $data['image'] ?? null;
			if ($file instanceof \Illuminate\Http\UploadedFile  && $file->isValid()) {
				$path = Storage::disk('public')->put('candidates', $file);
				$data['image'] = $path;
			}
			// If no new image is provided or the image data is 'undefined' or null
			elseif (!isset($data['image']) || $data['image'] === 'undefined' || $data['image'] === null) {
				$data['image'] = $candidate->image;
			}

			$updated = $candidate->update([
				'app_version_id' => data_get($data, 'app_version_id', $candidate->app_version_id),
				'school_campus_id' => data_get($data, 'school_campus_id', $candidate->school_campus_id),
				'category_id' => data_get($data, 'category_id', $candidate->category_id),
				'candidate_no' => data_get($data, 'candidate_no', $candidate->candidate_no),
				'name' => data_get($data, 'name', $candidate->name),
				'motto_description' => data_get($data, 'motto_description', $candidate->motto_description),
				'image' => data_get($data, 'image', $candidate->image),
				'updated_at' => data_get($data, 'updated_at', now()),
			]);

			if (!$updated) {
				throw new UpdateDataException('Failed to update candidate.', 422);
			}

			return;
		});
	}

	public function deleteCandidate(string $candidateId) {
		$ctid = Decoder::decodeIds($candidateId);
		$candidate = Candidate::findOrFail($ctid);
		return DB::transaction(function () use ($candidate) {
			$deleted = $candidate->delete();
			if (!$deleted) {
				throw new DeleteDataException('Failed to delete candidate.', 422);
			}

			return;
		});
	}

	public function getCandidatesWithMostVotes(string $appVersionName, int $limit) {
		$appVersion = AppVersion::where('name', $appVersionName)->firstOrFail();
		//(step 1): get all candidates that have votes
		$candidates = Candidate::where('app_version_id', $appVersion->avid)
			->with(['appVersion', 'category', 'campus', 'votes' => function ($query) {
				$query->with('votePoint');
			}])
			->get();

		foreach ($candidates as $candidate) {
			//(step 2): count total verified votes for each candidates
			$candidate->totalVerified = $this->voteService->countTotalVerifiedVotesByCandidate($candidate->cdid);
			//(step 3): count total pending votes for each candidates
			$candidate->totalPending = $this->voteService->countTotalPendingVotesByCandidate($candidate->cdid);
			//(step 4): count total spam votes for each candidates
			$candidate->totalSpam = $this->voteService->countTotalSpamVotesByCandidate($candidate->cdid);
			//(step 5): count all votes for each candidates regardles of this status
			$candidate->totalVotes = $this->voteService->countTotalVotesByCandidate($candidate->cdid);
			//(step 6): calculate total amount for each candidates
			$candidate->totalAmount = $this->voteService->calculateAmountVerifiedByCandidate($candidate->cdid);
			//(step 7): calculate total vote points for each candidates
			$candidate->totalPoints = $this->voteService->calculatePointsVerifiedByCandidate($candidate->cdid);
		}

		//(step 8): sort candidates by total vote points in descending order (highest to lowest points)
		$candidates = $candidates->sortByDesc('totalPoints');

		//(step 8): take only the specified number of top candidates
		$topCandidates = $candidates->take($limit);

		//(step 10): return the data
		return $topCandidates;
	}

	public function getCandidatesWithMostVotesByCategory(string $appVersionName, int $limit) {
		$appVersion = AppVersion::where('name', $appVersionName)->firstOrFail();
		return Cache::remember('mostVotesCandidatesByCategory:' . $appVersion->avid, 60 * 60 * 24, function () use ($appVersion, $limit) {
			$topCandidatesByCategory = [];

			//(Step 1): get all categories for specific app version
			$categories = Category::where('app_version_id', $appVersion->avid)->get();

			//(Step 2): get all candidates with (votes) for each category
			foreach ($categories as $category) {
				$candidates = Candidate::where('category_id', $category->ctid)
					->with(['votes' => function ($query) use ($appVersion) {
						$query->where('app_version_id', $appVersion->avid)
							->where('status', 0)
							->with('votePoint');
					}])
					->get();

				//calculate the sum of all votes points for each candidates
				foreach ($candidates as $candidate) {
					//(step 3): count total verified votes for each candidates
					$candidate->totalVerified = $this->voteService->countTotalVerifiedVotesByCandidate($candidate->cdid);
					//(step 4): count total pending votes for each candidates
					$candidate->totalPending = $this->voteService->countTotalPendingVotesByCandidate($candidate->cdid);
					//(step 5): count total spam votes for each candidates
					$candidate->totalSpam = $this->voteService->countTotalSpamVotesByCandidate($candidate->cdid);
					//(step 6): count all votes for each candidates regardles of this status
					$candidate->totalVotes = $this->voteService->countTotalVotesByCandidate($candidate->cdid);
					//(step 7): calculate total amount for each candidates
					$candidate->totalAmount = $this->voteService->calculateAmountVerifiedByCandidate($candidate->cdid);
					//(step 8): calculate total vote points for each candidates
					$candidate->totalPoints = $this->voteService->calculatePointsVerifiedByCandidate($candidate->cdid);
				}

				//(step 9): sort candidates by total vote points in descending order (highest to lowest points)
				$candidates = $candidates->sortByDesc('totalPoints');

				//(step 10): take only the specified number of top candidates
				$topCandidatesByCategory[$category->name] = $candidates->take($limit);
			}

			//(step 10): return the data
			return $topCandidatesByCategory;
		});
	}

	private function hasChangesOccurred(array $data): bool {
		$candidate = Candidate::findOrFail($data['cdid']);
		$candidate->fill([
			'app_version_id' => data_get($data, 'app_version_id', $candidate->app_version_id),
			'school_campus_id' => data_get($data, 'school_campus_id', $candidate->school_campus_id),
			'category_id' => data_get($data, 'category_id', $candidate->category_id),
			'candidate_no' => data_get($data, 'candidate_no', $candidate->candidate_no),
			'name' => data_get($data, 'name', $candidate->name),
			'motto_description' => data_get($data, 'motto_description', $candidate->motto_description),
			'image' => data_get($data, 'image', $candidate->image),
		]);

		return $candidate->isDirty();
	}

	private function candidateExist(string $name, int $appVersionId, int $candidateId): bool {
		return Candidate::where('name', $name)
			->where('app_version_id', '<>', $appVersionId)
			->where('cdid', '<>', $candidateId)
			->exists();
	}
}
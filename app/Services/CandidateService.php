<?php

namespace App\Services;

use App\Exceptions\App\Admin\CreateDataException;
use App\Exceptions\App\Admin\DeleteDataException;
use App\Exceptions\App\Admin\UpdateDataException;
use App\Http\Resources\Api\CandidateResource;
use App\Models\AppVersion;
use App\Models\Candidate;
use App\Models\Category;
use App\Models\Vote;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CandidateService {

	public function getAllCandidates(String $appVersionName) {
		$appVersion = AppVersion::where('name', $appVersionName)->firstOrFail();
		return Cache::remember('candidates:' . $appVersion->avid, 60 * 60 * 24, function () use ($appVersion) {
			$candidates = Candidate::orderBy('created_at', 'desc')
				->where('app_version_id', $appVersion->avid)->get();
			return CandidateResource::collection($candidates);
		});
	}

	public function getOneCandidate(int $candidateId) {
		return Cache::remember('candidatesId:' . $candidateId, 60 * 60 * 24,
			function () use ($candidateId) {
				// get information for a single candidate
				$candidate = Candidate::with(['appVersion', 'campus', 'category'])
					->where('cdid', $candidateId)
					->firstOrFail();

				// get all votes records for this candidates (verified|pending|spam)
				$votes = Vote::with(['candidate', 'votePoint'])
					->where('candidate_id', $candidate->cdid)->get();

				// calculate the total votes of this candidate (only verified lang will count)
				$totalVotes = Vote::where('candidate_id', $candidate->cdid)
					->where('status', 0)
					->count();

				// calculate the total amount of this candidate (only verified lang will count)
				$totalAmount = Vote::where('candidate_id', $candidate->cdid)
					->where('status', 0)
					->join('vote_points', 'votes.vote_points_id', '=', 'vote_points.vpid')
					->sum('vote_points.amount');

				// calculate the total vote points of this candidates (only if is verfied lang)
				$totalVotePoints = Vote::where('candidate_id', $candidate->cdid)
					->where('status', 0)
					->join('vote_points', 'votes.vote_points_id', '=', 'vote_points.vpid')
					->sum('vote_points.point');

				// calculate the total pending vote of this candidates
				$totalPendingVotes = Vote::where('candidate_id', $candidate->cdid)
					->where('status', 1)
					->count();

				// calculate the total spam vote of this candidates
				$totalSpamVotes = Vote::where('candidate_id', $candidate->cdid)
					->where('status', 2)
					->count();

				// calculate the all total vote of this candidates (verified|pending|spam)
				$totalOfAllVotes = Vote::where('candidate_id', $candidate->cdid)
					->count();

				// object para i hold lahat ng information about candidates
				$result = new \stdClass();
				$result->candidate = $candidate;
				$result->votes = $votes;
				$result->totalVotes = $totalVotes;
				$result->totalAmount = $totalAmount;
				$result->totalVotePoints = $totalVotePoints;
				$result->totalPendingVotes = $totalPendingVotes;
				$result->totalSpamVotes = $totalSpamVotes;
				$result->totalOfAllVotes = $totalOfAllVotes;

				return $result;
			});
	}

	public function getFilterSearchCandidates(String $appVersionName, String $searchQuery) {
		$appVersion = AppVersion::where('name', $appVersionName)->firstOrFail();
		return Cache::remember('candidateSearch:' . $appVersion->avid, 60 * 60 * 24,
			function () use ($appVersion, $searchQuery) {
				if (!$appVersion) {
					// Return an empty collection if app version is not found
					return collect();
				}

				$candidate = Candidate::where('app_version_id', $appVersion->avid)
					->where(function ($query) use ($searchQuery) {
						$query->where('name', 'like', '%' . $searchQuery . '%')
							->orWhere('candidate_no', 'like', '%' . $searchQuery . '%');
					})
					->get();

				return CandidateResource::collection($candidate);
			});
	}

	public function getCandidatesByCategory(String $appVersionName, int $categoryId) {
		$appVersion = AppVersion::where('name', $appVersionName)->firstOrFail();
		$category = Category::findOrFail($categoryId);

		return Cache::remember('candidateCategory:' . $categoryId, 60 * 60 * 24,
			function () use ($appVersion, $category) {
				$candidate = Candidate::where('app_version_id', $appVersion->avid)
					->where('category_id', $category->ctid)
					->orderBy('created_at', 'desc')
					->get();

				return CandidateResource::collection($candidate);
			});
	}

	public function loadMoreCandidates(String $appVersionName, int $limit, int $offset) {
		$appVersion = AppVersion::where('name', $appVersionName)->firstOrFail();
		// return Cache::remember('candidatesMore:' . $appVersion->avid, 60 * 60 * 24,
		// 	function () use ($appVersion, $limit, $offset) {});
		$candidates = Candidate::where('app_version_id', $appVersion->avid)
			->orderBy('created_at', 'desc')
			->skip($offset)
			->take($limit)
			->get();

		return CandidateResource::collection($candidates);
	}

	public function createCandidate(array $data) {
		return DB::transaction(function () use ($data) {
			$file = $data['image'] ?? null;
			if ($file instanceof \Illuminate\Http\UploadedFile  && $file->isValid()) {
				//store the uploaded file in the 'storage/candidates/filename' folder
				$path = Storage::disk('public')->put('candidates', $file);
				// Assign the stored path to the 'image' key in the data array
				$data['image'] = $path;
			}
			$created = Candidate::query()->create([
				'app_version_id' => data_get($data, 'app_version_id', null),
				'school_campus_id' => data_get($data, 'school_campus_id', null),
				'category_id' => data_get($data, 'category_id', null),
				'candidate_no' => data_get($data, 'candidate_no', null),
				'name' => data_get($data, 'name', null),
				'motto_description' => data_get($data, 'motto_description', null),
				'image' => $data['image'],
				'created_at' => data_get($data, 'created_at', now()),
				'updated_at' => data_get($data, 'updated_at', null),
			]);

			if (!$created) {
				throw new CreateDataException("Failed to create new candidate.");
			}

			return response()->json(['success' => true, 'message' => 'New candidate created successfully']);
		});
	}

	public function updateCandidate(array $data) {
		if (!$this->hasChangesOccurred($data)) {
			return response()->json(['success' => false, 'message' => 'No changes occured', 'type' => 'info']);
		}

		if ($this->isDuplicateCandidate($data)) {
			return response()->json(['success' => false, 'message' => 'Cannot duplicate candidate.', 'type' => 'warning']);
		}

		$candidate = Candidate::findOrFail($data['cdid']);
		return DB::transaction(function () use ($candidate, $data) {
			$file = $data['image'] ?? null;
			$scid = $data['school_campus_id'] ?? $candidate->school_campus_id;
			$avid = $data['app_version_id'] ?? $candidate->app_version_id;
			$ctid = $data['category_id'] ?? $candidate->category_id;

			if ($file instanceof \Illuminate\Http\UploadedFile  && $file->isValid()) {
				$path = Storage::disk('public')->put('candidates', $file);
				$data['image'] = $path;
			}
			// If no new image is provided or the image data is 'undefined' or null
			elseif (!isset($data['image']) || $data['image'] === 'undefined' || $data['image'] === null) {
				$data['image'] = $candidate->image;
			}

			$updated = $candidate->update([
				'app_version_id' => $avid,
				'school_campus_id' => $scid,
				'category_id' => $ctid,
				'candidate_no' => data_get($data, 'candidate_no', $candidate->candidate_no),
				'name' => data_get($data, 'name', $candidate->name),
				'motto_description' => data_get($data, 'motto_description', $candidate->motto_description),
				'image' => data_get($data, 'image', $candidate->image),
				'updated_at' => data_get($data, 'updated_at', now()),
			]);

			if (!$updated) {
				throw new UpdateDataException('Failed to update candidate');
			}

			return response()->json(['success' => true, 'message' => 'Candidate updated successfully.']);
		});
	}

	public function deleteCandidate(int $candidateId) {
		$candidate = Candidate::findOrFail($candidateId);
		return DB::transaction(function () use ($candidate) {
			$deleted = $candidate->delete();
			if (!$deleted) {
				throw new DeleteDataException('Failed to delete candidate');
			}

			return response()->json(['success' => true, 'message' => 'Candidate deleted successfully']);
		});
	}

	private function isDuplicateCandidate(array $data): bool {
		return $this->nameExists($data['name'], (int) $data['app_version_id'], (int) $data['cdid']);
	}

	private function hasChangesOccurred(array $data): bool {
		$candidate = Candidate::findOrFail($data['cdid']);
		$candidate->fill($data);

		return $candidate->isDirty();
	}

	private function nameExists(string $name, int $avid, int $cdid): bool {
		return Candidate::where('name', $name)
			->where('app_version_id', $avid)
			->where('cdid', '<>', $cdid)
			->exists();
	}
}
<?php

namespace App\Repositories;

use App\Exceptions\App\Admin\CreateDataException;
use App\Exceptions\App\Admin\DeleteDataException;
use App\Exceptions\App\Admin\UpdateDataException;
use App\Interfaces\IRepository;
use App\Models\AppVersion;
use App\Models\Candidate;
use App\Models\Vote;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CandidateRepository implements IRepository {

	public function getAll(String $appVersionName = ""): object {
		$appVersion = AppVersion::where('name', $appVersionName)->first();
		$candidates = Candidate::where('app_version_id', $appVersion->avid)
			->orderBy('created_at', 'desc')
			->get();

		return $candidates;
	}

	public function loadMoreData(String $appVersionName, int $limit, int $offset): object {
		$appVersion = AppVersion::where('name', $appVersionName)->first();
		$candidates = Candidate::where('app_version_id', $appVersion->avid)
			->orderBy('created_at', 'desc')
			->skip($offset)
			->take($limit)
			->get();

		return $candidates;
	}

	public function filterSearch(String $appVersionName, String $searchQuery): object {
		$appVersion = AppVersion::where('name', $appVersionName)->first();

		if ($appVersion) {
			$query = Candidate::where('app_version_id', $appVersion->avid)
				->where(function ($query) use ($searchQuery) {
					$query->where('name', 'like', '%' . $searchQuery . '%')
						->orWhere('candidate_no', 'like', '%' . $searchQuery . '%');
				});

			// Return candidates
			return $query->get();
		} else {
			// Return an empty collection if app version is not found
			return collect();
		}
	}

	public function getByCategory(String $appVersionName, int $categoryId): object {
		$appVersion = AppVersion::where('name', $appVersionName)->first();
		if ($appVersion) {
			return Candidate::where('app_version_id', $appVersion->avid)
				->where('category_id', $categoryId)
				->orderBy('created_at', 'desc')->get();
		} else {
			return Candidate::all();
		}
	}

	public function getOne(int $candidateId): object {
		// \Log::info("id: " . $candidateId);
		// get information for a single candidate
		$candidate = Candidate::with(['appVersion', 'campus', 'category'])
			->where('cdid', $candidateId)
			->first();

		// get all votes records for this candidates (verified|pending|spam)
		$votes = Vote::with(['candidate', 'votePoint'])->where('candidate_id', $candidateId)->get();

		// calculate the total votes of this candidate (only verified lang will count)
		$totalVotes = Vote::where('candidate_id', $candidateId)
			->where('status', 0)
			->count();

		// calculate the total amount of this candidate (only verified lang will count)
		$totalAmount = Vote::where('candidate_id', $candidateId)
			->where('status', 0)
			->join('vote_points', 'votes.vote_points_id', '=', 'vote_points.vpid')
			->sum('vote_points.amount');

		// calculate the total vote points of this candidates (only if is verfied lang)
		$totalVotePoints = Vote::where('candidate_id', $candidateId)
			->where('status', 0)
			->join('vote_points', 'votes.vote_points_id', '=', 'vote_points.vpid')
			->sum('vote_points.point');

		// calculate the total pending vote of this candidates
		$totalPendingVotes = Vote::where('candidate_id', $candidateId)
			->where('status', 1)
			->count();

		// calculate the total spam vote of this candidates
		$totalSpamVotes = Vote::where('candidate_id', $candidateId)
			->where('status', 2)
			->count();

		// calculate the all total vote of this candidates (verified|pending|spam)
		$totalOfAllVotes = Vote::where('candidate_id', $candidateId)
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
		// \Log::info("Candidate: " . json_encode($result->candidate));
		// \Log::info("Votes: " . json_encode($result->votes));
		// \Log::info("Total Votes: " . $result->totalVotes);
		// \Log::info("Total Amount: " . $result->totalAmount);
		// \Log::info("Total Vote Points: " . $result->totalVotePoints);
		// \Log::info("Total Pending Votes: " . $result->totalPendingVotes);
		// \Log::info("Total Spam Votes: " . $result->totalSpamVotes);
		// \Log::info("Total Of All Votes: " . $result->totalOfAllVotes);
		return $result;
	}

	public function create(array $attributes): array {
		return DB::transaction(function () use ($attributes) {
			$file = $attributes['image'] ?? null;
			if ($file instanceof \Illuminate\Http\UploadedFile  && $file->isValid()) {
				//store the uploaded file in the 'storage/candidates/filename' folder
				$path = Storage::disk('public')->put('candidates', $file);
				// Assign the stored path to the 'image' key in the data array
				$attributes['image'] = $path;
			}
			$created = Candidate::query()->create([
				'app_version_id' => data_get($attributes, 'app_version_id', null),
				'school_campus_id' => data_get($attributes, 'school_campus_id', null),
				'category_id' => data_get($attributes, 'category_id', null),
				'candidate_no' => data_get($attributes, 'candidate_no', null),
				'name' => data_get($attributes, 'name', null),
				'motto_description' => data_get($attributes, 'motto_description', null),
				'image' => $attributes['image'],
				'updated_at' => data_get($attributes, 'updated_at', null),
			]);

			if (!$created) {
				throw new CreateDataException("Failed to create new candidate.");
			}

			return ['success' => true, 'message' => 'New candidate created successfully'];
		});
	}

	public function update(array $attributes): array {
		$candidate = $this->findCandidate($attributes['cdid']);

		return DB::transaction(function () use ($candidate, $attributes) {
			$file = $attributes['image'] ?? null;
			$scid = $attributes['school_campus_id'] ?? $candidate->school_campus_id;
			$avid = $attributes['app_version_id'] ?? $candidate->app_version_id;
			$ctid = $attributes['category_id'] ?? $candidate->category_id;

			if ($file instanceof \Illuminate\Http\UploadedFile  && $file->isValid()) {
				$path = Storage::disk('public')->put('candidates', $file);
				$attributes['image'] = $path;
			}
			// If no new image is provided or the image data is 'undefined' or null
			elseif (!isset($attributes['image']) || $attributes['image'] === 'undefined' || $attributes['image'] === null) {
				$attributes['image'] = $candidate->image;
			}

			$updated = $candidate->update([
				'app_version_id' => $avid,
				'school_campus_id' => $scid,
				'category_id' => $ctid,
				'candidate_no' => data_get($attributes, 'candidate_no', $candidate->candidate_no),
				'name' => data_get($attributes, 'name', $candidate->name),
				'motto_description' => data_get($attributes, 'motto_description', $candidate->motto_description),
				'image' => data_get($attributes, 'image', $candidate->image),
			]);

			if (!$updated) {
				throw new UpdateDataException('Something went wrong! Failed to candidate');
			}

			return ['success' => true, 'message' => 'Candidate updated successfully.'];
		});
	}

	public function delete(int $cdid): array {
		$candidate = $this->findCandidate($cdid);
		return DB::transaction(function () use ($candidate) {
			$deleted = $candidate->delete();
			if (!$deleted) {
				throw new DeleteDataException('Something went wrong! Failed to delete candidate');
			}

			return ['success' => true, 'message' => 'Candidate deleted successfully'];
		});
	}

	public function nameExists(string $name, int $avid, int $cdid): bool {
		return Candidate::where('name', $name)
			->where('app_version_id', $avid)
			->where('cdid', '<>', $cdid)
			->exists();
	}

	public function findCandidate(int $cdid): Candidate {
		return Candidate::findOrFail($cdid);
	}
}
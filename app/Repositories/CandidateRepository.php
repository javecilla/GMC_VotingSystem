<?php

namespace App\Repositories;

use App\Exceptions\App\Admin\CreateDataException;
use App\Interfaces\IRepository;
use App\Models\AppVersion;
use App\Models\Candidate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CandidateRepository implements IRepository {

	public function getAll(String $appVersionName = ""): object {
		$appVersion = AppVersion::where('name', $appVersionName)->first();
		if ($appVersion) {
			return Candidate::where('app_version_id', $appVersion->avid)->get();
		} else {
			return Candidate::all();
		}
	}

	public function getOne(int $candidateId): object {
		return Candidate::where('cdid', $candidateId)->get();
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

	public function update(array $attributes): array {}
	public function delete(int $id): array {}
}
<?php

namespace App\Services;

use App\Exceptions\App\Admin\CreateDataException;
use App\Repositories\CandidateRepository;
use Illuminate\Support\Arr;

class CandidateService {
	public function __construct(protected CandidateRepository $repository) {}

	public function createCandidate(array $data): array {
		try {
			$filteredData = Arr::only($data, [
				'app_version_id', 'school_campus_id', 'category_id',
				'candidate_no', 'name', 'motto_description', 'image',
			]);
			return $this->repository->create($filteredData);
		} catch (CreateDataException $e) {
			return ['success' => false, 'message' => $e->getMessage()];
		} catch (\Exception $e) {
			return ['success' => false, 'message' => 'An error occurred during creation.'];
		}
	}

	public function getAllCandidates(String $appVersionName): object {
		return $this->repository->getAll($appVersionName);
	}

	public function getOneCandidate(int $candidateId): object {
		return $this->repository->getOne($candidateId);
	}
}
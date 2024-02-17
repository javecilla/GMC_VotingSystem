<?php

namespace App\Services;

use App\Repositories\CampusRepository;

/**
 *
 */
class CampusService {
	public function __construct(protected CampusRepository $repository) {}

	public function getAllCategory(String $appVersion): object {
		return $this->repository->getAll($appVersion);
	}
}
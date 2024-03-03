<?php

namespace App\Services;

use App\Repositories\ViewRepository;

class ViewService {
	public function __construct(protected ViewRepository $repository) {}

	//count the views page unique base on its coockie stored in database
	public function getPageViews(String $appVersion): array {
		return $this->repository->pageViews($appVersion);
	}

	//count the views page per day
	public function getPageViewsPerDay(String $appVersion, int $limit): array {
		return $this->repository->pageViewsPerDay($appVersion, $limit);
	}
}
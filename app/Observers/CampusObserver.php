<?php

namespace App\Observers;

use App\Models\Campus;
use Illuminate\Support\Facades\Cache;

class CampusObserver {
	/**
	 * Handle the Campus "created" event.
	 */
	public function created(Campus $campus): void {
		$this->forgetCampusCache($campus);
	}

	/**
	 * Handle the Campus "updated" event.
	 */
	public function updated(Campus $campus): void {
		$this->forgetCampusCache($campus);
	}

	/**
	 * Handle the Campus "deleted" event.
	 */
	public function deleted(Campus $campus): void {
		$this->forgetCampusCache($campus);
	}

	protected function forgetCampusCache(Campus $campus): void {
		Cache::forget('campuses:' . $campus->app_version_id);
	}
}

<?php

namespace App\Observers;

use App\Models\Campus;
use Illuminate\Support\Facades\Cache;

class CampusObserver {
	/**
	 * Handle the Campus "created" event.
	 */
	public function created(Campus $campus): void {
		Cache::forget('campuses');
	}

	/**
	 * Handle the Campus "updated" event.
	 */
	public function updated(Campus $campus): void {
		Cache::forget('campuses');
	}

	/**
	 * Handle the Campus "deleted" event.
	 */
	public function deleted(Campus $campus): void {
		Cache::forget('campuses');
	}
}

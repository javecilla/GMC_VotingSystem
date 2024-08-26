<?php

namespace App\Observers;

use App\Models\Candidate;
use Illuminate\Support\Facades\Cache;

class CandidateObserver {
	/**
	 * Handle the Candidate "created" event.
	 */
	public function created(Candidate $candidate): void {
		$this->forgetCandidateCache($candidate);
	}

	/**
	 * Handle the Candidate "updated" event.
	 */
	public function updated(Candidate $candidate): void {
		$this->forgetCandidateCache($candidate);
	}

	/**
	 * Handle the Candidate "deleted" event.
	 */
	public function deleted(Candidate $candidate): void {
		$this->forgetCandidateCache($candidate);
	}

	protected function forgetCandidateCache(Candidate $candidate): void {
		Cache::forget('candidates:' . $candidate->app_version_id);
		Cache::forget('candidatesMore:' . $candidate->app_version_id);
		Cache::forget('candidateSearch: ' . $candidate->app_version_id);
		Cache::forget('candidatesId:' . $candidate->cdid);
		Cache::forget('candidateCategory:' . $candidate->category_id);
	}
}

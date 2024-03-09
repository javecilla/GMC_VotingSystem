<?php

namespace App\Observers;

use App\Models\VotePoint;
use Illuminate\Support\Facades\Cache;

class VotePointObserver {
	/**
	 * Handle the VotePoint "created" event.
	 */
	public function created(VotePoint $votePoint): void {
		Cache::forget('votePoints');
	}

	/**
	 * Handle the VotePoint "updated" event.
	 */
	public function updated(VotePoint $votePoint): void {
		Cache::forget('votePoints');
	}

	/**
	 * Handle the VotePoint "deleted" event.
	 */
	public function deleted(VotePoint $votePoint): void {
		Cache::forget('votePoints');
	}
}

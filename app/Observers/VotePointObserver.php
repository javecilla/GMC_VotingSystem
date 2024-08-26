<?php

namespace App\Observers;

use App\Models\VotePoint;
use Illuminate\Support\Facades\Cache;

class VotePointObserver {
	/**
	 * Handle the VotePoint "created" event.
	 */
	public function created(VotePoint $votePoint): void {
		$this->forgetVotePointCache($votePoint);
	}

	/**
	 * Handle the VotePoint "updated" event.
	 */
	public function updated(VotePoint $votePoint): void {
		$this->forgetVotePointCache($votePoint);
	}

	/**
	 * Handle the VotePoint "deleted" event.
	 */
	public function deleted(VotePoint $votePoint): void {
		$this->forgetVotePointCache($votePoint);
	}

	protected function forgetVotePointCache(VotePoint $votePoint): void {
		Cache::forget('votePoints:' . $votePoint->app_version_id);
		Cache::forget('votePointsId:' . $votePoint->vpid);
	}
}

<?php

namespace App\Observers;

use App\Models\Vote;
use Illuminate\Support\Facades\Cache;

class VoteObserver {
	/**
	 * Handle the Vote "created" event.
	 */
	public function created(Vote $vote): void {
		$this->forgetVoteCache($vote);
	}

	/**
	 * Handle the Vote "updated" event.
	 */
	public function updated(Vote $vote): void {
		$this->forgetVoteCache($vote);
	}

	/**
	 * Handle the Vote "deleted" event.
	 */
	public function deleted(Vote $vote): void {
		$this->forgetVoteCache($vote);
	}

	protected function forgetVoteCache(Vote $vote): void {
		Cache::forget('votes:' . $vote->app_version_id);
		//Cache::forget('votesMore:' . $vote->app_version_id);
		Cache::forget('votesId:' . $vote->vid);
		\Log::info('Observer FORGET: votesByStatus:' . $vote->status);
		Cache::forget('votesByStatus:' . $vote->status);
		Cache::forget('votesBySearch:' . $vote->app_version_id);
		Cache::forget('votesPendingVerifiedSpamAmount:' . $vote->app_version_id);
		Cache::forget('mostVotesCandidates:' . $vote->app_version_id);
		Cache::forget('mostVotesCandidatesByCategory:' . $vote->app_version_id);
	}
}

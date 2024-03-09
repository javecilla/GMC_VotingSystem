<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CandidateResource extends JsonResource {
	public function toArray(Request $request): array {
		return [
			'cdid' => $this->cdid,
			'app_version_id' => $this->app_version_id,
			'school_campus_id' => $this->school_campus_id,
			'category_id' => $this->category_id,
			'candidate_no' => $this->candidate_no,
			'name' => $this->name,
			'motto_description' => $this->motto_description,
			'image' => $this->image,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
			//
			'candidate' => $this->candidate,
			'votes' => $this->votes,
			'total_votes' => $this->totalVotes,
			'total_amount' => $this->totalAmount,
			'total_vote_points' => $this->totalVotePoints,
			'total_pending_votes' => $this->totalPendingVotes,
			'total_spam_votes' => $this->totalSpamVotes,
			'total_of_all_votes' => $this->totalOfAllVotes,
		];
	}
}

<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Vinkla\Hashids\Facades\Hashids;

class CandidateResource extends JsonResource {

	public function toArray(Request $request) {
		return [
			'cdid' => Hashids::encode($this->cdid),
			'app_version_id' => $this->app_version_id,
			'school_campus_id' => $this->school_campus_id ?? 'No school/campus set on this candidate.',
			'category_id' => $this->category_id,
			'candidate_no' => $this->candidate_no,
			'name' => $this->name,
			'motto_description' => $this->motto_description ?? 'No motto/description is set on this candidate.',
			'image' => '/storage/' . $this->image,
			'created_at' => $this->created_at->format('F d, Y - h:i A'), //March 10, 2024 - 04:40 PM
			'updated_at' => $this->updated_at != null ? $this->updated_at->format('F d, Y - h:i A') : 'No changes occured.',
			//data relation sources
			'appVersion' => $this->appVersion,
			'campus' => $this->campus,
			'category' => $this->category,
			'votes' => $this->votes,
			// additional data passed from service
			'totalVerified' => $this->totalVerified ?? 0,
			'totalPending' => $this->totalPending ?? 0,
			'totalSpam' => $this->totalSpam ?? 0,
			'totalVotes' => $this->totalVotes ?? 0,
			'totalAmount' => '₱' . number_format($this->totalAmount) ?? '₱' . 0,
			'totalPoints' => $this->totalPoints ?? 0,
		];
	}
}

<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Vinkla\Hashids\Facades\Hashids;

class VoteResource extends JsonResource {
	public function toArray(Request $request): array {
		return [
			'vid' => Hashids::encode($this->vid),
			'app_version_id' => $this->app_version_id,
			'candidate_id' => $this->candidate_id,
			'vote_points_id' => $this->vote_points_id,
			//"09772465533", make this like (+63) 9772465533
			//'contact_no' => '(+63) ' . Str::substr($this->contact_no, 1),
			'contact_no' => $this->contact_no,
			'email' => $this->email,
			//"9812590180000", bold this last part '0000'
			//'referrence_no' => Str::substr($this->referrence_no, 0, -4) . '<b>' . Str::substr($this->referrence_no, -4) . '</b>',
			'referrence_no' => $this->referrence_no,
			'status' => $this->status,
			'status_name' => ($this->status == 0 ? 'verified' : ($this->status == 1 ? 'pending' : ($this->status == 2 ? 'spam' : 'unknown'))),
			'created_at' => $this->created_at != null ? $this->created_at->format('F d, Y - h:i A') : 'error',
			'updated_at' => $this->updated_at != null ? $this->updated_at->format('F d, Y - h:i A') : 'No changes occured.',
			//database relation source
			'appVersion' => $this->appVersion,
			'candidate' => $this->candidate,
			'votePoint' => $this->votePoint,
			//source form additional data in services
			'total_points' => $this->total_points ?? 0,
		];
	}
}

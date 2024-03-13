<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Vinkla\Hashids\Facades\Hashids;

class VotePointResource extends JsonResource {
	public function toArray(Request $request): array {
		return [
			'vpid' => Hashids::encode($this->vpid),
			'app_version_id' => $this->app_version_id,
			//format the number into decimal [200 => 200.00]
			'amount' => number_format((float) $this->amount, 2, '.', ''),
			'point' => $this->point,
			'image' => '/storage/' . $this->image,
			'created_at' => $this->created_at->format('F d, Y - h:i A'),
			'updated_at' => $this->updated_at != null ? $this->updated_at->format('F d, Y - h:i A') : 'No changes occured.',
		];
	}
}

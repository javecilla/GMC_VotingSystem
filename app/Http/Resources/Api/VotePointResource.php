<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VotePointResource extends JsonResource {
	public function toArray(Request $request): array {
		return [
			'vpid' => $this->vpid,
			'app_version_id' => $this->app_version_id,
			'amount' => $this->amount,
			'point' => $this->point,
			'image' => $this->image,
		];
	}
}

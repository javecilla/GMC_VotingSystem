<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CampusResource extends JsonResource {
	public function toArray(Request $request): array {
		return [
			'scid' => $this->scid,
			'app_version_id' => $this->app_version_id,
			'name' => $this->name,
			'created_at' => $this->created_at->format('F d, Y'),
		];
	}
}

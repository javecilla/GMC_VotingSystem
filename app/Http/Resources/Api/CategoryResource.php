<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Vinkla\Hashids\Facades\Hashids;

class CategoryResource extends JsonResource {
	public function toArray(Request $request): array {
		return [
			'ctid' => Hashids::encode($this->ctid),
			'app_version_id' => $this->app_version_id,
			'name' => $this->name,
			'created_at' => $this->created_at->format('F d, Y - h:i A'),
			'updated_at' => $this->updated_at != null ? $this->updated_at->format('F d, Y - h:i A') : 'No changes occured.',
		];
	}
}

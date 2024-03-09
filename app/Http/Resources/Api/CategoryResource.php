<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource {
	public function toArray(Request $request): array {
		return [
			'ctid' => $this->ctid,
			'app_version_id' => $this->app_version_id,
			'name' => $this->name,
		];
	}
}

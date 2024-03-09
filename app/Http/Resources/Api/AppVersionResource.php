<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppVersionResource extends JsonResource {
	public function toArray(Request $request): array {
		return [
			'avid' => $this->avid,
			'name' => $this->name,
			'title' => $this->title,
		];
	}
}

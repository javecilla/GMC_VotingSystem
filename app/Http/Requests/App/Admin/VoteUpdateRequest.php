<?php

namespace App\Http\Requests\App\Admin;

use Illuminate\Foundation\Http\FormRequest;

class VoteUpdateRequest extends FormRequest {

	public function authorize(): bool {
		return true;
	}

	public function rules(): array {
		return [
			'app_version_name' => '',
			'candidate_id' => '',
			'vote_points_id' => '',
			'contact_no' => '',
			'email' => '',
			'referrence_no' => '',
			'vid' => '',
		];
	}
}
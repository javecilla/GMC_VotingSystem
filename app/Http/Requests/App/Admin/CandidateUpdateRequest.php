<?php

namespace App\Http\Requests\App\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CandidateUpdateRequest extends FormRequest {

	public function authorize(): bool {
		return true;
	}

	public function rules(): array {
		return [
			'cdid' => 'required',
			'app_version_id' => '',
			'school_campus_id' => '',
			'category_id' => '',
			'candidate_no' => '',
			'name' => '',
			'motto_description' => '',
			'image' => '',
		];
	}
}

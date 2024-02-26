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
		];
	}
}

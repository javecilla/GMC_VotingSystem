<?php

namespace App\Http\Requests\App\Admin;

use Illuminate\Foundation\Http\FormRequest;

class VersionUpdateRequest extends FormRequest {

	public function authorize(): bool {
		return true;
	}

	public function rules(): array {
		return [
			'app_version_id' => 'required',
			'avid' => 'required',
			'name' => 'required',
			'title' => 'required',
		];
	}
}

<?php

namespace App\Http\Requests\App\Admin;

use Illuminate\Foundation\Http\FormRequest;

class VersionCreateRequest extends FormRequest {

	public function authorize(): bool {
		return true;
	}

	public function rules(): array {
		return [
			'name' => 'required|unique:app_versions',
			'title' => 'required|unique:app_versions',
		];
	}

	public function messages() {
		return [
			'name.unique' => 'Failed to create new version! Cannot duplicate version name',
			'title.unique' => 'Failed to create new version! Cannot duplicate version title',
		];
	}
}

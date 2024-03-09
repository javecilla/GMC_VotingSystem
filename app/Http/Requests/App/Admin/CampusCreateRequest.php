<?php

namespace App\Http\Requests\App\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CampusCreateRequest extends FormRequest {

	public function authorize(): bool {
		return true;
	}

	public function rules(): array {
		return [
			'app_version_id' => 'required',
			'name' => [
				'required',
				//Rule::unique('campuses')->where(function ($query) {
				//return $query->where('app_version_id', $this->app_version_id)
				//->where('name', $this->name);
				//}),
			],
		];
	}

	public function messages(): array {
		return [
			'name.unique' => 'Cannot create new Campus because this is already exist',
		];
	}
}

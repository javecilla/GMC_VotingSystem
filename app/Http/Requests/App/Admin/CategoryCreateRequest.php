<?php

namespace App\Http\Requests\App\Admin;

use App\Helpers\Decoder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryCreateRequest extends FormRequest {

	public function authorize(): bool {
		return true;
	}

	public function rules(): array {
		return [
			'app_version_id' => 'required',
			'name' => [
				'required',
				// this check if the category name is already exist in database 'categories'
				// for particular app version id then it will not be accepted
				Rule::unique('categories')->where(function ($query) {
					$avid = Decoder::decodeIds($this->app_version_id);
					return $query->where('app_version_id', $avid)->where('name', $this->name);
				}),
			],
		];
	}

	public function messages(): array {
		return [
			'name.unique' => 'Cannot create new category because this is already exist',
		];
	}
}

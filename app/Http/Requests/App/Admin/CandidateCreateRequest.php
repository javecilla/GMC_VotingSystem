<?php

namespace App\Http\Requests\App\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CandidateCreateRequest extends FormRequest {

	public function authorize(): bool {
		return true;
	}

	public function rules(): array {
		return [
			'app_version_id' => 'required',
			'school_campus_id' => '',
			'category_id' => 'required',
			'candidate_no' => [
				'required',
				// this check if the candidate no is already exist in database 'categories'
				// for particular app version id and category id then it will not be accepted
				Rule::unique('candidates')->where(function ($query) {
					return $query->where('app_version_id', $this->app_version_id)
						->where('category_id', $this->category_id)
						->where('candidate_no', $this->candidate_no);
				}),
			],
			'name' => [
				'required',
				// this check if the candidate name is already exist in database 'categories'
				// for particular app version id and category id then it will not be accepted
				Rule::unique('candidates')->where(function ($query) {
					return $query->where('app_version_id', $this->app_version_id)
						->where('category_id', $this->category_id)
						->where('name', $this->name);
				}),
			],
			'motto_description' => '',
			'image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
		];
	}

	public function messages(): array {
		return [
			'name.unique' => 'Cannot create new candidate because this is already exist',
			'candidate_no.unique' => 'Cannot create new candidate because this is already exist',
		];
	}
}

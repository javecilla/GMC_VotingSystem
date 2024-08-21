<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model {
	use HasFactory;

	protected $table = 'categories';
	protected $primaryKey = 'ctid';

	protected $fillable = ['ctid', 'app_version_id', 'name', 'created_at', 'updated_at'];

	protected $dates = ['created_at', 'updated_at'];

	###[Methods for Database table relationship]

	// Make this 'Category' model have relationship to 'AppVersion' model
	public function appVersion() {
		return $this->belongsTo(AppVersion::class, 'app_version_id', 'avid');
	}

	// Make this 'Campus' model have relationship to 'Candidate' model
	public function candidate() {
		return $this->hasMany(Candidate::class, 'category_id', 'ctid');
	}
}

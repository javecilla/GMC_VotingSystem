<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model {
	use HasFactory;

	protected $table = 'candidates';
	protected $primaryKey = 'cdid';

	protected $fillable = [
		'cdid', 'app_version_id', 'school_campus_id', 'category_id',
		'candidate_no', 'name', 'motto_description', 'image', 'created_at', 'updated_at',
	];

	protected $dates = ['created_at', 'updated_at'];

	###[Methods for Database table relationship]

	// Make this 'Candidate' model have relationship to 'AppVersion' model
	public function appVersion() {
		return $this->belongsTo(AppVersion::class, 'app_version_id', 'avid');
	}

	// Make this 'Candidate' model have relationship to 'Campus' model
	public function campus() {
		return $this->belongsTo(Campus::class, 'school_campus_id', 'scid');
	}

	// Make this 'Candidate' model have relationship to 'Category' model
	public function category() {
		return $this->belongsTo(Category::class, 'category_id', 'ctid');
	}

	// Make this 'Candidate' model have relationship to 'Vote' model
	public function votes() {
		return $this->hasMany(Vote::class, 'candidate_id', 'cdid');
	}
}

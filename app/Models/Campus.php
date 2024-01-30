<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campus extends Model {
	use HasFactory;

	protected $table = 'campuses';
	protected $primaryKey = 'scid';

	protected $fillable = ['scid', 'app_version_id', 'name', 'created_at', 'updated_at'];

	###[Methods for Database table relationship]

	// Make this 'AppVersion' model have relationship to 'Campus' model
	public function appVersion() {
		return $this->belongsTo(AppVersion::class, 'app_version_id', 'avid');
	}
}

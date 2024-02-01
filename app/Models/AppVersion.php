<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppVersion extends Model {
	use HasFactory;

	protected $table = 'app_versions';
	protected $primaryKey = 'avid';

	protected $fillable = ['avid', 'name', 'title', 'created_at', 'updated_at'];

	###[Methods for Database table relationship]

	// Make this 'AppVersion' model have relationship to 'Campus' model
	public function campus() {
		return $this->hasMany(Campus::class, 'app_version_id', 'avid');
	}

	// Make this 'AppVersion' model have relationship to 'Category' model
	public function category() {
		return $this->hasMany(Category::class, 'app_version_id', 'avid');
	}
}

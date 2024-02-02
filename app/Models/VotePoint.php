<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VotePoint extends Model {
	use HasFactory;

	protected $table = 'vote_points';
	protected $primaryKey = 'vpid';

	protected $fillable = ['vpid', 'app_version_id', 'amount', 'point', 'created_at', 'updated_at'];

	###[Methods for Database table relationship]

	// Make this 'Category' model have relationship to 'AppVersion' model
	public function appVersion() {
		return $this->belongsTo(AppVersion::class, 'app_version_id', 'avid');
	}
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VotePoint extends Model {
	use HasFactory;

	protected $table = 'vote_points';
	protected $primaryKey = 'vpid';

	protected $fillable = ['vpid', 'app_version_id', 'amount', 'point', 'image', 'created_at', 'updated_at'];

	protected $dates = ['created_at', 'updated_at'];

	###[Methods for Database table relationship]

	// Make this 'Category' model have relationship to 'AppVersion' model
	public function appVersion() {
		return $this->belongsTo(AppVersion::class, 'app_version_id', 'avid');
	}

	// Make this 'VotePoint' model have relationship to 'Vote' model
	public function vote() {
		return $this->hasMany(Vote::class, 'vote_points_id', 'vpid');
	}
}

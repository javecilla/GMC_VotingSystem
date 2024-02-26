<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model {
	use HasFactory;

	protected $table = 'votes';
	protected $primaryKey = 'vid';

	protected $fillable = [
		'vid', 'app_version_id', 'candidate_id', 'vote_points_id',
		'contact_no', 'email', 'referrence_no', 'status', 'created_at', 'updated_at',
	];

	###[Methods for Database table relationship]

	// Make this 'Vote' model have relationship to 'AppVersion' model
	public function appVersion() {
		return $this->belongsTo(AppVersion::class, 'app_version_id', 'avid');
	}

	// Make this 'Vote' model have relationship to 'Candidate' model
	public function candidate() {
		return $this->belongsTo(Candidate::class, 'candidate_id', 'cdid');
	}

	// Make this 'Vote' model have relationship to 'votePoint' model
	public function votePoint() {
		return $this->belongsTo(VotePoint::class, 'vote_points_id', 'vpid');
	}
}

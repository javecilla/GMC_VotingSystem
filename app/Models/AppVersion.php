<?php

namespace App\Models;

use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppVersion extends Model implements Viewable {
	use HasFactory;
	use InteractsWithViews;

	protected $guarded = [];
	protected $table = 'app_versions';
	protected $primaryKey = 'avid';

	protected $fillable = ['avid', 'name', 'title', 'created_at', 'updated_at'];

	protected $dates = ['created_at', 'updated_at'];

	###[Methods for Database table relationship]

	// Make this 'AppVersion' model have relationship to 'Campus' model
	public function campus() {
		return $this->hasMany(Campus::class, 'app_version_id', 'avid');
	}

	// Make this 'AppVersion' model have relationship to 'Category' model
	public function category() {
		return $this->hasMany(Category::class, 'app_version_id', 'avid');
	}

	// Make this 'AppVersion' model have relationship to 'VotePoint' model
	public function votePoint() {
		return $this->hasMany(VotePoint::class, 'app_version_id', 'avid');
	}

	// Make this 'AppVersion' model have relationship to 'Vote' model
	public function vote() {
		return $this->hasMany(Vote::class, 'app_version_id', 'avid');
	}

	// Make this 'AppVersion' model have relationship to 'TicketReport' model
	public function ticketReport() {
		return $this->hasMany(TicketReport::class, 'app_version_id', 'avid');
	}
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketReport extends Model {
	use HasFactory;

	protected $table = 'ticket_reports';
	protected $primaryKey = 'trid';

	protected $fillable = [
		'trid', 'app_version_id', 'name', 'email', 'message', 'image', 'status', 'created_at', 'updated_at',
	];

	protected $dates = ['created_at', 'updated_at'];

	###[Methods for Database table relationship]

	// Make this 'Vote' model have relationship to 'AppVersion' model
	public function appVersion() {
		return $this->belongsTo(AppVersion::class, 'app_version_id', 'avid');
	}
}

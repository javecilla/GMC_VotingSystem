<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model {
	use HasFactory;

	protected $table = 'views';
	protected $primaryKey = 'id';

	protected $fillable = ['id', 'viewable_type', 'viewable_id', 'visitor', 'collection', 'viewed_at'];
}

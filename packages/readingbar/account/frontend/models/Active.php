<?php

namespace Readingbar\Account\Frontend\Models;

use Illuminate\Database\Eloquent\Model;

class Active extends Model
{
	public $table='active';
	protected $fillable = array('active','active_code');
}

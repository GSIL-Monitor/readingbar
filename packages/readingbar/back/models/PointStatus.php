<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class PointStatus extends Model
{
	public $table='s_point_status';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('student_id','point','increase','reduce');
}

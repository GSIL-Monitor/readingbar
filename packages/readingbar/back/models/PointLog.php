<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class PointLog extends Model
{
	public $table='s_point_log';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('student_id','point','point_id','memo','status');
}

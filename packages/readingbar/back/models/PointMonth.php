<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class PointMonth extends Model
{
	public $table='s_point_month';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('student_id','increase','reduce','date');
}

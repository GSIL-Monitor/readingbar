<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class PointOrder extends Model
{
	public $table='s_point_order';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('student_id','total_points','tel','address','status','order_id','reciver');
}

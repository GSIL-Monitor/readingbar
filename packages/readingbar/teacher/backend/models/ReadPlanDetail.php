<?php

namespace Readingbar\Teacher\Backend\Models;

use Illuminate\Database\Eloquent\Model;

class ReadPlanDetail extends Model
{
	public $table='read_plan_detail';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('plan_id','book_id','serial');

}

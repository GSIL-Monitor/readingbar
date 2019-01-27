<?php

namespace Readingbar\Teacher\Backend\Models;

use Illuminate\Database\Eloquent\Model;

class ReadPlan extends Model
{
	public $table='read_plan';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('plan_name','from','to','for','created_by','status');

}

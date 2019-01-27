<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class ReadPlanGoals extends Model
{
	public $table='read_plan_goals';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('plan_id','goals');

}

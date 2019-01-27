<?php

namespace Readingbar\Api\Frontend\Models;

use Illuminate\Database\Eloquent\Model;

class ReadPlanProposal extends Model
{
	public $table='read_plan_proposal';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('plan_id','proposal');

}

<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class ActionTimes extends Model
{
	public $table='action_times';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('action','times');

}

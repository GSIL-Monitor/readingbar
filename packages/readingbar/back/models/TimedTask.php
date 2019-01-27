<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class TimedTask extends Model
{
	public $table='timed_task';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('action','data','E-time','status','unique');

}

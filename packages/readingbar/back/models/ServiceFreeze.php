<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceFreeze extends Model
{
	public $table='service_freeze';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('from','to','student_id','days');

}

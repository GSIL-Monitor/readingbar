<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceStatus extends Model
{
	public $table='service_status';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('student_id','service_id');

}

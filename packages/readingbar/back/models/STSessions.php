<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class STSessions extends Model
{
	public $table='st_sessions';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('student_id','content','type','time');

}

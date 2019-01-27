<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class StudentGroup extends Model
{
	public $table='student_group';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('user_id','group_name');

}

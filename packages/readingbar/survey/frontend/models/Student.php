<?php

namespace Readingbar\Survey\Frontend\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
	public $table='students';
	protected $fillable = array('name','nick_name','avatar','dob','sex','parent_id');
}

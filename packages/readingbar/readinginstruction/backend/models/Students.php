<?php

namespace Readingbar\Readinginstruction\Backend\Models;

use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
	public $table='students';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('parent_id','name','nick_name','avatar','dob','sex','survey_status','group_id');

}

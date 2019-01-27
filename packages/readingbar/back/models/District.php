<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
	public $table='district';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('id','name','rank','preid');
}

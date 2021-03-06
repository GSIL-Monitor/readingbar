<?php

namespace Readingbar\Account\Frontend\Models;

use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
	public $table='members';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('cellphone','email','nickname','QQopenid','password','question','answer','remember_token','actived');

}

<?php

namespace Readingbar\Teacher\Backend\Models;

use Illuminate\Database\Eloquent\Model;

class StarAccount extends Model
{
	public $table='star_account';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('created_by','star_account','star_password','status');
}

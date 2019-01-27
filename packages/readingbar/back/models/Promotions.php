<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class Promotions extends Model
{
	public $table='promotions';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('member_id','pcode','memo');

}

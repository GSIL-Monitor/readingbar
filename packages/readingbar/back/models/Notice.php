<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
	public $table='notice';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('title','notice','status');
}

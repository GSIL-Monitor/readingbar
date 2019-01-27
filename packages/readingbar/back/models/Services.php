<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
	public $table='services';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('service_name');

}

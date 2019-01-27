<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
	public $table='setting';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('name','key','value');

}

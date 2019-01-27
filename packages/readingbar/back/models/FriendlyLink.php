<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class FriendlyLink extends Model
{
	public $table='friendly_link';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('partner','link','status','del');
}

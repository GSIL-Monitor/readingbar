<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerIdea extends Model
{
	public $table='customer_idea';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('idea','member_id','reply','show_status','del');
}

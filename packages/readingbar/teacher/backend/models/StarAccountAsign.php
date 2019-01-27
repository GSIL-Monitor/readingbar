<?php

namespace Readingbar\Teacher\Backend\Models;

use Illuminate\Database\Eloquent\Model;

class StarAccountAsign extends Model
{
	public $table='star_account_asign';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('created_by','asign_to','account_id');
}

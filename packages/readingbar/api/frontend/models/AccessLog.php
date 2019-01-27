<?php

namespace Readingbar\Api\Frontend\Models;

use Illuminate\Database\Eloquent\Model;

class AccessLog extends Model
{
	public $table='access_log';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('uri','theme','member_id','user_id','ip','HTTP_USER_AGENT');
}

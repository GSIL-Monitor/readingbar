<?php

namespace Readingbar\Api\Frontend\Models;

use Illuminate\Database\Eloquent\Model;

class PayNotifyLog extends Model
{
	public $table='pay_notify_log';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('order_id','pay_type','synchronous','HTTP_USER_AGENT');
}

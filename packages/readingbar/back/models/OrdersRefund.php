<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class OrdersRefund extends Model
{
	public $table='orders_refund';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('order_id','refund_no','refund_total','memo');
}

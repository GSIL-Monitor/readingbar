<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class OrdersRefundApply extends Model
{
	public $table='orders_refund_apply';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array(
		'order_id',
    	'status'
   );
}

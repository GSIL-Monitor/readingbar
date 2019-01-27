<?php

namespace Readingbar\Api\Frontend\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
	public $table='orders';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
 	protected $fillable = array(
		'order_id',
		'owner_id',
		'product_id',
		'total',
		'price',
		'deposit',
		'extra_price',
		'expiration_time',
		'days',
		'status',
		'pay_status',
		'serial',
		'pay_type',
		'memo',
		'member_del',
		'completed_at',
		'order_type',
		'refund_oid'
   );
}

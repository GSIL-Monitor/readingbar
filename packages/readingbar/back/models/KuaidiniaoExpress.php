<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class KuaidiniaoExpress extends Model
{
	public $table='kuaidiniao_express';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    		'order_id',
    		'plan_id',
    		'sender',
    		'receiver',
    		'type',
    		'logistic_code',
    		'shipper_code',
    		'traces',
    		'cost',
    		'memo',
    		'status'
    ];

}

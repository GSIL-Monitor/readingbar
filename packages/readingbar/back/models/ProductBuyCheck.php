<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class ProductBuyCheck extends Model
{
	public $table='product_buy_check';
	public $timestamps = false;
    protected $fillable = array(
    		'product_id',
    		'array',
    		'number',
    		'string',
    		'boolean',
    		'type',
    		'message',
    		'display'
    );
}

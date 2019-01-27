<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class ProductRenewDiscount extends Model
{
	public $table='product_renew_discount';
	public $timestamps = false;
    protected $fillable = array(
    		'id',
    		'name',
    		'product_id', //续费产品
    		'type', //产品续费策略类型
    		'days', //天数
    		'discount_price',// 优惠价格
    		'product',// 相应产品
    		'services',//对应服务（多选）
    		'service_id',//对应服务（单选）
    		'display'
    );
}

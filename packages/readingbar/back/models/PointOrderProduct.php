<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class PointOrderProduct extends Model
{
	public $table='s_point_order_product';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('order_id','product_id','product_name','image','point','desc','quantity','catagory','type','type_v','status','del');
}


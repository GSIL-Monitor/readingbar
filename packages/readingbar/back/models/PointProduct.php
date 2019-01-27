<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class PointProduct extends Model
{
	public $table='s_point_product';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('product_name','image','point','desc','quantity','catagory','status','type','type_v');
}

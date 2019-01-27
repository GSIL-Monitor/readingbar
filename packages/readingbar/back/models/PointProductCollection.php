<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class PointProductCollection extends Model
{
	public $table='s_point_product_collection';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('member_id','product_id');
}

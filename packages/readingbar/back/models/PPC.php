<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class PPC extends Model
{
	public $table='s_point_product_catagory';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('catagory_name','icon_pc','icon_wap','del');
}

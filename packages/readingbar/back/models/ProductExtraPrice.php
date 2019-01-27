<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class ProductExtraPrice extends Model
{
	public $table='product_extra_price';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('name','product_id','extra_price','type','areas','memo','status');

}

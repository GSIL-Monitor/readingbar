<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class ProductExtraPriceType extends Model
{
	public $table='product_extra_price_type';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('id','name');

}

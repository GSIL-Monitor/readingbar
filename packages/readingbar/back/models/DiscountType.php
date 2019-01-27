<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountType extends Model
{
	public $table='discount_type';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('name','days','price','products','memo','status','get_rule','get_rule_promotions_types','get_rule_products','donation','get_limit');

}

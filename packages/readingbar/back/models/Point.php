<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
	public $table='s_point';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('name','point','get_rule','get_rule_products','get_rule_promotions_types','status','del');
}

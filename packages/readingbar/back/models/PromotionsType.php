<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionsType extends Model
{
	public $table='promotions_type';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('name','o_discount','s_discount');
}

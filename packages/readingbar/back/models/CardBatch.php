<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class CardBatch extends Model
{
	public $table='card_batch';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('name','product_id','price','deposit','desc','status','expired');

}

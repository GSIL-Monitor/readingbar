<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class Cards extends Model
{
	public $table='cards';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('card_id','card_pwd','batch_id','student_id','address','deliver_to','phone','memo','sent');
}

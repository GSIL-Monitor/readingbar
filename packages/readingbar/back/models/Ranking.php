<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class Ranking extends Model
{
	public $table='ranking';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('student_id','books','words','books_improved','words_improved','ARPoints','date','type');
}

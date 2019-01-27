<?php

namespace Readingbar\Teacher\Backend\Models;

use Illuminate\Database\Eloquent\Model;

class Favorites extends Model
{
	public $table='favorites';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('user_id','book_id','comment');

}

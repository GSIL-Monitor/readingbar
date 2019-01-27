<?php

namespace Readingbar\Bookcomment\Frontend\Models;

use Illuminate\Database\Eloquent\Model;

class book_comment extends Model
{
	public $table='book_comment';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('ISBN','commented_by','comment','status');
}

<?php

namespace Readingbar\Teacher\Backend\Models;

use Illuminate\Database\Eloquent\Model;

class BookComment extends Model
{
	public $table='book_comment';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('ISBN','commented_by','comment','status');

}

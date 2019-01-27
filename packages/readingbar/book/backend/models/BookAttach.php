<?php

namespace Readingbar\Book\Backend\Models;

use Illuminate\Database\Eloquent\Model;

class BookAttach extends Model
{
	public $table='book_attach';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('BookID','path','type','title','extension');

}

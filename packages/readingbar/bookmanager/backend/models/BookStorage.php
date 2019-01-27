<?php

namespace Readingbar\Bookmanager\Backend\Models;

use Illuminate\Database\Eloquent\Model;

class BookStorage extends Model
{
	public $table='book_storage';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('book_id','serial','storage_full_name','operate_by','status');
}

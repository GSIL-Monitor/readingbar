<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class BookStorageLog extends Model
{
	public $table='book_storage_log';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array(
    		'book_id',
    		'serial',
    		'status',
    		'plan_id',
    		'memo',
    		'operate_by'
    );
}

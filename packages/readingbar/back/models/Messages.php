<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
	public $table='messages';
	protected $fillable = array('sendfrom','sendto','title','content','message_type','reply');
}

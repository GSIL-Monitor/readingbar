<?php

namespace Tools\Messages\Models;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
	public $table='messages';
	protected $fillable = array('sendfrom','sendto','title','reply','content','message_type','receiver_del','sender_del');
}

<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class AlidayuMessageTpl extends Model
{
	public $table='alidayu_message_tpl';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('name','sms','content');
}

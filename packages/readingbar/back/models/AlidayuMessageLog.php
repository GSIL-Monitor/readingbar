<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class AlidayuMessageLog extends Model
{
	public $table='alidayu_message_log';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('setting_id','tag','memo');
}

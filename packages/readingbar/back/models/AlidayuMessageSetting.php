<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class AlidayuMessageSetting extends Model
{
	public $table='alidayu_message_setting';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('name','type','tpl_id','product_id','service_id','days','status','deleted_at');
	public function tpl() {
		return $this->hasOne(AlidayuMessageTpl::class,'id','tpl_id')->first();
	} 
}

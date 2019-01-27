<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
	public $table='members';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('cellphone','email','nickname','QQopenid','password','question','answer','remember_token','actived','address');
	/**
	 * 获取会员名下的所有孩子
	 */
	public function children(){
		return $this->hasMany('Readingbar\Back\Models\Students', 'parent_id', 'id')->where(['del'=>0])->get();
	}
	/**
	 * 购买产品次数数 or 指定产品购买次数 or 为指定孩子购买指定产品的次数
	 */
	public function boughtCount($pid=0,$sid=0){
		$sids=$this->children()->pluck('id')->all();
		if ($sid) {
			if(in_array($sid,$sids)){
				$sids = [$sid];
			}else{
				$sid = [];
			}
		}
		return Orders::where(['status'=>1])->whereIn('owner_id',$sids)->where(function ($where) use($pid){
			if ($pid) {
				$where->where(['product_id'=>$pid]);
			}
		})->count();
	}
}

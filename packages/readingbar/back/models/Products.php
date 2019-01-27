<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
	public $table='products';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('product_name','price','deposit','days','memo','show');
	static function getEnableProducts(){
		return self::get();
	}
	/*购买前置服务校验*/
	static function checkPreServices($sid,$pid){
		$p=self::where(['id'=>$pid])->first();
		if($p->able_pre_services){
			if($p->able_pre_services=='all'){
				//产品前置服务
				return Students::hasService($sid);
			}else{
				//产品前置服务
				$services=explode(',',$p->able_pre_services);
				foreach ($services as $id){
					if(Students::hasService($sid,$id)){   //学生是否满足前置服务中的一项
						return true;
					}
				}
				return false;
			}
		}else{
			//无需前置服务
			return true;
		}
	}
	/*不可购买前置服务校验*/
	static function checkUnPreServices($sid,$pid){
		$p=self::where(['id'=>$pid])->first();
		if($p->unable_pre_services){
			if($p->unable_pre_services=='all'){
				//产品不可购买的前置服务
				if(Students::hasService($sid)){
					return false;;
				}else{
					return true;;
				}
			}else{
				//产品不可购买的前置服务
				$services=explode(',',$p->unable_pre_services);
				foreach ($services as $id){
					if(Students::hasService($sid,$id)){   //学生是否满足前置服务中的一项
						return false;
					}
				}
				return true;
			}
		}else{
			//无需不可购买前置服务
			return true;
		}
	}
	/**
	 * 产品是否有star测试服务
	 */
	public function hasStarTestService() {
		return $this->hasOne(Services::class,'id','service_id')
		->where(['services.star_account_service'=>1])
		->count();
	}
	/**
	 * 产品是否有阅读计划服务
	 */
	public function hasReadPlanService() {
		return  $this->hasOne(Services::class,'id','service_id')
		->where(['services.read_plan_service'=>1])
		->count();
	}
}

<?php

namespace Readingbar\Api\Frontend\Models;

use Illuminate\Database\Eloquent\Model;
use Readingbar\Back\Models\Services;

class Products extends Model
{
	public $table='products';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('product_name','price','deposit','days','memo');
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

<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Students extends Model
{
	public $table='students';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('parent_id','name','nick_name','avatar','dob','sex','grade','school_name','address','favorite','province','city','area','survey_status','group_id','expiration_time');
    static function hasService($student_id,$service_id=0){
    	if($service_id){
    		return ServiceStatus::where(['student_id'=>$student_id,'service_id'=>$service_id])
    		->where('expirated','>',DB::raw('NOW()'))
    		->count();
    	}else{
    		return ServiceStatus::where(['student_id'=>$student_id])
    		->where('expirated','>',DB::raw('NOW()'))
    		->count();
    	}
    }
	//获取学生服务信息
	static function getStudentServices($student_id){
		return ServiceStatus::leftjoin('services','services.id','=','service_status.service_id')
		->where(['service_status.student_id'=>$student_id])
		->where('service_status.expirated','>',DB::raw('NOW()'))
		->get(['services.service_name as name','service_status.expirated','services.id as service_id']);
	}
	// 是否有阅读计划的服务权限
	static function hasReadPlanService($sid){
		$s=ServiceStatus::leftjoin('students as s','s.id','=','service_status.student_id')
		->leftjoin('services','services.id','=','service_status.service_id')
		->where(['s.parent_id'=>auth('member')->id(),'s.id'=>$sid,'services.read_plan_service'=>1])
		->where('service_status.expirated','>',DB::raw('NOW()'))
		->count();
		return $s;
	}
	//获取学生服务最长的服务期限
	static function getMaxServiceExpirated($student_id){
		return ServiceStatus::leftjoin('services','services.id','=','service_status.service_id')
			->where(['service_status.student_id'=>$student_id])
			->where('service_status.expirated','>',DB::raw('NOW()'))
			->max('service_status.expirated');
	}
	//获取学生特定服务的服务期限
	static function getServiceExpirated($student_id,$service_id){
		return ServiceStatus::leftjoin('services','services.id','=','service_status.service_id')
			->where(['service_status.student_id'=>$student_id,'service_id'=>$service_id])
			->where('service_status.expirated','>',DB::raw('NOW()'))
			->max('service_status.expirated');
	}
	// 学生的最新的GE值
	public function lastGe(){
		$r=$this->hasMany('Readingbar\Back\Models\StarReport','student_id','id')->where(['report_type'=>0])->orderBy('id','desc')->first();
		if ($r) {
			return $r->ge;
		}else{
			return 0;
		}
	}
	// 学生的家长
	public function parent(){
		return $this->hasOne(Members::class,'id','parent_id')->first();
	}
	// 学生的报告
	public function reports(){
		return $this->hasMany('Readingbar\Back\Models\StarReport','student_id','id')->get();
	}
	// 学生的star报告
	public function starReports(){
		return $this->hasMany('Readingbar\Back\Models\StarReport','student_id','id')->where(['report_type'=>0])->get();
	}
	// 学生的阶段报告
	public function stageReports(){
		return $this->hasMany('Readingbar\Back\Models\StarReport','student_id','id')->where(['report_type'=>1])->get();
	}
	// 学生未完成的借阅服务计划
	public function uncompletedBorrowService(){
		return $this->hasMany('Readingbar\Back\Models\ReadPlan','for','id')->where(['type'=>1])->where(function ($where){
			$where->where('status','<',5)->orWhere('status','=',6);
		})->first();
	}
	// 已存在的借阅服务计划数量
	public function countBorrowPlan(){
		return $this->hasMany('Readingbar\Back\Models\ReadPlan','for','id')->where(['type'=>1])->count();
	}
	// 今年已存在的借阅计划数量
	public function countBorrowPlanCY(){
		return $this->hasMany('Readingbar\Back\Models\ReadPlan','for','id')
							->where(['type'=>1])
							->where('created_at','like',date('Y').'%')
							->count();
	}
	// 今年已存在的阅读计划数量
	public function countReadPlanCY(){
		return $this->hasMany('Readingbar\Back\Models\ReadPlan','for','id')
		->where(['type'=>0])
		->where('created_at','like',date('Y').'%')
		->count();
	}
	// 学生未完成的阅读计划
	public function uncompletedReadPlan(){
		return $this->hasMany('Readingbar\Back\Models\ReadPlan','for','id')->where(['type'=>0])->where(function ($where){
			$where->where('status','<',5)->orWhere('status','=',6);
		})->first();
	}
	// 学生的蕊丁币
	public function point(){
		$st=$this->hasOne('Readingbar\Back\Models\PointStatus','student_id','id')->first();
		if ($st){
			return (int)$st->point;
		}else{
			return 0;
		}
	}
	/**
	 * 学生是否有star测试服务
	 */
	public function hasSTService() {
		return $this->hasMany(ServiceStatus::class,'student_id','id')
					->crossJoin('services','services.id','=','service_status.service_id')
					->where(['services.star_account_service'=>1])
					->where('service_status.expirated','>',DB::raw('Now()'))
					->count();
	}
	/**
	 * 学生是否有阅读计划服务
	 */
	public function hasRPService() {
		return $this->hasMany(ServiceStatus::class,'student_id','id')
					->crossJoin('services','services.id','=','service_status.service_id')
					->where(['services.read_plan_service'=>1])
					->where('service_status.expirated','>',DB::raw('Now()'))
					->count();
	}
	/**
	 * 学生购买过包含指定服务的产品次数
	 */
	public function hasBoughtProductOfService($service_id){
		return $this->hasMany(Orders::class,'owner_id','id')
					->crossJoin('products','products.id','=','orders.product_id')
					->where(['orders.status'=>1,'orders.order_type'=>0,'products.service_id'=>$service_id])
					->count();
	}
	/**
	 * 判断学生是否有对应产品的押金
	 * @param unknown $pid
	 */
	public function hasDepositOfProject($pid){
		return Orders::where(['orders.owner_id'=>$this->id,'orders.order_type'=>0,'orders.product_id'=>$pid,'orders.status'=>1])
				->where('orders.deposit','>',0)
				->leftJoin('orders as b','orders.id','=','b.refund_oid')
				->groupBy('orders.id')
				->havingRaw('count(b.id) = 0')
				->get(['orders.id'])
				->count();
	}
}

<?php

namespace Readingbar\Api\Frontend\Models;

use Illuminate\Database\Eloquent\Model;
use Readingbar\Back\Models\ServiceStatus;
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
	/**
	 * 判断用户是否拥有服务
	 * @param unknown $student_id
	 * @param number $service_id  指定服务类型
	 */
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
	static function getStudentServices($student_id){
		return ServiceStatus::leftjoin('services','services.id','=','service_status.service_id')
			->where(['service_status.student_id'=>$student_id])
			->where('service_status.expirated','>',DB::raw('NOW()'))
			->get(['services.service_name as name','service_status.expirated']);
	}
	
	static function hasReadPlanService($sid){
		$s=ServiceStatus::leftjoin('students as s','s.id','=','service_status.student_id')
				->leftjoin('services','services.id','=','service_status.service_id')
				->where(['s.parent_id'=>auth('member')->id(),'s.id'=>$sid,'services.read_plan_service'=>1])
				->where('service_status.expirated','>',DB::raw('NOW()'))
				->count();
		return $s;
	}
}

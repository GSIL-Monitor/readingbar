<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BookStorage extends Model
{
	public $table='book_storage';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('book_id','serial','storage_full_name','operate_by','status');

    /**
     * 获取库存相关信息
     */
    public function getInfoByStatus() {
    	$log = BookStorageLog::where(['book_id'=>$this->book_id,'serial'=>$this->serial])
    					->orderBy('id','desc')
    					->first();
     if ($log) {
	      switch ($log->status) {
	      	// 显示借出时间、计划归还时间（服务到期日）、借书STAR账号以及对应指导老师
	      	case '6':
	      		$plan=ReadPlan::where(['id'=>$log->plan_id])->first();
	      		$starAccount = StarAccount::where(['asign_to'=>$plan->for])->first(['star_account']);
	      		$student = Students::where(['id'=>$plan->for])->first(['name','nick_name','group_id']);
	      		$teacher = DB::table('users as u')->leftjoin('student_group as sg','u.id','=','sg.user_id')->where(['sg.id'=>$student->group_id])->first(['u.name']);
	      		$ll=BookStorageLog::where(['book_id'=>$this->book_id,'serial'=>$this->serial,'status'=>3])
		      		->orderBy('id','desc')
		      		->first();
	      		return [
	      				'lended_time'=>date('Y-m-d',strtotime($ll->created_at)),
	      				'plan_end'=>$plan->to,
	      				'star_account'=>$starAccount?$starAccount->star_account:'',
	      				'student_name'=>$student->name,
	      				'student_nickname'=>$student->nick_name,
	      				'teacher_name'=>$teacher->name
	      		];
	      	case '3':
	      		$plan=ReadPlan::where(['id'=>$log->plan_id])->first();
	      		$starAccount = StarAccount::where(['asign_to'=>$plan->for])->first(['star_account']);
	      		$student = Students::where(['id'=>$plan->for])->first(['name','nick_name','group_id']);
	      		$teacher = DB::table('users as u')->leftjoin('student_group as sg','u.id','=','sg.user_id')->where(['sg.id'=>$student->group_id])->first(['u.name']);
	      		return [
	      				'lended_time'=>date('Y-m-d',strtotime($log->created_at)),
	      				'plan_end'=>$plan->to,
	      				'star_account'=>$starAccount?$starAccount->star_account:'',
	      				'student_name'=>$student->name,
	      				'student_nickname'=>$student->nick_name,
	      				'teacher_name'=>$teacher->name
	      		];
	      		break;
	      	case '4':
	      		$teacher = DB::table('users as u')->where(['u.id'=>$log->operate_by])->first(['u.name']);
	      		return [
	      				'locked_time'=>date('Y-m-d',strtotime($log->created_at)),
	      				'teacher_name'=>$teacher->name
	      		];
	      	case '5':
	      		return [
	      				'lossed_time'=>date('Y-m-d',strtotime($log->created_at)),
	      		];
	      	default: return null;
	      }				
    }else{
    	return null;
    }
   }
}

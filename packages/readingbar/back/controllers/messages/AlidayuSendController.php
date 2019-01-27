<?php
namespace Readingbar\Back\Controllers\Messages;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Readingbar\Back\Controllers\BackController;
use Readingbar\Back\Models\AlidayuMessageTpl;
use Messages;
use Readingbar\Back\Models\AlidayuMessageSetting;
use Readingbar\Back\Models\Products;
use Readingbar\Back\Models\Services;
use Readingbar\Back\Models\Students;
use Readingbar\Back\Models\ServiceStatus;
use Readingbar\Back\Models\Members;
use Readingbar\Back\Models\AlidayuMessageLog;
/**
 * 阿里大鱼消息发送控制器
 * @author johnathan
 */
class AlidayuSendController  extends BackController
{
	/**
	 * 根据参数发送短信
	 * @param unknown $options
	 */
	public function send($type,$phone=null,$options=null){
		switch($type){
			case 'after_service_start': // 服务开始后n天通知
				$this->sendAfterServiceStart();
				break;
			case 'after_service_end': // 服务期到期后n天通知
				$this->sendAfterServiceEnd();
				break;
			case 'before_service_end': // 服务期到期前n天通知
				$this->sendBeforeServiceEnd();
				break;
			case 'bought': // 产品购买通知
				$this->sendBought($phone,$options);
				break;
			case 'renew': // 续费产品购买通知
				$this->sendRenew($phone,$options);
				break;
			case 'wait_assign_staraccount':	// 等待分配账号通知
				$this->sendWaitAssignStaraccount($phone,$options);
				break;
			case 'apply_return_deposit': // 申请退押金
				$this->sendApplyReturnDeposit($phone,$options);
				break;
			case 'return_deposit': // 退回押金
				$this->sendReturnDeposit($phone,$options);
				break;
			case 'upload_star_report': // 上传star报告
				$this->sendUploadStarReport($phone,$options);
				break;
			case 'upload_stage_report': // 上传阶段报告
				$this->sendUploadStageReport($phone,$options);
				break;
			case 'send_read_plan': // 定制计划发书
				$this->sendSReadPlan($phone,$options);
				break;
			case 'send_borrow_plan': // 借阅计划发书
				$this->sendSBorrowPlan($phone,$options);
				break;
			case 'recovery_read_plan': // 定制计划回收
				$this->sendRReadPlan($phone,$options);
				break;
			case 'recovery_borrow_plan': // 借阅计划回收
				$this->sendRBorrowPlan($phone,$options);
				break;
			case 'before_read_plan_end': // 定制计划结束前n天通知
				$this->sendBeforeReadPlanEnd();
				break;
			case 'before_borrow_plan_end': // 借阅计划结束前n天通知
				$this->sendBeforeBorrowPlanEnd();
				break;
			case 'upload_read_plan': // 定制计划上传通知
				$this->sendUploadReadPlan($phone, $options);
				break;
			case 'upload_borrow_plan': // 借阅计划上传通知
				$this->sendUploadBorrowPlan($phone, $options);
				break;
		}
	}

	/**
	 * 服务结束前几天发送通知
	 */
	private function sendBeforeServiceEnd(){
		// 获取所有已启用的发送配置
		$settings=AlidayuMessageSetting::crossJoin('alidayu_message_tpl','alidayu_message_tpl.id','=','alidayu_message_setting.tpl_id')
			->where(['alidayu_message_setting.type'=>1,'alidayu_message_setting.status'=>1])
			->whereNull('alidayu_message_setting.deleted_at')
			->whereNull('alidayu_message_tpl.deleted_at')
			->get([
					'alidayu_message_setting.*',
					'alidayu_message_tpl.sms'
			]);
		foreach ($settings as $s){
			if(!$this->existSendLog($s,date('Ymd'))){
				//  检索所有学生满足条件的学生
				$students = Students::crossJoin('service_status','service_status.student_id','=','students.id')
					->crossJoin('services','service_status.service_id','=','services.id')
					->where(DB::raw('TIMESTAMPDIFF(DAY,NOW(),service_status.expirated)'),'=',$s->days)
					->where(['service_id'=>$s->service_id])
					->get(['students.name as student_name','students.parent_id','services.service_name']);
				// 获取满足条件的家长信息
				$parents = Members::whereIn('id',$students->pluck('parent_id')->all())->get();
				foreach ($parents as $p){
					if($p->cellphone){ // 判断家长是否设置了手机号码 是则发送短信
						Messages::sendMobile($p->cellphone,[],$s->sms);
					}
				}
				$this->addSendLog($s, date('Ymd'),'服务到期前'.$s->days.'天通知');
			}
		}
	}
	/**
	 * 服务开始后几天发送通知
	 */
	private function sendAfterServiceStart(){
		// 获取所有已启用的发送配置
		$settings=AlidayuMessageSetting::crossJoin('alidayu_message_tpl','alidayu_message_tpl.id','=','alidayu_message_setting.tpl_id')
				->where(['alidayu_message_setting.type'=>2,'alidayu_message_setting.status'=>1])
				->whereNull('alidayu_message_setting.deleted_at')
				->whereNull('alidayu_message_tpl.deleted_at')
				->get([
						'alidayu_message_setting.*',
						'alidayu_message_tpl.sms'
				]); 
		foreach ($settings as $s){
			if(!$this->existSendLog($s,date('Ymd'))){
				//  检索所有学生满足条件的学生
				$students = Students::crossJoin('service_status','service_status.student_id','=','students.id')
					->crossJoin('services','service_status.service_id','=','services.id')
					->where(DB::raw('TIMESTAMPDIFF(DAY,service_status.start,NOW())'),'=',$s->days)
					->where(['service_id'=>$s->service_id])
					->get(['students.name as student_name','students.parent_id','services.service_name']);
				// 获取满足条件的家长信息
				$parents = Members::whereIn('id',$students->pluck('parent_id')->all())->get();
				foreach ($parents as $p){
					if($p->cellphone){ // 判断家长是否设置了手机号码 是则发送短信
						Messages::sendMobile($p->cellphone,[],$s->sms);
					}
				}
				$this->addSendLog($s, date('Ymd'),'服务开始后'.$s->days.'天通知');
			}
		}
	}
	/**
	 * 服务结束后几天发送通知
	 */
	private function sendAfterServiceEnd(){
		// 获取所有已启用的发送配置
		$settings=AlidayuMessageSetting::crossJoin('alidayu_message_tpl','alidayu_message_tpl.id','=','alidayu_message_setting.tpl_id')
				->where(['alidayu_message_setting.type'=>3,'alidayu_message_setting.status'=>1])
				->whereNull('alidayu_message_setting.deleted_at')
				->whereNull('alidayu_message_tpl.deleted_at')
				->get([
						'alidayu_message_setting.*',
						'alidayu_message_tpl.sms'
				]); 
		foreach ($settings as $s){
			if(!$this->existSendLog($s,date('Ymd'))){
				//  检索所有学生满足条件的学生
				$students = Students::crossJoin('service_status','service_status.student_id','=','students.id')
					->crossJoin('services','service_status.service_id','=','services.id')
					->where(DB::raw('TIMESTAMPDIFF(DAY,service_status.expirated,NOW())'),'=',$s->days)
					->where(['service_id'=>$s->service_id])
					->get(['students.name as student_name','students.parent_id','services.service_name']);
				// 获取满足条件的家长信息
				$parents = Members::whereIn('id',$students->pluck('parent_id')->all())->get();
				foreach ($parents as $p){
					if($p->cellphone){ // 判断家长是否设置了手机号码 是则发送短信
						Messages::sendMobile($p->cellphone,[],$s->sms);
					}
				}
				$this->addSendLog($s, date('Ymd'),'服务到期后'.$s->days.'天通知');
			}
		}
	}
	/**
	 * 定制计划结束前几天发送通知
	 */
	private function sendBeforeReadPlanEnd(){
		// 获取所有已启用的发送配置
		$settings=AlidayuMessageSetting::crossJoin('alidayu_message_tpl','alidayu_message_tpl.id','=','alidayu_message_setting.tpl_id')
		->where(['alidayu_message_setting.type'=>13,'alidayu_message_setting.status'=>1])
		->whereNull('alidayu_message_setting.deleted_at')
		->whereNull('alidayu_message_tpl.deleted_at')
		->get([
				'alidayu_message_setting.*',
				'alidayu_message_tpl.sms'
		]);
		foreach ($settings as $s){
			if(!$this->existSendLog($s,date('Ymd'))){
				//  检索所有学生满足条件的学生
				$students = Students::crossJoin('read_plan','read_plan.for','=','students.id')
										->where(DB::raw('TIMESTAMPDIFF(DAY,NOW(),read_plan.to)'),'=',$s->days)
										->get(['students.*']);
				// 获取满足条件的家长信息
				$parents = Members::whereIn('id',$students->pluck('parent_id')->all())->get();
				foreach ($parents as $p){
					if($p->cellphone){ // 判断家长是否设置了手机号码 是则发送短信
						Messages::sendMobile($p->cellphone,[],$s->sms);
					}
				}
				$this->addSendLog($s, date('Ymd'),'定制阅读到期前'.$s->days.'天通知');
			}
		}
	}
	/**
	 * 购买产品后通知
	 */
	private function sendBought($phone,$options){
		if($phone){
			$setting=AlidayuMessageSetting::crossJoin('alidayu_message_tpl','alidayu_message_tpl.id','=','alidayu_message_setting.tpl_id')
				->where(['alidayu_message_setting.type'=>4,'alidayu_message_setting.status'=>1,'alidayu_message_setting.product_id'=>$options['product_id']])
				->whereNull('alidayu_message_setting.deleted_at')
				->whereNull('alidayu_message_tpl.deleted_at')
				->first(['alidayu_message_setting.*','alidayu_message_tpl.sms']);
			if($setting){
				Messages::sendMobile($phone,[],$setting->sms);
			}
		}
	}
	/**
	 * 续费购买产品后通知
	 */
	private function sendRenew($phone,$options){
		if($phone){
			$setting=AlidayuMessageSetting::crossJoin('alidayu_message_tpl','alidayu_message_tpl.id','=','alidayu_message_setting.tpl_id')
			->where(['alidayu_message_setting.type'=>5,'alidayu_message_setting.status'=>1,'alidayu_message_setting.product_id'=>$options['product_id']])
			->whereNull('alidayu_message_setting.deleted_at')
			->whereNull('alidayu_message_tpl.deleted_at')
			->first(['alidayu_message_setting.*','alidayu_message_tpl.sms']);
			if($setting){
				Messages::sendMobile($phone,[],$setting->sms);
			}
		}
	}
	/**
	 * 等待star账号分配通知
	 * @param unknown $phone
	 * @param unknown $options
	 */
	private function sendWaitAssignStaraccount($phone,$options){
		$this->sendDefault(6,$phone,$options);
	}
	/**
	 * 申请退押金
	 * @param unknown $phone
	 * @param unknown $options
	 */
	private function sendApplyReturnDeposit($phone,$options){
		if($phone){
			$setting=AlidayuMessageSetting::crossJoin('alidayu_message_tpl','alidayu_message_tpl.id','=','alidayu_message_setting.tpl_id')
			->where(['alidayu_message_setting.type'=>7,'alidayu_message_setting.status'=>1,'alidayu_message_setting.product_id'=>$options['product_id']])
			->whereNull('alidayu_message_setting.deleted_at')
			->whereNull('alidayu_message_tpl.deleted_at')
			->first(['alidayu_message_setting.*','alidayu_message_tpl.sms']);
			if($setting){
				Messages::sendMobile($phone,[],$setting->sms);
			}
		}
	}
	/**
	 * 退回押金
	 * @param unknown $phone
	 * @param unknown $options
	 */
	private function sendReturnDeposit($phone,$options){
		if($phone){
			$setting=AlidayuMessageSetting::crossJoin('alidayu_message_tpl','alidayu_message_tpl.id','=','alidayu_message_setting.tpl_id')
			->where(['alidayu_message_setting.type'=>8,'alidayu_message_setting.status'=>1,'alidayu_message_setting.product_id'=>$options['product_id']])
			->whereNull('alidayu_message_setting.deleted_at')
			->whereNull('alidayu_message_tpl.deleted_at')
			->first(['alidayu_message_setting.*','alidayu_message_tpl.sms']);
			if($setting){
				Messages::sendMobile($phone,[],$setting->sms);
			}
		}
	}
	/**
	 * 上传star报告通知
	 * @param unknown $phone
	 * @param unknown $options
	 */
	private function sendUploadStarReport($phone,$options){
		$this->sendDefault(9,$phone,$options);
	}
	/**
	 * 上传阶段报告通知
	 * @param unknown $phone
	 * @param unknown $options
	 */
	private function sendUploadStageReport($phone,$options){
		$this->sendDefault(10,$phone,$options);
	}
	/**
	 * 上传定制计划通知
	 * @param unknown $phone
	 * @param unknown $options
	 */
	private function sendUploadReadPlan($phone,$options){
		$this->sendDefault(17,$phone,$options);
	}
	/**
	 * 上传借阅通知
	 * @param unknown $phone
	 * @param unknown $options
	 */
	private function sendUploadBorrowPlan($phone,$options){
		$this->sendDefault(18,$phone,$options);
	}
	/**
	 * 发书通知-定制
	 * @param unknown $phone
	 * @param unknown $options
	 */
	private function sendSReadPlan($phone,$options){
		$this->sendDefault(11,$phone,$options);
	}
	/**
	 * 发书通知-借阅
	 * @param unknown $phone
	 * @param unknown $options
	 */
	private function sendSBorrowPlan($phone,$options){
		$this->sendDefault(14,$phone,$options);
	}
	/**
	 * 回收通知-定制
	 * @param unknown $phone
	 * @param unknown $options
	 */
	private function sendRReadPlan($phone,$options){
		$this->sendDefault(12,$phone,$options);
	}
	/**
	 * 回收通知-借阅
	 * @param unknown $phone
	 * @param unknown $options
	 */
	private function sendRBorrowPlan($phone,$options){
		$this->sendDefault(15,$phone,$options);
	}
	/**
	 * 默认根据类型查找发送短信
	 * @param unknown $phone
	 * @param unknown $options
	 */
	private function sendDefault($type,$phone,$options){
		if($phone){
			$setting=AlidayuMessageSetting::crossJoin('alidayu_message_tpl','alidayu_message_tpl.id','=','alidayu_message_setting.tpl_id')
				->where(['alidayu_message_setting.type'=>$type,'alidayu_message_setting.status'=>1])
				->whereNull('alidayu_message_setting.deleted_at')
				->whereNull('alidayu_message_tpl.deleted_at')
				->first(['alidayu_message_setting.*','alidayu_message_tpl.sms']);
			if($setting){
				Messages::sendMobile($phone,[],$setting->sms);
			}
		}
	}
	/**
	 * 添加发送日志 用于定时任务
	 * @param unknown $setting
	 * @param unknown $tag
	 */
	private function addSendLog($setting,$tag,$memo){
		AlidayuMessageLog::create([
				'setting_id'=>$setting->id,
				'tag'           =>$tag,
				'memo'      =>$memo
		]);
	}
	/**
	 * 判断是否存在满足条件的发送日志
	 * @param unknown $setting
	 * @param unknown $tag
	 */
	private function existSendLog($setting,$tag){
		return AlidayuMessageLog::where([
				'setting_id'=>$setting->id,
				'tag'           =>$tag
		])->count()?true:false;
	}
}
?>
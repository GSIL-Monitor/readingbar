<?php
namespace  Readingbar\Back\Controllers\Alidayu;

use Readingbar\Back\Controllers\BackController;
use Readingbar\Back\Models\AlidayuMessageSetting;
use Readingbar\Back\Models\ServiceStatus;
use DB;
use Readingbar\Back\Models\Students;
use Readingbar\Front\Controllers\MessagesController;
use Messages;
use Readingbar\Back\Models\AlidayuMessageLog;
use Readingbar\Api\Functions\MemberFunction;
class AlidayuController extends BackController
{
	/**
	 * 函数置于定时器下
	 */
	static function MessageTimingTrigger(){
		self::BeforeServiceEnd();
		self::AfterServiceStart();
		self::AfterServiceEnd();
	}
	/**
	 * 服务到期前（n天   定时器触发）
	 */
	private static  function BeforeServiceEnd(){
		// 获取服务到期前的同时设置
		$settings=AlidayuMessageSetting::where(['type'=>1,'status'=>1])->whereNull('deleted_at')->get();
		foreach ($settings as $s) {
			$tpl = $s->tpl(); // 对应短信模板
			if ($tpl) {
				// 获取到期的前n天的服务信息  排除已发送的
				$ss=ServiceStatus::where([
						'service_status.service_id'=>$s->service_id
				])
				->where(DB::raw('TIMESTAMPDIFF(DAY,NOW(),service_status.expirated)'),'=',$s->days)
				// 防止重复发送
				->leftjoin('alidayu_message_log',DB::raw("CONCAT($s->id,'_',service_status.student_id,'_',service_status.service_id,'_',UNIX_TIMESTAMP(service_status.expirated))"),'=','alidayu_message_log.tag')
				->whereNull('alidayu_message_log.id')
				->get(['service_status.*',DB::raw('UNIX_TIMESTAMP(service_status.expirated) as timestamp'),DB::raw("CONCAT($s->id,'_',service_status.student_id,'_',service_status.service_id,'_',UNIX_TIMESTAMP(service_status.expirated)) as tag")]);
				foreach ($ss as $v) {
					$student=Students::where(['id'=>$v->student_id])->first();
					if (MemberFunction::checkUsernameType($student->parent()->cellphone) == 'cellphone') {
						Messages::sendMobile($student->parent()->cellphone,[],$tpl->sms);
						AlidayuMessageLog::create([
								'setting_id'=>$s->id,
								'tag'           =>$v->tag,
								'memo'      =>'服务到期前'.$s->days.'天通知'
						]);
					}
				}
			}
		}
	}
	/**
	 * 服务开始后（n天   定时器触发）
	 */
	private static function  AfterServiceStart () {
		$settings=AlidayuMessageSetting::where(['type'=>2,'status'=>1])->whereNull('deleted_at')->get();
		foreach ($settings as $s) {
				$tpl = $s->tpl(); // 对应短信模板
				if ($tpl) {
					// 获取到期的前n天的服务信息  排除已发送的
					$ss=ServiceStatus::where([
							'service_status.service_id'=>$s->service_id
					])
					->where(DB::raw('TIMESTAMPDIFF(DAY,service_status.start,NOW())'),'=',$s->days)
					// 防止重复发送
					->leftjoin('alidayu_message_log',DB::raw("CONCAT($s->id,'_',service_status.student_id,'_',service_status.service_id,'_',UNIX_TIMESTAMP(service_status.start))"),'=','alidayu_message_log.tag')
					->whereNull('alidayu_message_log.id')
					->get(['service_status.*',DB::raw('UNIX_TIMESTAMP(service_status.start) as timestamp'),DB::raw("CONCAT($s->id,'_',service_status.student_id,'_',service_status.service_id,'_',UNIX_TIMESTAMP(service_status.start)) as tag")]);
					foreach ($ss as $v) {
						$student=Students::where(['id'=>$v->student_id])->first();
						if (MemberFunction::checkUsernameType($student->parent()->cellphone) == 'cellphone') {
							Messages::sendMobile($student->parent()->cellphone,[],$tpl->sms);
							AlidayuMessageLog::create([
									'setting_id'=>$s->id,
									'tag'           =>$v->tag,
									'memo'      =>'服务开始后'.$s->days.'天通知'
							]);
						}
					}
				}
			}
	}
	/**
	 * 服务过期后（n天   定时器触发）
	 */
	private static function  AfterServiceEnd() {
		$settings=AlidayuMessageSetting::where(['type'=>3,'status'=>1])->whereNull('deleted_at')->get();
		foreach ($settings as $s) {
			$tpl = $s->tpl(); // 对应短信模板
			if ($tpl) {
				// 获取到期的前n天的服务信息  排除已发送的
				$ss=ServiceStatus::where([
						'service_status.service_id'=>$s->service_id
				])
				->where(DB::raw('TIMESTAMPDIFF(DAY,service_status.expirated,NOW())'),'=',$s->days)
				// 防止重复发送
				->leftjoin('alidayu_message_log',DB::raw("CONCAT($s->id,'_',service_status.student_id,'_',service_status.service_id,'_',UNIX_TIMESTAMP(service_status.expirated))"),'=','alidayu_message_log.tag')
				->whereNull('alidayu_message_log.id')
				->get(['service_status.*',DB::raw('UNIX_TIMESTAMP(service_status.expirated) as timestamp'),DB::raw("CONCAT($s->id,'_',service_status.student_id,'_',service_status.service_id,'_',UNIX_TIMESTAMP(service_status.expirated)) as tag")]);
				foreach ($ss as $v) {
					$student=Students::where(['id'=>$v->student_id])->first();
					if (MemberFunction::checkUsernameType($student->parent()->cellphone) == 'cellphone') {
						Messages::sendMobile($student->parent()->cellphone,[],$tpl->sms);
						AlidayuMessageLog::create([
								'setting_id'=>$s->id,
								'tag'           =>$v->tag,
								'memo'      =>'服务过期后'.$s->days.'天通知'
						]);
					}
				}
			}
		}
	}
	/**
	 * 产品购买通知
	 */
	public function InformWhenBought($cellphone,$product_id) {
		
	}
}
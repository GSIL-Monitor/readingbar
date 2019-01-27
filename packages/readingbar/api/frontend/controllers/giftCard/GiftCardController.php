<?php

namespace Readingbar\Api\Frontend\Controllers\GiftCard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Readingbar\Back\Models\Members;
use Readingbar\Back\Models\Students;
use Readingbar\Back\Models\Orders;
use Readingbar\Back\Models\Products;
use Superadmin\Backend\Models\User;
use Messages;
use Readingbar\Back\Models\StarAccount;
use Readingbar\Back\Models\Discount;
use Readingbar\Back\Models\ServiceStatus;
use Readingbar\Back\Models\Promotions;
use Readingbar\Back\Controllers\Spoint\PointController;
use Readingbar\Back\Models\Cards;
use Readingbar\Back\Factory\Product\ProductFactory;
use Readingbar\Back\Controllers\Messages\AlidayuSendController;
use Readingbar\Back\Models\AlidayuMessageSetting;
class GiftCardController extends Controller
{
	/*礼品卡激活*/
	public function activeCard(Request $request){
		$inputs=$request->all();
		
		if($msg=$this->checkActive($inputs)){
			$json=array('status'=>false,'error'=>$msg);
		}else{
			$sql='select f_CardRecharge('.$inputs['student_id'];
			$sql.=',\''.$inputs['card'].'\'';
			$sql.=',\''.$inputs['card_pwd'].'\'';
			$sql.=',\''.$inputs['address'].'\'';
			$sql.=',\''.$inputs['name'].'\'';
			$sql.=',\''.$inputs['tel'].'\') as result';
			//echo $sql;
			$v=DB::select($sql);
			if(!$v){
				$json=array('status'=>false,'error'=>'函数执行失败！');
			}else{
				switch($v[0]->result){
					case "0":
								$o=Orders::where(['owner_id'=>$inputs['student_id'],'status'=>1])
										->orderBy('id','desc')
										->first();
								//DiscountController::createPayDiscountForPromoter($o->id);
								//DiscountController::createPayDiscountForProduct($o->id);
								//一般会员购买产品后获得优惠券
								$member=DB::table('members as m')->crossjoin('students as s','m.id','=','s.parent_id')->where(['s.id'=>$o->owner_id])->first(['m.*']);
								Discount::giveByRule($member->id, 'member_buy',['product_id'=>$o->product_id,'buy_member_id'=>$member->id],'orders_'.$o->id);
								$promoter=Promotions::where(['pcode'=>$member->pcode])->first();
								if($promoter){
									//被关联的推广员所推广的会员购买产品时，该会员获得优惠券
									Discount::giveByRule($member->id, 'promoted_member_buy_tm',['promotions_type_id'=>$promoter->type,'product_id'=>$o->product_id,'buy_member_id'=>$member->id],'orders_'.$o->id);
									//关联的推广员所推广的会员购买产品时，推广员获得优惠券
									Discount::giveByRule($promoter->member_id, 'promoted_member_buy_tp',['promotions_type_id'=>$promoter->type,'product_id'=>$o->product_id,'buy_member_id'=>$member->id],'orders_'.$o->id);
								}
								//购买产品获得积分
								PointController::increaceByRule([
										'rule'=>'buy_product',
										'product_id'=>$o->product_id,
										'student_id'=>$o->owner_id
								]);
								$product=Products::where(['id'=>$o->product_id])->first();
								
								/*消息通知设置*/
									$product=Products::where(['id'=>$o->product_id])->first();
									$student=Students::where(['id'=>$o->owner_id])->first();
									$member=Members::where(['id'=>$student->parent_id])->first();
									$expirated=date("Y-m-d",strtotime(Students::getServiceExpirated($student->id,$product->service_id)));
									$sendType=0;  //消息发送流程
									
									$bladeData=[
											'student'=>$student->name,   					//购买的孩子名称
											'product'=>$product->product_name, 	//购买的产品名称
											'expirated'=>$expirated,						 	//购买的服务过期日期
											'star_account'=>null,
											'star_password'=>null,
									];
									
									/*star账号分配*/
									if($product->asign_account){ //判断是否需要分配账号
										if($product->send_account){ //判断是否需要发送
											$a=DB::select('select fun_asign_account_v3('.$student->id.') as result');
											if($a[0]->result){
												$staraccount=StarAccount::where(['id'=>$a[0]->result])->first();
												$bladeData['star_account']=$staraccount->star_account;
												$bladeData['star_password']=$staraccount->star_password;
											}else{
												//账号等待老师分配
												$sendType=1;
											}
										}else{
											//账号等待老师分配
											$sendType=1;
										}
									}
									switch($sendType){
										//账号等待老师分配
										case 1:
											$teacher=User::leftjoin('student_group','student_group.user_id','=','users.id')
												->leftjoin('students','student_group.id','=','students.group_id')
												->where(['users.role'=>3,'students.id'=>$student->id])
												->first(['users.*']);
											/*发送短信*/
											$alidayu = new AlidayuSendController();
											$alidayu->send('wait_assign_staraccount',$member->cellphone);
											/*发送站内消息*/
											if($member->email || $member->cellphone){
												Messages::sendSiteMessage('产品购买通知',"您已购买产品，等待老师发送账号",$member->cellphone?$member->cellphone:$member->email);
											}
											
											/*通知老师或指导员*/
											if($teacher){  //通知老师
												Messages::sendSiteMessage('学生购买通知',"昵称为".$student->nick_name."的学生，购买了【".$product->product_name."】需要分配star账号,分配star账号后记得通知家长哦~",$teacher->id);
											}else{
												Messages::sendSiteMessage('学生购买通知',"昵称为".$student->nick_name."的学生，购买了【".$product->product_name."】,请分配老师并叫老师分配star账号,分配star账号后记得通知家长哦~",3);
											}
											break;
									    //正常购买流程
										default:
												$bladeData['bought_times'] = $member->boughtCount($product->id,$student->id) >1;
												
												/*发送短信*/
												$alidayu = new AlidayuSendController();
												// 续费短信是否设置
												$seted=AlidayuMessageSetting::where(['type'=>5,'product_id'=>$product->id,'status'=>1])->whereNull('deleted_at')->count();
												if($bladeData['bought_times'] && $seted){ // 续费购买短信
													$alidayu->send('renew',$member->cellphone,[
															'product_id'=>$product->id,
															'product_name'=>$product->product_name
													]);
												}else{ // 初次购买短信
													$alidayu->send('bought',$member->cellphone,[
															'product_id'=>$product->id,
															'product_name'=>$product->product_name
													]);
												}
												/*发送邮件*/
												if($product->send_email_blade && $member->email){
													/* 获得该用户第n次购买该产品信息 */
													Messages::sendEmail("产品购买通知",$member->email,$product->send_email_blade,$bladeData);
												}
												/*发送站内消息*/
												if($product->send_site_message && ($member->email || $member->cellphone)){
													Messages::sendSiteMessage('产品购买通知',$product->send_site_message,$member->cellphone?$member->cellphone:$member->email);
												}
											StarAccount::where(['asign_to'=>$student->id,'status'=>1])->update(['notify_system'=>1]);
									}
						$json=array('status'=>true,'success'=>'礼品卡充值成功！');
						break;
					case "1":
						$json=array('status'=>false,'error'=>'卡号或密码错！');
						break;
					case "2":
						$json=array('status'=>false,'error'=>'礼品卡未激活不可用！');
						break;
					case "3":
						$json=array('status'=>false,'error'=>'礼品卡过期！');
						break;
					case "4":
						$json=array('status'=>false,'error'=>'孩子所在地不在服务区域内！');
						break;
					default:
						$json=array('status'=>false,'error'=>'函数执行失败！');
						break;
				}
			}
		}
		return $json;
	}
	/*激活校验*/
	public function checkActive($inputs){
		$s=Students::where(['id'=>$inputs['student_id'],'parent_id'=>auth('member')->id()])->first();
		if(!$s){
			return '您无权操作该孩子！';
		}
		$card = Cards::where(['card_id'=>$inputs['card'], 'card_pwd'=>$inputs['card_pwd']])->first();
		if(!$card){
			return '卡号或密码错误！';
		}else if($card->student_id){
			return '该卡号已被使用！';
		}
		$product = Products::whereIn('id',function($query) use ($card){
			$query->select('product_id')->from('card_batch')->where(['id'=>$card->batch_id]);
		})->first();
		//产品认购前校验
		$pcheck=ProductFactory::checkBeforeBuy($product,$s);
		if (!$pcheck->check() && class_basename($pcheck) !== 'DefaultCheckRule') {
			return $pcheck->message();
		}
		return null;
	}
}
<?php

namespace Readingbar\Api\Frontend\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use Messages;
use Readingbar\Api\Functions\MemberFunction;
use Tools\Messages\Models\Messages as ModelMessages;
use Readingbar\Api\Frontend\Models\Members;
use Superadmin\Backend\Models\User;
class MessageController extends FrontController
{
	private $member=null;
	//验证消息有效期  单位：秒
	private $term=300;
	//验证消息发送间隔  单位：秒
	private $send_interval=60;
	public function __construct(){
		$this->member=auth('member')->member;
	}
	//发送登录验证码
	public function sendLoginCode(Request $request){
		$username=$request->input('username');
		if($username && MemberFunction::activedUsername($username)){
			$s=session('logincode');
			if($s && time()<=$s['send_time']){
				$this->json=array('status'=>false,'error'=>'请'.($s['send_time']-time()).'秒后再试！');
			}else{
				$logincode=array(
						'username'=>$username,
						'code'=>rand(100000,999999),
						'expire'=>time()+$this->term,
						'send_time'=>time()+$this->send_interval
				);
				switch (MemberFunction::checkUsernameType($username)){
					case 'email':
						session(['logincode'=>$logincode]);
						Messages::sendEmail('登录消息验证',$request->input('username'),'messages::login',['content'=>$logincode['code']]);
						$this->json=array('status'=>true,'success'=>'消息已发送！');
						break;
					case 'cellphone':
						session(['logincode'=>$logincode]);
						Messages::sendMobile($request->input('username'),['code'=>$logincode['code'],'product'=>'readingbar'],'SMS_22360006');
						$this->json=array('status'=>true,'success'=>'消息已发送！');
						break;
					default:$this->json=array('status'=>false,'error'=>'请输入手机或者邮箱！');
				}
			}
		}else{
			$this->json=array('status'=>false,'error'=>'账号不存在！消息发送失败！');
		}
		$this->echoJson();
	}
	//发送邮箱验证码
	public function sendEmailCode(Request $request){
		$email=$request->input('email');
		if($email && MemberFunction::checkUsernameType($email)=='email'){
			$s=session('emailcode');
			if($s && time()<=$s['send_time']){
				$this->json=array('status'=>false,'error'=>'请'.($s['send_time']-time()).'秒后再试！');
			}else{
				$emailcode=array(
						'email'=>$email,
						'code'=>rand(100000,999999),
						'expire'=>time()+$this->term,
						'send_time'=>time()+$this->send_interval
				);
				session(['emailcode'=>$emailcode]);
				Messages::sendEmail('邮箱修改验证',$request->input('email'),'messages::update',['content'=>$emailcode['code']]);
				$this->json=array('status'=>true,'success'=>'消息已发送！');
			}
		}else{
			$this->json=array('status'=>false,'error'=>'邮箱格式错误！');
		}
		$this->echoJson();
	}
	//发送手机验证码
	public function sendMobileCode(Request $request){
		$cellphone=$request->input('cellphone');
		if($cellphone && MemberFunction::checkUsernameType($cellphone)=='cellphone'){
			$s=session('cellphonecode');
			if($s && time()<=$s['send_time']){
				$this->json=array('status'=>false,'error'=>'请'.($s['send_time']-time()).'秒后再试！');
			}else{
				$cellphonecode=array(
						'cellphone'=>$cellphone,
						'code'=>rand(100000,999999),
						'expire'=>time()+$this->term,
						'send_time'=>time()+$this->send_interval
				);
				session(['cellphonecode'=>$cellphonecode]);
				Messages::sendMobile($request->input('cellphone'),['code'=>$cellphonecode['code'],'product'=>'readingbar'],'SMS_22360001');
				$this->json=array('status'=>true,'success'=>'消息已发送！');
			}
		}else{
			$this->json=array('status'=>false,'error'=>'手机格式错误！');
		}
		$this->echoJson();
	}
	//发送注册验证码
	public function sendRegisterCode(Request $request){
		if (!$this->checkCaptcha($request)) {
			return array('status'=>false,'error'=>'请输入正确的图形验证码！');
		}
		$username=$request->input('username');
		$s=session('registercode');
		if($s && time()<=$s['send_time']){
			$this->json=array('status'=>false,'error'=>'请'.($s['send_time']-time()).'秒后再试！');
		}else{
			$registercode=array(
					'username'=>$username,
					'code'=>rand(100000,999999),
					'expire'=>time()+$this->term,
					'send_time'=>time()+$this->send_interval
			);
			switch (MemberFunction::checkUsernameType($username)){
				case 'email':
					session(['registercode'=>$registercode]);
					Messages::sendEmail('邮箱注册验证',$request->input('username'),'messages::register',['content'=>$registercode['code']]);
					$this->json=array('status'=>true,'success'=>'消息已发送！');
					break;
				case 'cellphone':
					session(['registercode'=>$registercode]);
					Messages::sendMobile($request->input('username'),['code'=>$registercode['code'],'product'=>'readingbar'],'SMS_22360004');
					$this->json=array('status'=>true,'success'=>'消息已发送！');
					break;
				default:$this->json=array('status'=>false,'error'=>'请输入手机或者邮箱！');
			}
		}
		$this->echoJson();
	}
	//发送忘记密码验证码
	public function sendForgotenCode(Request $request){
		$username=$request->input('username');
		$s=session('forgotencode');
		if($s && time()<=$s['send_time']){
			$this->json=array('status'=>false,'error'=>'请'.($s['send_time']-time()).'秒后再试！');
		}else{
			$m=Members::where(['email'=>$username])->orwhere(['cellphone'=>$username])->first();
			if ($m) {
				$forgotencode=array(
						'username'=>$username,
						'code'=>rand(100000,999999),
						'expire'=>time()+$this->term,
						'send_time'=>time()+$this->send_interval
				);
				switch (MemberFunction::checkUsernameType($username)){
					case 'email':
						session(['forgotencode'=>$forgotencode]);
						Messages::sendEmail('修改密码验证',$request->input('username'),'messages::update',['content'=>$forgotencode['code']]);
						$this->json=array('status'=>true,'success'=>'消息已发送！');
						break;
					case 'cellphone':
						session(['forgotencode'=>$forgotencode]);
						Messages::sendMobile($request->input('username'),['code'=>$forgotencode['code'],'product'=>'readingbar'],'SMS_22360001');
						$this->json=array('status'=>true,'success'=>'消息已发送！');
						break;
					default:$this->json=array('status'=>false,'error'=>'请输入手机或者邮箱！');
				}
			} else {
				$this->json=array('status'=>false,'error'=>'该用户不存在，请确认后再试！');
			}
		}
		$this->echoJson();
	}
	//家长获取消息列表
	public function getMessagesByMember(Request $request){
		if($this->member){
			/*条件*/
			if($request->input('page') && $request->input('page')>1){
				$page=$request->input('page');
			}else{
				$page=1;
			}
			if($request->input('limit') && $request->input('limit')>1){
				$limit=$request->input('limit');
			}else{
				$limit=10;
			}
			if($request->input('order') && in_array('id','created_at')){
				$order=$request->input('order');
			}else{
				$order='created_at';
			}
			if($request->input('sort') && in_array('asc','desc')){
				$sort=$request->input('sort');
			}else{
				$sort='desc';
			}
			/*条件*/
			$messages=ModelMessages::where(['sendto'=>$this->member->email,'receiver_del'=>0])
				->whereNull('reply')
 				->orwhere(['sendto'=>$this->member->cellphone,'receiver_del'=>0])
 				->whereNull('reply')
 				->orwhere(['sendfrom'=>$this->member->email,'sender_del'=>0])
 				->whereNull('reply')
 				->orwhere(['sendfrom'=>$this->member->cellphone,'sender_del'=>0])
 				->whereNull('reply');
			$total=$messages->count();
			
			$messages=$messages->orderBy($order,$sort)
				->skip(($page-1)*$limit)->take($limit)
				->get()->toArray();
			//获取发送人和收件人信息
			foreach ($messages as $k=>$v){
				$messages[$k]['sender']=$this->getSenderAndReciver($v['sendfrom']);
				$messages[$k]['receiver']=$this->getSenderAndReciver($v['sendto']);
				$messages[$k]['replies']=ModelMessages::where(['reply'=>$v['id']])->count();
				$messages[$k]['unread']=ModelMessages::where(['reply'=>$v['id'],'sendto'=>$this->member->cellphone,'receiver_read'=>0])
										->orwhere(['reply'=>$v['id'],'sendto'=>$this->member->email,'receiver_read'=>0])
										->count();
			}
			$this->json=array('status'=>true,'success'=>'消息获取成功','current_page'=>$page,'total_pages'=>ceil((float)$total/$limit),'data'=>$messages);
		}else{
			$this->json=array('status'=>false,'error'=>'用户尚未登录！');
		}
		$this->echoJson();
	}
	//获取消息详情
	public function getMessageDetail($reply,Request $request){
		if($this->member){
			/*条件*/
			if($request->input('page') && $request->input('page')>1){
				$page=$request->input('page');
			}else{
				$page=1;
			}
			if($request->input('limit') && $request->input('limit')>1){
				$limit=$request->input('limit');
			}else{
				$limit=10;
			}
			if($request->input('order') && in_array('id','created_at')){
				$order=$request->input('order');
			}else{
				$order='created_at';
			}
			if($request->input('sort') && in_array('asc','desc')){
				$sort=$request->input('sort');
			}else{
				$sort='asc';
			}
			/*条件*/
			$messages=ModelMessages::where(['sendto'=>$this->member->email])
			->where(['reply'=>$reply])
			->orwhere(['sendto'=>$this->member->cellphone])
			->where(['reply'=>$reply])
			->orwhere(['sendfrom'=>$this->member->email])
			->where(['reply'=>$reply])
			->orwhere(['sendfrom'=>$this->member->cellphone])
			->where(['reply'=>$reply])
			->orwhere(['id'=>$reply]);
			$total=$messages->count();
				
			$messages=$messages->orderBy($order,$sort)
			->skip(($page-1)*$limit)->take($limit)
			->get()->toArray();
			
			ModelMessages::whereIn('sendto',[$this->member->cellphone,$this->member->email])
				->where(['id'=>$reply])
				->update(['receiver_read'=>1]);
			ModelMessages::whereIn('sendto',[$this->member->cellphone,$this->member->email])
				->where(['reply'=>$reply])
				->update(['receiver_read'=>1]);
			//获取发送人和收件人信息
			foreach ($messages as $k=>$v){
				$messages[$k]['sender']=$this->getSenderAndReciver($v['sendfrom']);
				$messages[$k]['receiver']=$this->getSenderAndReciver($v['sendto']);
				
				$messages[$k]['mine']=$messages[$k]['sender']['nickname']==auth('member')->member->nickname?true:false;
			}
			$this->json=array('status'=>true,'success'=>'消息获取成功','current_page'=>$page,'total_pages'=>ceil((float)$total/$limit),'data'=>$messages);
		}else{
			$this->json=array('status'=>false,'error'=>'用户尚未登录！');
		}
		$this->echoJson();
	}
	//发送回复消息
	public function replyToPreId(Request $request){
		if($this->member){
			if($request->input('content')!=''){
				$reply=$request->input('reply');
				$message=ModelMessages::where(['sendto'=>$this->member->email])
					->where(['id'=>$reply])
					->orwhere(['sendto'=>$this->member->cellphone])
					->where(['id'=>$reply])
					->orwhere(['sendfrom'=>$this->member->email])
					->where(['id'=>$reply])
					->orwhere(['sendfrom'=>$this->member->cellphone])
					->where(['id'=>$reply])
					->first();
				if($message){
					if($this->member->cellphone!=''){
						$sendFrom=$this->member->cellphone;
					}else{
						$sendFrom=$this->member->email;
					}
					if($message['sendfrom']==$this->member->email || $message['sendfrom']==$this->member->cellphone){
						$sendTo=$message['sendto'];
					}else{
						$sendTo=$message['sendfrom'];
					}
					$message=array(
						"reply"=>$request->input('reply'),
						"content"=>$request->input('content'),
						'sendfrom'=>$sendFrom,
						'sendto'=>$sendTo
					);
					$sendMessage=ModelMessages::create($message);
					$sendMessage['sender']=$this->getSenderAndReciver($sendFrom);
					$sendMessage['receiver']=$this->getSenderAndReciver($sendTo);
					$sendMessage['mine']=$sendMessage['sender']['nickname']==auth('member')->member->nickname?true:false;
					ModelMessages::where(['id'=>$request->input('reply')])->update(['receiver_del'=>0,'sender_del'=>0]);
					$this->json=array('status'=>true,'success'=>'消息发送成功！','data'=>$sendMessage);
				}else{
					$this->json=array('status'=>false,'error'=>'消息不存在！');
				}
			}else{
				$this->json=array('status'=>false,'error'=>'消息内容不能为空！');
			}
		}else{
			$this->json=array('status'=>false,'error'=>'用户尚未登录！');
		}
		$this->echoJson();
	}
	//发送消息给老师
	public function sendMessageToTeacher(Request $request){
		if($this->member){
			if($request->input('content')!=null && $request->input('teacher_id')!=null ){
				if($this->member->cellphone!=''){
					$sendFrom=$this->member->cellphone;
				}elseif($this->member->email!=''){
					$sendFrom=$this->member->email;
				}else{
					$this->json=array('status'=>false,'error'=>'请完善个人手机和邮箱信息！');
				}
				if(!$this->json){
					$message=array(
						"content"=>$request->input('content'),
						'sendfrom'=>$sendFrom,
						'sendto'=>$request->input('teacher_id')
					);
					$message=$sendMessage=ModelMessages::create($message);
					$this->json=array('status'=>true,'success'=>'消息发送成功！','data'=>$message);
				}
			}else{
				if($request->input('content')==null){
					$this->json=array('status'=>false,'error'=>'内容不能为空！');
				}else{
					$this->json=array('status'=>false,'error'=>'请选择老师！');
				}
			}
		}else{
			$this->json=array('status'=>false,'error'=>'用户尚未登录！');
		}
		$this->echoJson();
	}
	//删除消息
	public function deleteMessage(Request $request){
		$inputs=$request->all();
		$rules=array(
				'id'=>'required|exists:messages,id'
		);
		$check=Validator::make($inputs,$rules);
		if($check->passes()){
			//判断用户是接收方还是发送方
			$receiver=ModelMessages::where(['sendto'=>$this->member->email,'id'=>$inputs['id'],'receiver_del'=>0])
				->orwhere(['sendto'=>$this->member->cellphone,'id'=>$inputs['id'],'receiver_del'=>0])
				->first();
			$sender=ModelMessages::where(['sendfrom'=>$this->member->email,'id'=>$inputs['id'],'sender_del'=>0])
				->orwhere(['sendfrom'=>$this->member->cellphone,'id'=>$inputs['id'],'sender_del'=>0])
				->first();
			if($receiver){
				ModelMessages::where(['id'=>$inputs['id']])->update(['receiver_del'=>1,'receiver_read'=>1]);
				//改变消息阅读状态
				ModelMessages::where(['sendto'=>$this->member->email])
					->where(['reply'=>$inputs['id']])
					->orwhere(['sendto'=>$this->member->cellphone])
					->where(['reply'=>$inputs['id']])
					->update(['receiver_read'=>1]);
				$this->json=array('status'=>true,'success'=>'删除成功！');
			}else if($sender){
				ModelMessages::where(['id'=>$inputs['id']])->update(['sender_del'=>1]);
				//改变消息阅读状态
				ModelMessages::where(['sendto'=>$this->member->email])
					->where(['reply'=>$inputs['id']])
					->orwhere(['sendto'=>$this->member->cellphone])
					->where(['reply'=>$inputs['id']])
					->update(['receiver_read'=>1]);
				$this->json=array('status'=>true,'success'=>'删除成功！');
			}else{
				$this->json=array('status'=>false,'error'=>'您无权删除该消息！');
			}
		}else{
			$this->json=array('status'=>false,'error'=>'数据不存在！');
		}
		$this->echoJson();
	}
	//根据发送方和接收获取会员，管理人员，系统的信息
	private function getSenderAndReciver($sr){
		$column=MemberFunction::checkUsernameType($sr);
		if($sr=='system'){
			$sr=array(
					'nickname'=>"系统",
					'avatar'=>'files/avatar/default_avatar.jpg'
			);
		}elseif($column!='undefined'){
			$sr=Members::where([$column=>$sr])->first(['nickname','avatar']);
			if(!$sr){
				$sr=array(
						'nickname'=>"未知会员",
						'avatar'=>'files/avatar/default_avatar.jpg'
				);
			}else{
				$sr=$sr->toArray();
			}
		}else{
			$sr=User::where(['id'=>$sr])->first(['name as nickname','avatar']);
			if(!$sr){
				$sr=array(
						'nickname'=>"未知管理",
						'avatar'=>'files/avatar/default_avatar.jpg'
				);
			}else{
				$sr=$sr->toArray();
			}
		}
		$sr['avatar']=$sr['avatar']?url($sr['avatar']):url('files/avatar/default_avatar.jpg');
		return $sr;
	}
	// 校验图形验证码  防止恶意短信接口调用
	private function checkCaptcha($request) {
		$captchaCheck = Validator::make($request->all(),[
			'captcha' => 'required|captcha'
		]);
		if ($captchaCheck->passes()) {
			return true;
		}else {
			return false;
		}
	}
}

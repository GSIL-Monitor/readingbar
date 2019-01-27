<?php
namespace Readingbar\Back\Controllers\Messages;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use Readingbar\Back\Models\Messages;
use Readingbar\Back\Controllers\BackController;
use Readingbar\Back\Models\Students;
class MessagesBoxController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'messagesBox.head_title','url'=>'admin/messagesBox','active'=>true),
	);
	private $receiver=null;
	public function __construct(){
		$this->receiver=Auth::user();
	}
	/*收件箱*/
	public function index(){
		$data['head_title']=trans('messagesBox.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		return $this->view('messages.messagesBox', $data);
	}
	/*收件箱-消息查看与回复*/
	public function messageDetail($id){
		$data['head_title']=trans('messagesBox.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$data['pre_id']=$id;
		return $this->view('messages.messagesBoxDetail', $data);
	}
	/*------------------API--------------------------*/
	/*获取收件箱消息*/
	public function getMessages(Request $request){
		if($request->input('limit') && $request->input('limit')>=1){
			$limit=(int)$request->input('limit');
		}else{
			$limit=10;
		}
		//查询当前用户相关数据
	    $messages=Messages::leftjoin('users',function($join){
						$join->on('users.id','=','messages.sendto')->orOn('users.id','=','messages.sendfrom');
					})->
					leftjoin('members',function($join){
						$join->on('members.email','=','messages.sendto')
						->orOn('members.cellphone','=','messages.sendto')
						->orOn('members.email','=','messages.sendfrom')
						->orOn('members.cellphone','=','messages.sendfrom');
					})
					->where(['sendto'=>$this->receiver->id,'receiver_del'=>0])
					->whereNull('reply')
					->orwhere(['sendfrom'=>$this->receiver->id,'sender_del'=>0])
					->whereNull('reply')
					->orderBy('messages.created_at','desc')
					->select(['messages.*',
							'users.name as user_name',
							'users.avatar as user_avatar',
							'members.nickname as member_name',
							'members.avatar as member_avatar'])
					->paginate($limit)
					->toArray();
		//设置发送人信息+未读信息数
		foreach ($messages['data'] as $k=>$m){
			if($m['sendfrom']=='system'){
				$messages['data'][$k]['sender_name']='系统';
			}else
			if($m['sendfrom']==$this->receiver->id){
				$messages['data'][$k]['sender_name']=$m['user_name'];
			}else{
				$messages['data'][$k]['sender_name']=$m['member_name'];
			}
			$star_accounts=Students::join('members','members.id','=','students.parent_id')
				->join('star_account as sa','sa.asign_to','=','students.id')
				->where(['members.email'=>$m['sendfrom']])
				->orwhere(['members.cellphone'=>$m['sendfrom']])
				->get(['sa.star_account'])
				->toArray();
			$messages['data'][$k]['star_accounts']=$star_accounts;
			$messages['data'][$k]['unread']=$this->getUnreadMessages($m['id']);
		}
		$this->json=$messages;
		$this->json['status']=true;
		return $this->echoJson();
	}
	/*获取消息内容*/
	public function getMessageDetail(Request $request){
		if($request->input('limit') && $request->input('limit')>=1){
			$limit=(int)$request->input('limit');
		}else{
			$limit=10;
		}
		$pre_id=(int)$request->input('pre_id');
		//查询当前用户相关数据
		$messages=Messages::leftjoin('users',function($join){
						$join->on('users.id','=','messages.sendto')->orOn('users.id','=','messages.sendfrom');
					})->
					leftjoin('members',function($join){
						$join->on('members.email','=','messages.sendto')
						->orOn('members.cellphone','=','messages.sendto')
						->orOn('members.email','=','messages.sendfrom')
						->orOn('members.cellphone','=','messages.sendfrom');
					})
					->where(['reply'=>$pre_id,'receiver_del'=>0])
					->orwhere(['messages.id'=>$pre_id])
					->orderBy('created_at','asc')
					->select(['messages.*',
							'users.name as user_name',
							'users.avatar as user_avatar',
							'members.nickname as member_name',
							'members.avatar as member_avatar'])
					->paginate($limit);
		
		$this->setHasRedMessage($pre_id);
		$this->json=$messages->toArray();
		$this->json['status']=true;
		//设置发送人信息和头像
		foreach ($this->json['data'] as $k=>$v){
			if($v['sendfrom']=='system'){
				$this->json['data'][$k]['sender_name']='系统';
				$this->json['data'][$k]['sender_avatar']=url('files/avatar/default_avatar.jpg');
			}else
			if($v['sendfrom']==$this->receiver->id){
				$this->json['data'][$k]['sender_name']=$v['user_name'];
				$this->json['data'][$k]['sender_avatar']=$v['user_avatar']?url($v['user_avatar']):url('files/avatar/default_avatar.jpg');
			}else{
				$this->json['data'][$k]['sender_name']=$v['member_name'];
				$this->json['data'][$k]['sender_avatar']=$v['member_avatar']?url($v['member_avatar']):url('files/avatar/default_avatar.jpg');
			}
	    }
		return $this->echoJson();
	}
	//删除消息
	public function deleteMessages(Request $request){
		if($request->input('selected') && is_array($request->input('selected'))){
			Messages::where(['sendto'=>$this->receiver->id])->whereIn('id',$request->input('selected'))->update(['receiver_del'=>1,'receiver_read'=>1]);
			Messages::where(['sendto'=>$this->receiver->id])->whereIn('reply',$request->input('selected'))->update(['receiver_read'=>1]);
			Messages::where(['sendfrom'=>$this->receiver->id])->whereIn('id',$request->input('selected'))->update(['sender_del'=>1]);
			$this->json=array('status'=>true,'success'=>'删除成功！');
		}else{
			$this->json=array('status'=>false,'error'=>'请选择要删除的数据！');
		}
		return $this->echoJson();
	}
	//回复消息
	public function replyMessage(Request $request){
		$message=Messages::where(['id'=>$request->input('pre_id')])->first();
		if($message && $request->input('content')){
			$m['sendfrom']=$this->receiver->id;
			$message['sendfrom']==$this->receiver->id?$m['sendto']=$message['sendto']:$m['sendto']=$message['sendfrom'];
			$m['content']=$request->input('content');
			$m['reply']=$request->input('pre_id');
			Messages::create($m);
			$this->json=array('status'=>true,'success'=>'回复成功！');
		}else{
			if(!$message){
				$this->json=array('status'=>false,'error'=>'消息不存在！');
			}else{
				$this->json=array('status'=>false,'error'=>'回复内容不能为空！');
			}
		}
		return $this->echoJson();
	}
	//标记已读
	public function hasRedMessages(Request $request) {
		if($request->input('selected') && is_array($request->input('selected'))){
			Messages::where(['sendto'=>$this->receiver->id])->whereIn('id',$request->input('selected'))->update(['receiver_read'=>1]);
			Messages::where(['sendto'=>$this->receiver->id])->whereIn('reply',$request->input('selected'))->update(['receiver_read'=>1]);
			$this->json=array('status'=>true,'success'=>'已标记！');
		}else{
			$this->json=array('status'=>false,'error'=>'请选择要标记的数据！');
		}
		return $this->echoJson();
	}
	/*------------------function--------------------*/
	/*获取未读消息数*/
	private function getUnreadMessages($pre_id=null){
		if($pre_id){
			return Messages::where(['sendto'=>$this->receiver->id,'id'=>$pre_id,'receiver_read'=>0])
				->orwhere(['sendto'=>$this->receiver->id,'reply'=>$pre_id,'receiver_read'=>0])
				->count();
		}else{
			return Messages::where(['sendto'=>$this->receiver->id,'receiver_read'=>0])->count();
		}
	}
	/*设置消息为已读*/
	private function setHasRedMessage($pre_id){
		Messages::where(['sendto'=>$this->receiver->id,'id'=>$pre_id])
				->orwhere(['sendto'=>$this->receiver->id,'reply'=>$pre_id])
			    ->update(['receiver_read'=>1]);
	}
}
?>
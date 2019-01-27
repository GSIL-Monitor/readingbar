<?php

namespace Readingbar\Front\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use Readingbar\Api\Frontend\Models\ReadPlan;
use Readingbar\Api\Frontend\Models\Students;

class MessagesController extends FrontController
{
	/*我的消息选择*/
	public function index(){
		$data['head_title']='我的消息';
		return $this->view('messages.index',$data);
	}
	/*收件箱*/
	public function messagesBox(){
		$data['head_title']='收件箱';
		return $this->view('messages.messagesBox',$data);
	}
	/*消息详情*/
	public function messageDetail($id){
		$data['head_title']='消息详情';
		$data['message_id']=$id;
		return $this->view('messages.messageDetail',$data);
	}
	/*我要留言*/
	public function leaveMessage(){
		$data['head_title']='我要留言';
		return $this->view('messages.leaveMessage',$data);
	}
}

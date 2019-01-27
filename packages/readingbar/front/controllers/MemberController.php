<?php

namespace Readingbar\Front\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use Readingbar\Api\Frontend\Models\Students;
use Readingbar\Api\Frontend\Models\StarReport;
use Readingbar\Api\Frontend\Models\Orders;
use Readingbar\Api\Frontend\Models\Promotions;
use QrCode;
class MemberController extends FrontController
{
	/*个人信息首页*/
	public function index(Request $request){
		return  $this->baseinfo($request);
// 		$data['head_title']='个人信息首页';
// 		return $this->view('member.dashboard',$data);
	}
	/*基础信息*/
	public function baseinfo(Request $request){
		$data['head_title']='基础信息';
		$data['message']=session('message');
		$data['member']=array(
				'nickname'=>auth('member')->member->nickname,
				'email'=>auth('member')->member->email,
				'cellphone'=>auth('member')->member->cellphone,
				'address'=>auth('member')->member->address,
		);
		//判断用户是否是推广员
		$promoter=Promotions::where(['member_id'=>auth('member')->getId()])->first();
		if($promoter){
			$promote_url=url('register?pcode='.$promoter->pcode);
			if(!file_exists(public_path('files/qrcodes'))) mkdir(public_path('files/qrcodes'));
			$dir='files/qrcodes/qrcode_'.$promoter->pcode.'_200x200.png';
			if(!file_exists(public_path($dir))){
				QrCode::format('png')->size(200)->generate($promote_url,public_path($dir));
			}
			$data['promote_qrcode']=url($dir);
			$data['promote_url']=$promote_url;
		}
		return $this->view('member.baseinfo',$data);
	}
	/*完善信息*/
	public function baseinfoForm(Request $request){
		$data['head_title']='完善信息';
		$data['message']=session('message');
		$data['member']=array(
				'nickname'=>auth('member')->member->nickname,
				'email'=>auth('member')->member->email,
				'cellphone'=>auth('member')->member->cellphone,
				'address'=>auth('member')->member->address,
		);
		return $this->view('member.baseinfoForm',$data);
	}
	/*修改密码*/
	public function passwordForm(Request $request){
		$data['head_title']='修改密码';
		return $this->view('member.passwordForm',$data);
	}
	/*修改邮箱*/
	public function emailForm(Request $request){
		$data['head_title']='修改邮箱';
		return $this->view('member.emailForm',$data);
	}
	/*修改手机*/
	public function phoneForm(Request $request){
		$data['head_title']='修改手机';
		return $this->view('member.phoneForm',$data);
	}
	/*安全问答*/
	public function qaForm(Request $request){
		$data['head_title']='安全问答';
		return $this->view('member.qaForm',$data);
	}
	/*孩子信息*/
	public function children(Request $request){
		$data['head_title']='孩子信息';
		return $this->view('member.children',$data);
	}
	/*孩子基础信息*/
	public function childrenBaseinfo($id,Request $request){
		$data['head_title']='孩子基础信息';
		$student=Students::where(['id'=>$id,'parent_id'=>auth('member')->getId()])->first();
		if(!$student){
			return redirect()->back()->with(['alert'=>'孩子信息不存在！']);
		}
		$student=$student->toArray();
		
		$student['favorite']=unserialize($student['favorite']);
		$student['age']=(int)date("Y",time())-(int)date('Y',strtotime($student['dob']));
		$data['student']=$student;
		$data['starReportTimes']=StarReport::where(['student_id'=>$student['id']])->count();
		return $this->view('member.childrenBaseinfo',$data);
	}
	/*孩子信息编辑表单*/
	public function childrenForm(Request $request,$id=null){
		$data['head_title']='孩子信息编辑表单';
		$student=Students::where(['id'=>$id])->first();
		if($student){
			$student['favorite']=unserialize($student['favorite']);
			$data['student']=$student;
		}else{
			$data['student']=null;
		}
		$columns=array('name','nick_name','sex','dob','grade','school_name','favorite','province','city','area','address');
		foreach ($columns as $k){
			if(old($k)){
				$data['student'][$k]=old($k);
			}
		}
		return $this->view('member.childrenForm',$data);
	}
	/*个人中心-设置*/
	public function memberSetting(){
		$data['head_title']='设置';
		if(session('theme')=='mobile'){
			return $this->view('member.setting',$data);
		}else{
			return redirect('member');
		}
	}
}

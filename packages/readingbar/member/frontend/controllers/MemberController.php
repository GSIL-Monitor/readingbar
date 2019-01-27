<?php

namespace Readingbar\Member\Frontend\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Readingbar\Member\Frontend\Models\members;
use Validator;
use App;
use Readingbar\Account\Frontend\Services\Account;
use Illuminate\Support\Facades\Auth;
use Readingbar\Member\Frontend\Models\Active;
use Messages;
class MemberController extends Controller
{
	public function index(){
		$data['nickname']=Auth::guard('member')->getFiled('nickname');
		return view("Readingbar/member/frontend::member.index",$data);
	}
	public function editView($edit_type='info'){
		$data['member']=Auth::guard('member')->member();
		$data['edit_type']=$edit_type;
		return view("Readingbar/member/frontend::member.edit_".$edit_type,$data);
	}
	public function editAction(Request $request){
		switch($request->input('edit_type')){
			case 'info':return $this->edit_info($request);break;
			case 'avatar':return $this->edit_avatar($request);break;
			case 'password':return $this->edit_password($request);break;
			case 'qa':return $this->edit_qa($request);break;
			case 'email':return $this->edit_email($request);break;
			case 'cellphone':return $this->edit_cellphone($request);break;
		}
	}
	public function edit_info($request){
		$id=Auth::guard('member')->getId();
		$check=Validator::make($request->all()
				,[
					'nickname'=>'required|min:2|unique:members,nickname,id'.$id
				]);
		if($check->fails()){
			return redirect('member/edit/'.$request->input('edit_type'))
					->withErrors($check)
					->withInput();
		}
		$member=array(
			'nickname'=>$request->input('nickname')
		);
		Members::where(['id'=>$id])->update($member);
		Auth::guard('member')->reflush();
		return redirect('member');
	}
	public function edit_avatar($request){
		$id=Auth::guard('member')->getId();
		$check=Validator::make($request->all()
				,[
					'avatar'=>'required'
				]);
		if($check->fails()){
			return redirect('member/edit/'.$request->input('edit_type'))
			->withErrors($check)
			->withInput();
		}
		$member=array(
				'avatar'=>$request->input('avatar')
		);
		Members::where(['id'=>$id])->update($member);
		Auth::guard('member')->reflush();
		return redirect('member');
	}
	public function edit_password($request){
		$id=Auth::guard('member')->getId();
		$check=Validator::make($request->all()
				,[
					'password'=>'required|min:6|confirmed'
				]);
		if($check->fails()){
			return redirect('member/edit/'.$request->input('edit_type'))
			->withErrors($check)
			->withInput();
		}
		$member=array(
				'password'=>bcrypt($request->input('password'))
		);	
		Members::where(['id'=>$id])->update($member);
		Auth::guard('member')->reflush();
		return redirect('member');
	}
	public function edit_qa($request){
		$id=Auth::guard('member')->getId();
		$check=Validator::make($request->all()
				,[
					'question'=>'required|min:6',
					'answer'=>'required|min:6'
				]);
		if($check->fails()){
			return redirect('member/edit/'.$request->input('edit_type'))
			->withErrors($check)
			->withInput();
		}
		$member=array(
				'question'=>$request->input('question'),
				'answer'=>$request->input('answer'),
		);
		Members::where(['id'=>$id])->update($member);
		Auth::guard('member')->reflush();
		return redirect('member');
	}
	public function edit_email($request){
		$id=Auth::guard('member')->getId();
		$check=Validator::make($request->all()
				,[
					'email'=>'required|email|unique:members,email,'.$id.',id'
				]);
		if($check->fails()){
			return redirect('member/edit/'.$request->input('edit_type'))
			->withErrors($check)
			->withInput();
		}
		$member=array(
			'email'=>$request->input('email')
		);
		session(['edit_member'=>$member]);
		$this->send_active();
		return redirect('member/active');
	}
	public function edit_cellphone($request){
		$id=Auth::guard('member')->getId();
		$check=Validator::make($request->all()
				,[
					'cellphone'=>'required|regex:/^[1][358][0-9]{9}$/|unique:members,cellphone,'.$id.',id'
				]);
		if($check->fails()){
			return redirect('member/edit/'.$request->input('edit_type'))
			->withErrors($check)
			->withInput();
		}
		$member=array(
				'cellphone'=>$request->input('cellphone')
		);
		session(['edit_member'=>$member]);
		$this->send_active();
		return redirect('member/active');
	}
	public function check_active_view(){
		return view("Readingbar/member/frontend::member.check_active");
	}
	public function check_active_action(Request $request){
		$member=session('edit_member');
		$id=Auth::guard('member')->getId();
		if(isset($member['email'])){
			$m['email']=$member['email'];		
		}else if(isset($member['cellphone'])){
			$m['cellphone']=$member['cellphone'];
		}else{
			return redirect('member');
		}
		$check=Validator::make(
		[
			'active_code'=>(int)$request->input('active_code'),
			'r_code'	=>$member['r_code']
		], [
			'active_code' => 'required|numeric|same:r_code'
		]);
		if($check->fails()){
			return redirect('member/active')
			->withErrors($check)
			->withInput();
		}
		Members::where(['id'=>$id])->update($m);
		//假设用户登录的时候就是email登录 而修改的也是email  所以做登出操作
		Auth::guard('member')->logout();
		return redirect('member');
	}
	public function send_active(){
		$member=session('edit_member');
		$member['r_code']=rand(10000,999999);
		if(isset($member['email'])){
			Messages::sendMessage($member['email'],trans('common.Verification_Code'),$member['r_code'],'email');
			echo json_encode(array('msg'=>trans('member.activecode_send_success')));
		}else if(isset($member['cellphone'])){
			Messages::sendMessage($member['cellphone'],trans('common.Verification_Code'),$member['r_code'],'sms');
			echo json_encode(array('msg'=>trans('member.activecode_send_success')));
		}else{
			echo json_encode(array('msg'=>trans('member.activecode_send_failed')));
		}
		session(['edit_member'=>$member]);
	}
}
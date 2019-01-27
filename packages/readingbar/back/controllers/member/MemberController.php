<?php
namespace Readingbar\Back\Controllers\Member;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use Readingbar\Back\Controllers\BackController;
use Validator;
use Readingbar\Back\Models\Members;
use Readingbar\Back\Models\Orders;
use DB;
use Readingbar\Back\Models\District;
class MemberController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'members.head_title','url'=>'admin/members','active'=>true),
	);
	/**
	 * 会员列表
	 */
	public function membersList(Request $request){
		$data['head_title']=trans('members.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$data['areas']=District::where(['rank'=>1])->whereNotIn('id',[710000,810000,820000])->get(['id','name'])->toJson();
		return $this->view('member.membersIndex', $data);
	}
	/**
	 * 会员表单
	 */
	public function memberForm($id){
		$data['head_title']=trans('members.head_title');
	   	$data['breadcrumbs']=$this->breadcrumbs;
   		if($id){
   			$data['action']="admin/api/members/update";
   			$data['members']=members::where('id','=',$id)->first();
   		}
		return $this->view('member.fm', $data);
	}
	/**
	 * 会员列表数据
	 * @param Request $request
	 */
	public function getMembers(Request $request){
		if((int)$request->input('limit')){
			$limit=(int)$request->input('limit');
		}else{
			$limit=10;
		}
		if($request->input('sort') && in_array($request->input('sort'),['desc','asc'])){
			$sort=(int)$request->input('sort');
		}else{
			$sort='desc';
		}
		if($request->input('order') && in_array($request->input('order'),['id','created_at'])){
			if(in_array($request->input('order'),['id','created_at'])){
				$order='members.'.$request->input('order');
			}
		}else{
			$order='members.created_at';
		}
		if($request->input('status') && in_array($request->input('status'),['0','1'])){
			$status=(int)$request->input('status');
		}else{
			$status='1';
		}
		$rs=Members::leftjoin('students as s','s.parent_id','=','members.id');
		
		if($request->input('fromDate')){
			$rs=$rs->where('members.created_at','>',$request->input('fromDate'));
		}
		if($request->input('toDate')){
			$rs=$rs->where('members.created_at','<',date('Y-m-d',strtotime($request->input('toDate'))+60*60*24));
		}
		
		if($request->input('pcode')){
			$rs=$rs->where('members.pcode','=',$request->input('pcode'));
		}
		if($request->input('cellphone')){
			$rs=$rs->where('members.cellphone','like',$request->input('cellphone').'%');
		}
		if($request->input('email')){
			$rs=$rs->where('members.email','like',$request->input('email').'%');
		}
		if($request->input('area')){
			$rs=$rs->where('s.province','=',$request->input('area'));
		}
		
		$rs=$rs->selectRaw('distinct members.*,count(s.id)')
				->orderBy($order,$sort)
				->groupBy('members.id')
		       	->paginate($limit);
		foreach ($rs as $k => $v){
			$rs[$k]['avatar']=$v['avatar']?url($v['avatar']):url('files/avatar/default_avatar.jpg');
			$rs[$k]['editurl']=url('admin/members/'.$v['id'].'/edit');
			$rs[$k]['deleteurl']=url('admin/members/'.$v['id'].'/delete');
			
		}
		return $rs;
	}
	public function update(Request $request){
		$columns=array('cellphone','email','nickname','password','question','answer','remember_token','actived');
		$id=(int)$request->input('id');
		$validator = Validator::make($request->all(), [
				'id'	=>'required|in:memberses,id,'.$id,
				'nickname'=>'required|min:2|unique:members,nickname,'.$id.',id',
				'cellphone'=>'required|regex:/^[1][358][0-9]{9}$/|unique:members,cellphone,'.$id.',id',
				'email'	   =>'required|email|unique:members,email,'.$id.',id'
		]);
		if ($validator->fails()) {
			return redirect("admin/members/$id/edit")
			->withErrors($validator)
			->withInput();
		}else{
			//执行
			//密码校验
			$password=Validator::make(
					[
							'password'=>$request->input('password'),
							'password_confirmation'=>$request->input('password_confirmation'),
							'required'=>$request->input('password'),
					]
					, [
							'required'	=>'required',
							'password'	=>'min:6|confirmed'
					]);
			//判断用户是否填写了password
			if(!$password->errors()->has('required')){ //是
				//验证密码是否符合规范
				if($password->errors()->has('password')){//否
					return redirect("admin/members/$id/edit")
					->withErrors($password)
					->withInput();
				}
				$members=array();
				foreach ($columns as $column){
					switch ($column){
						case 'password':$members[$column]=bcrypt($request->input($column));break;
						default:$members[$column]=$request->input($column);
					}
				}
			}else{//否
				$members=array();
				foreach ($columns as $column){
					switch ($column){
						case 'password':;break;
						default:$members[$column]=$request->input($column);
					}
				}
			}
	
			members::where("id","=",$id)->update($members);
			$request->session()->flash('success', trans("common.operate_success"));
			return redirect('admin/members');
		}
		 
	}
	public function getLineChart(Request $request){
		$p=$this->lineChartOfPayMembers($request);
		$r=$this->lineChartOfRegisterMembers($request);
		//$data['x']="x";
		$data['columns'][]=collect($r->toArray())->pluck('lable')->prepend('x')->all();
		$data['columns'][]=collect($r->toArray())->pluck('data')->prepend('注册信息')->all();
		$data['columns'][]=collect($p->toArray())->pluck('data')->prepend('报名信息')->all();
		return $data;
	}
	/**
	 * 会员注册折线图信息
	 * @param Request $request
	 */
	public function lineChartOfRegisterMembers(Request $request){
		switch($request->input('type')){
			case 'year':$dateFormat="%Y";$minDate='2016';break;
			case 'month':$dateFormat="%Y-%m";$minDate='2016-10';break;
			case 'day':$dateFormat="%Y-%m-%d";$minDate='2016-11-01';break;
			default:return null;
		}
		$rs=Members::rightjoin('assitant_date as ad',DB::raw("DATE_FORMAT(members.created_at,'%Y-%m-%d')"),'=','ad.date');
		if($request->input('fromDate') || $request->input('toDate')){
			if($request->input('fromDate')){
				$rs=$rs->where('ad.date','>=',$request->input('fromDate'));
			}
			if($request->input('toDate')){
				$rs=$rs->where('ad.date','<=',$request->input('toDate'));
			}
		}else{
			switch($request->input('type')){
				case 'month':$dateFormat2="%Y";break;
				case 'day':$dateFormat2="%Y-%m";break;
			}
			if(isset($dateFormat2)){
				$rs=$rs->where(DB::raw("DATE_FORMAT(ad.date,'".$dateFormat2."')"),'=',DB::raw("DATE_FORMAT(CURRENT_DATE(),'".$dateFormat2."')"));
			}
		}
		$rs=$rs->selectRaw("DATE_FORMAT(ad.date,'".$dateFormat."') as lable,count(members.id) as data")
				->groupBy("lable")
				->having("lable",'<=',date('Y-m-d',time()))
				->having("lable",'>=',$minDate)
				->get();
		return $rs;
	}
	/**
	 * 会员付费折线图信息
	 * @param Request $request
	 */
	public function lineChartOfPayMembers(Request $request){
		// 选择检索格式
		switch($request->input('type')){
			case 'year':$dateFormat="%Y";$minDate='2016';break;
			case 'month':$dateFormat="%Y-%m";$minDate='2016-10';break;
			case 'day':$dateFormat="%Y-%m-%d";$minDate='2016-11-01';break;
			default:return null;
		}
		$rs = Members::leftjoin('students as s','s.parent_id','=','members.id')
					->leftjoin('orders as o','o.owner_id','=','s.id')
					->rightjoin('assitant_date as ad',DB::raw("DATE_FORMAT(o.completed_at,'%Y-%m-%d')"),'=','ad.date')
					->where(function($where) use($request){
						if($request->input('fromDate') || $request->input('toDate')){
							if($request->input('fromDate')){
								$where->where('ad.date','>=',$request->input('fromDate'));
							}
							if($request->input('toDate')){
								$where->where('ad.date','<=',date('Y-m-d',strtotime($request->input('toDate'))+60*60*24));
							}
						}else{
							switch($request->input('type')){
								case 'month':$dateFormat2="%Y";break;
								case 'day':$dateFormat2="%Y-%m";break;
								default:return null;
							}
							if(isset($dateFormat2)){
								$where->where(DB::raw("DATE_FORMAT(ad.date,'".$dateFormat2."')"),'=',DB::raw("DATE_FORMAT(CURRENT_DATE(),'".$dateFormat2."')"));
							}
						}
					})
					->groupBy("lable")
					->having("lable",'<=',date('Y-m-d',time()))
					->having("lable",'>=',$minDate)
					->selectRaw("DATE_FORMAT(ad.date,'".$dateFormat."') as lable,count(distinct IF(o.status=1,members.id,null)) as data")
					->get();
		return $rs;
	}
}
?>
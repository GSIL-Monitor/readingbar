<?php
namespace Readingbar\Back\Controllers\Spoint;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use Readingbar\Back\Controllers\BackController;
use Validator;
use Readingbar\Back\Models\PointProduct;
use Illuminate\Support\Facades\Schema;
use Readingbar\Back\Models\DiscountType;
use Readingbar\Back\Models\PPC;
use Storage;
use Readingbar\Back\Models\Point;
use Readingbar\Back\Models\Products;
use Readingbar\Back\Models\PointLog;
use Readingbar\Back\Models\PointStatus;
use Readingbar\Back\Models\PointMonth;
use DB;
use Readingbar\Back\Models\Students;
class PointLogController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'PointLog.head_title','url'=>'admin/PointLog','active'=>true),
	);
	/*管理首页*/
	public function viewList(){
		$data['head_title']=trans('PointLog.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$data['OPmsg']=collect(session('OPmsg')?session('OPmsg'):array())->toJson();
		$data['points']=Point::where(['get_rule'=>'give_by_admin','status'=>1,'del'=>0])->get();
		return $this->view('spoint.PointLogList', $data);
	}
	/*新增*/
	public function create(Request $request){
		$rules=[
				'name'=>'required|unique:s_point,name',
				'point'=>'required|integer',
				'get_rule'=>'required|in:'.implode(',',collect(trans('Point.form.get_rules'))->keys()->all()),
				'status'	=>'required|in:0,1'
		];
		if($request->input('get_rule')=='buy_product'){
			$rules['get_rule_products']='required|array';
		}
		$messages=trans('Point.messages');
		$attributes=trans('Point.attributes');
		$check=Validator::make($request->all(),$rules,$messages,$attributes);
		if($check->passes()){
			$create=array(
					'name'=>$request->input('name'),
					'point'=>$request->input('point'),
					'get_rule'=>$request->input('get_rule'),
					'status'=>$request->input('status'),
					'get_rule_products'=>serialize($request->input('get_rule_products')?$request->input('get_rule_products'):array()),
			);
			Point::create($create);
			return redirect('admin/PointManage')->with(['OPmsg'=>array('status'=>true,'success'=>'创建成功!')])->withInput();
		}else{
			return redirect()->back()->withErrors($check)->withInput();
		}
	}
	/*查询*/
	public function getList(Request $request){
		$rs=PointLog::crossjoin('students as s','s.id','=','s_point_log.student_id')
		->crossjoin('members as m','m.id','=','s.parent_id')
		->crossjoin('s_point_status as sps','sps.student_id','=','s.id')
		->leftjoin('star_account as sa','sa.asign_to','=','s.id')
		->where(function($where) use($request){
			if($request->input('keyword')){
				switch($request->input('type')){
					case 'member':$where->where(['m.nickname'=>$request->input('keyword')]);break;
					case 'student':$where->where(['s.nick_name'=>$request->input('keyword')]);break;
					case 'starAccount':$where->where('sa.star_account','like','%'.$request->input('keyword').'%');break;
				}
			}
		})
		->orderBy(in_array($request->input('order'),Schema::getColumnListing('s_point_log'))?$request->input('order'):'s_point_log.created_at',in_array($request->input('sort'),['asc','desc'])?$request->input('sort'):'desc')
		->select(['s_point_log.*','m.nickname as member','s.nick_name as student','sps.point as student_point','sa.star_account'])
		->paginate($request->input('limit')?$request->input('limit'):10);
		foreach ($rs as $k=>$v){
			$rs[$k]['status_text']=trans('PointLog.status.'.$v->status);
		}
		return $rs;
	}
	public function getById(Request $request){
		$ppc= Point::where(['id'=>$request->input('id'),'del'=>0])->first();
		if($ppc){
			return array('status'=>true,'data'=>$ppc);
		}else{
			return '找不到数据！';
		}
	}
	/*获取学生*/
	public function getStudents(Request $request){
	$inputs=$request->all();
		$rules=[
				'search_type'=>'required|in:member,student',
				'search_value'=>"required"
		];
		$messages=[
				'search_value.required'=>'请输入检索内容'
		];
		$check=Validator::make($inputs,$rules,$messages);
		if($check->passes()){
			switch($request->input('search_type')){
				case 'member':
					$students=Students::leftJoin('members as m','m.id','=','students.parent_id')
						->where(function($where) use($request){
							$where->where(['cellphone'=>$request->input('search_value')])
										->orWhere(['email'=>$request->input('search_value')]);
						})
						->where(['students.del'=>0])
						->get(['students.*']);
						break;
				case 'student':
						$students=Students::leftJoin('star_account as sa','sa.asign_to','=','students.id')
						->where(['star_account'=>$request->input('search_value')])
						->where(['students.del'=>0])
						->get(['students.*']);
				break;
			}
			$return = array('status'=>true,'data'=>$students->toArray());
		}else{
			$return = array('status'=>false,'error'=>$check->errors()->first());
		}
		return $return;
	}
	/*给学生积分*/
	public function giveStudentPoint(Request $request){
		$inputs=$request->all();
		$rules=[
				'point_id'=>'required|exists:s_point,id,status,1,del,0,get_rule,give_by_admin',
				'student_id'=>"required|exists:students,id",
				'point'=>"required|integer"
		];
		$messages=[
				'point_id.required'=>'请选择要授予的积分',
				'point_id.exists'=>'积分不存在',
				'student_id.required'=>'请选择学生',
				'student_id.exists'=>'学生不存在',
				'point.required'=>'请输入要授予的积分数量',
				'point.integer'=>'请输入数字',
		];
		$check=Validator::make($inputs,$rules);
		if($check->passes()){
			PointController::increaceByRule([
					'rule'			=>'give_by_admin',
					'point_id'		=>$request->input('point_id'),
					'student_id'=>$request->input('student_id'),
					'point'			=>$request->input('point'),
					'memo'		=>$request->input('memo')
			]);
			$return = array('status'=>true,'success'=>'已授予');
		}else{
			$return = array('status'=>false,'error'=>$check->errors()->first());
		}
		return $return;
	}
	/*撤回积分日志项*/
	public  function retract(Request $request){
		$inputs=$request->all();
		$rules=[
				'id'=>'required|exists:s_point_log,id',
		];
		$messages=[
				'id.required'=>'请选择要撤回的积分记录',
				'id.exists'=>'积分不存在',
		];
		$check=Validator::make($inputs,$rules,$messages);
		if($check->passes()){
			$pl=PointLog::where(['id'=>$request->input('id')])->first();
			PointLog::where(['id'=>$request->input('id')])->update(['status'=>1]);
			DB::select('call updatePointForStudent('.$pl->student_id.')');
			$return = array('status'=>true,'success'=>'已撤回');
		}else{
			$return = array('status'=>false,'error'=>$check->errors()->first());
		}
		return $return;
	}
}
?>
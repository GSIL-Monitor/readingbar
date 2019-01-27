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
use Readingbar\Back\Models\PromotionsType;
use DB;
class PointController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'Point.head_title','url'=>'admin/PointManage','active'=>true),
	);
	/*管理首页*/
	public function viewList(){
		$data['head_title']=trans('Point.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$data['OPmsg']=collect(session('OPmsg')?session('OPmsg'):array())->toJson();
		return $this->view('spoint.PointManageList', $data);
	}
	/*表单*/
	public function viewForm(Request $request){
		$data['head_title']=trans('Point.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		if($request->input('id')){
			$return=$this->getById($request);
			if($return['status']){
				$return['data']['get_rule_products']=unserialize($return['data']['get_rule_products']);
				$return['data']['get_rule_promotions_types']=unserialize($return['data']['get_rule_promotions_types']);
				$data['editObj']=collect($return['data'])->toJson();
			}else{
				return redirect()->back()->with(['OPmsg'=>$return]);
			}
			$data['action']=url('admin/PointManage/update');
		}else{
			$data['action']=url('admin/PointManage/create');
			$data['editObj']=collect([
					'get_rule'=>'give_by_admin',
					'get_rule_products'=>array(),
					'get_rule_promotions_types'=>array(),
					'status'=>0
			])->toJson();
		}
		if(old()){
			$old=old();
			if(!isset($old['get_rule_products'])){
				$old['get_rule_products']=array();
			}
			$data['editObj']=collect($old)->toJson();
		}
		$data['cancel']=url('admin/PointManage');
		$data['products']=Products::get(['id','product_name']);
		$data['get_rules']=trans('Point.form.get_rules');
		$data['get_rule_promotions_types']=PromotionsType::get(['id','name']);
		return $this->view('spoint.PointManageForm', $data);
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
		if(in_array($request->input('get_rule'),['promote_new_member','create_first_child_tp'])){
			$rules['get_rule_promotions_types']='required|array';
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
					'get_rule_promotions_types'	=>serialize($request->input('get_rule_promotions_types'))
			);
			Point::create($create);
			return redirect('admin/PointManage')->with(['OPmsg'=>array('status'=>true,'success'=>'创建成功!')])->withInput();
		}else{
			return redirect()->back()->withErrors($check)->withInput();
		}
	}
	/*删除*/
	public function delete(Request $request){
		if($request->input('selected')!=null){
			$selected=$request->input('selected');
			if(is_array($selected)){
				Point::wherein('id',$selected)->update(['del'=>1]);
			}else{
				Point::where(['id'=>$selected])->update(['del'=>1]);
			}
			return array('status'=>true,'success'=>'删除成功！');
		}else{
			return array('status'=>false,'error'=>'请选择要删除的数据！');
		}
	}
	/*更改*/
	public function update(Request $request){
		$rules=[
				'id'		=>'required|exists:s_point,id,del,0',
				'name'=>'required|unique:s_point,name,'.$request->input('id').',id',
				'point'=>'required|integer',
				'get_rule'=>'required|in:'.implode(',',collect(trans('Point.form.get_rules'))->keys()->all()),
				'status'	=>'required|in:0,1'
		];
		if($request->input('get_rule')=='buy_product'){
			$rules['get_rule_products']='required|array';
		}
		if(in_array($request->input('get_rule'),['promote_new_member','create_first_child_tp'])){
			$rules['get_rule_promotions_types']='required|array';
		}
		$messages=trans('Point.messages');
		$attributes=trans('Point.attributes');
		$check=Validator::make($request->all(),$rules,$messages,$attributes);
		if($check->passes()){
			$update=array(
					'name'=>$request->input('name'),
					'point'=>$request->input('point'),
					'get_rule'=>$request->input('get_rule'),
					'status'=>$request->input('status'),
					'get_rule_products'=>serialize($request->input('get_rule_products')?$request->input('get_rule_products'):array()),
					'get_rule_promotions_types'	=>serialize($request->input('get_rule_promotions_types'))
			);
			Point::where(['id'=>$request->input('id')])->update($update);
			return redirect('admin/PointManage')->with(['OPmsg'=>array('status'=>true,'success'=>'数据已保存!')])->withInput();
		}else{
			return redirect()->back()->withErrors($check)->withInput();
		}
	}
	/*查询*/
	public function getList(Request $request){
		$rs=Point::where(function($where) use($request){
			$where->where('name','like','%'.$request->input('keyword').'%');
		})
		->where(['del'=>0])
		->orderBy(in_array($request->input('order'),Schema::getColumnListing('s_point'))?$request->input('order'):'id',in_array($request->input('sort'),['asc','desc'])?$request->input('sort'):'asc')
		->paginate($request->input('limit')?$request->input('limit'):10);
		
		foreach ($rs as $k=>$v){
			$rs[$k]['edit']=url('admin/PointManage/form?id='.$v->id);
			$rs[$k]['status_text']=trans('Point.list.status.'.$v->status);
			$rs[$k]['get_rule_text']=trans('Point.list.get_rules.'.$v->get_rule);
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
	/****获取规则函数****/
	/**
	 * 根据规则给予积分
	 * @param unknown $param
	 * @param string $debug
	 */
	static function increaceByRule($param,$debug=false){
		if(self::checkParam($param, $debug)){
			foreach (self::getPointsByRule($param, $debug) as $p){
				if(self::checkPointByRule($p, $param, $debug)){
					$plog=[
							'point'=>$p['point'],
							'student_id'=>$param['student_id'],
							'memo'=>$p['name'],
							'point_id'=>$p['id']
					];
					if(isset($param['point'])){
						$plog['point']=$param['point'];
					}
					if(isset($param['memo'])){
						$plog['memo']=$plog['memo'].':'.$param['memo'];
					}
					//插入记录
					PointLog::create($plog);
					//统计记录信息
					DB::select('call updatePointForStudent('.$param['student_id'].')');
				}
			}
		}
	}
	//校验参数
	static function checkParam($param,$debug){
		$rules=[
				'rule'=>'required|in:'.implode(',',collect(trans('Point.form.get_rules'))->keys()->all()),
				'student_id'=>'required|exists:students,id',
				'point'=>'integer'
		];
		switch($param['rule']){
			case 'create_first_child_tm':
				$rules['member_id']='required|exists:members,id';
			break;
			
			case 'create_first_child_tp':
				$rules['member_id']='required|exists:members,id';
				$rules['promotions_type']='required|exists:promotions_type,id';
			break;
			
			case 'buy_product':
				$rules['product_id']='required|exists:products,id';
			break;
			
			case 'give_by_admin':
				$rules['point_id']='required|exists:s_point,id,status,1,del,0';
			break;
			
			case 'give_by_admin':
				$rules['promotions_type']='required|exists:promotions_type,id';
			break;
		}
		$check=Validator::make($param,$rules);
		if(!$check->passes() && $debug){
			dd($check->errors());
		}
		return $check->passes();
	}
	//根据规则查询要插入的积分项
	static function getPointsByRule($param,$debug){
			switch($param['rule']){
				case 'buy_product':
					$ps=Point::where(['get_rule'=>$param['rule'],'status'=>1,'del'=>0])->get()->toArray();
					foreach ($ps as $k=>$v){
						if(!in_array($param['product_id'],unserialize($v['get_rule_products']))){
							unset($ps[$k]);
						}
					}
					break;
				case 'give_by_admin':
					$ps=Point::where(['get_rule'=>$param['rule'],'status'=>1,'del'=>0,'id'=>$param['point_id']])->get()->toArray();
					break;
				case 'create_first_child_tp':;
				case 'promote_new_member':
					$ps=Point::where(['get_rule'=>$param['rule'],'status'=>1,'del'=>0])->get()->toArray();
					foreach ($ps as $k=>$v){
						if(!in_array($param['promotions_type'],unserialize($v['get_rule_promotions_types']))){
							unset($ps[$k]);
						}
					}
				break;
				default:$ps=Point::where(['get_rule'=>$param['rule'],'status'=>1,'del'=>0])->get()->toArray();
			}
			if($debug){
				echo "检索出要插入的Point项：<br>";
				var_dump($ps);
			}
			return $ps;
	}
	//校验规则
	static function checkPointByRule($p,$param,$debug){
		switch ($param['rule']){
			case 'login_every_day':
				$count=PointLog::where(['student_id'=>$param['student_id'],'point_id'=>$p['id']])->where('created_at','like',date("Y-m-d",time()).'%')->count();
				$r=!$count;
				break;
			case 'create_first_child_tp':;
			case 'create_first_child_tm':
				$count=DB::table('students as s')->where(['s.parent_id'=>$param['member_id']])->count();
				$r=$count==1;
				break;
			default:
				$r=true;
		}
		if($debug){
			echo '<br>规则校验:规则 '.$param['rule'].'返回'.($r?'true':'false').'<br>';
		}
		return $r;
	}
}
?>
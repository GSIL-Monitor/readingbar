<?php
namespace Readingbar\Front\Controllers\ReadPlan;
use Readingbar\Front\Controllers\FrontController;
use Readingbar\Back\Models\Students;
use Validator;
use Illuminate\Http\Request;
use Readingbar\Back\Models\ReadPlan;
use Readingbar\Back\Models\KuaidiniaoExpress;
class BorrowServiceController extends FrontController{
	private $students;
	public function __construct(){
		$this->getChildren();
	}
	public function index(){
		$data['head_title']='借阅书单';
		$data['students']=$this->students;
		return $this->view('readPlan.borrowServicePlans',$data);
	}
	/**
	 * 获取借阅服务的计划
	 */
	public function getPlans(Request $request) {
		$check = Validator::make($request->all(),[
			'student_id'=>'required|exists:students,id,parent_id,'.auth('member')->id()	
		]);
		if ($check->passes()) {
			$rps=ReadPlan::where(['for'=>$request->input('student_id')])->whereIn('type',[1,2])->orderBy('id','desc')->paginate($request->input('limit')>0?$request->input('limit'):10);
			foreach ($rps as $k=>$v){
				$v->detail = url('borrowService/myBooks/'.$request->input('student_id').'/'.$v->id.'/detail');
			}
			return array('status'=>true,'data'=>$rps);
		}else {
			return array('status'=>false,'error'=>$check->errors()->first());
		}
	}
	/**
	 * 计划详情
	 */
	public function detail($sid,$pid){
		$check=Validator::make(
			[
					'sid'=>$sid,
					'pid'=>$pid
			],		
			[
					'sid'=>'required|exists:students,id,parent_id,'.auth('member')->id()	,
					'pid'=>'required|exists:read_plan,id,for,'.$sid
			]
		);
		if ($check->passes()){
			$data['head_title']="借阅计划";
			$data['readPlan'] = ReadPlan::where(['id'=>$pid])->first();
			$data['readPlan']['express_1']=KuaidiniaoExpress::crossjoin('kdniao_express_code','express_code','=','shipper_code')->where(['plan_id'=>$data['readPlan']['id'],'type'=>1])->first();
			$data['readPlan']['express_2']=KuaidiniaoExpress::crossjoin('kdniao_express_code','express_code','=','shipper_code')->where(['plan_id'=>$data['readPlan']['id'],'type'=>2])->first();
			$data['readPlan']['details']= $data['readPlan']->books();
			return $this->view('readPlan.borrowServiceDetail',$data);
		}else{
			
		}
	}
	/**
	 * 判断会员底下是否有书单
	 */
	public function checkHasBooks(){
		
	}
	/**
	 * 获取当前孩子的所有孩子
	 */
	public function getChildren() {
		$this->students = Students::where(['parent_id'=>auth('member')->id(),'del'=>0])->get()->each(function($item, $key) {
			$item['avatar'] = url($item['avatar']);
			return $item;
		});
	}
}
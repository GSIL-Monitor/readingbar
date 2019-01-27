<?php

namespace Readingbar\Back\Controllers\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Readingbar\Back\Controllers\BackController;
use Auth;
use DB;
use Readingbar\Back\Models\Students;
class BoughtLogController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'boughtLog.head_title','url'=>'admin/boughtLog','active'=>true),
	);
	public function index($id) {
		$data['head_title']=trans('boughtLog.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$data['id']=$id;
		$data['OPmsg']=collect(session('OPmsg')?session('OPmsg'):array())->toJson();
		return $this->view('teacher.boughtLog', $data);
	}
	public function getLog(Request $request,$id){
		if (!$this->checkId($id)){
			return ['status'=>false,'error'=>'您无权查看该孩子的信息'];
		}
		$data=DB::table('orders as o')
			->crossjoin('students as s','s.id','=','o.owner_id')
			->crossjoin('members as m','m.id','=','s.parent_id')
			->crossjoin('products as p','p.id','=','o.product_id')
			->leftJoin('star_account as sa','sa.asign_to','=','s.id')
			->where(['o.status'=>1,'s.id'=>$id])
			->select(['m.nickname as parent','m.email','m.cellphone','s.nick_name as student','o.*','p.product_name','sa.star_account'])
			->orderBy($this->asignColumn($request->input('order')),$request->input('sort')=='desc'?$request->input('sort'):'asc')
			->paginate($request->input('limit')>0?$request->input('limit'):10);
		foreach ($data as $d){
			$d->refunds=DB::table('orders as o')
			->where(['refund_oid'=>$d->id])
			->groupBy('o.order_type')
			->get([DB::raw('sum(total) as total'),'o.order_type']);
		}
		return $data;
	}
	public function asignColumn($c){
		$order='o.id';
		$table=array(
				'o'=>['completed_at','order_id','id'],
				's'=>['nick_name'],
				'm'=>['nickame','cellphone','email'],
				'p'=>['product_name']
		);
		foreach ($table as $k=>$v){
			if(in_array($c,$v)){
				$order=$k.".".$c;
			}
		}
		return $order;
	}
	// 判断数据所属
	public function checkId($id){
		$s=Students::leftjoin('student_group as sg','sg.id','=','students.group_id')
			->where(['students.id'=>$id,'sg.user_id'=>auth()->id()])
			->count();
		if($s){
			return true;
		}else {
			return false;
		}
	}
}
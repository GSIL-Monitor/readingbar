<?php
namespace Readingbar\Back\Controllers\Express;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use Readingbar\Back\Controllers\BackController;
use Validator;
use Readingbar\Back\Models\Orders;
use DB;
use Readingbar\Back\Models\KuaidiniaoExpress;
use Readingbar\Back\Models\kdniaoExpressCode;
use Readingbar\Back\Models\ReadPlan;
use Readingbar\Front\Controllers\Kdniao\KdniaoController;
class ExpressController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'orders.head_title','url'=>'admin/orders','active'=>true),
	);
	public function orderIndex($id,Request $request) {
		if ($request->ajax()){
			return [
					'status'=>true,
					'data'=>KuaidiniaoExpress::where(['order_id'=>$id])->get()->each(function($item){
						$item->deletedStatus = false;
					})
			];
		}else{
			$data['breadcrumbs']=$this->breadcrumbs;
			$data['order']=Orders::where(['id'=>$id])->first();
			$data['express_companies'] = kdniaoExpressCode::get();
			$data['data'] = KuaidiniaoExpress::where(['order_id'=>$id])->get()->each(function($item){
				$item->deletedStatus = false;
			});
			return $this->view('express.orderExpressList', $data);
		}
	}
	public function planIndex($id,Request $request) {
		if ($request->ajax()){
			return [
					'status'=>true,
					'data'=>KuaidiniaoExpress::where(['plan_id'=>$id])->get()->each(function($item){
						$item->deletedStatus = false;
					})
					];
		}else{
			$data['breadcrumbs']=$this->breadcrumbs;
			$data['plan']=ReadPlan::where(['id'=>$id])->first();
			$data['express_companies'] = kdniaoExpressCode::get();
			$data['data'] = KuaidiniaoExpress::where(['order_id'=>$id])->get()->each(function($item){
				$item->deletedStatus = false;
			});
			return $this->view('express.planExpressList', $data);
		}
	}
	public function storeOrder (Request $request) {
		$check = validator($request->all(),[
				'order_id'=>'required',
				'sender'=>'required',
				'receiver'=>'required',
				'type'=>'required|in:1,2',
				'logistic_code'=>'required',
				'shipper_code'=>'required',
				'cost'=>'required'
		]);
		if ($check->passes()) {
			$k=KuaidiniaoExpress::create([
				'order_id'=>$request->input('order_id'),
				'sender'=>$request->input('sender'),
				'receiver'=>$request->input('receiver'),
				'type'=>$request->input('type'),
				'logistic_code'=>$request->input('logistic_code'),
				'shipper_code'=>$request->input('shipper_code'),
				'cost'=>$request->input('cost'),
				'memo'=>$request->input('memo')
			]);
			return [
					'status'=>true,
					'message'=>'数据已保存！'
			];
		}else{
			return [
					'status'=>false,
					'error'=>$check->errors()->first()
			];
		}
	}
	public function storePlan (Request $request) {
		$check = validator($request->all(),[
				'plan_id'=>'required',
				'sender'=>'required',
				'receiver'=>'required',
				'type'=>'required|in:1,2',
				'logistic_code'=>'required',
				'shipper_code'=>'required',
				'cost'=>'required'
		]);
		if ($check->passes()) {
			if (KuaidiniaoExpress::where(['plan_id'=>$request->input('plan_id'),'type'=>$request->input('type')])->count()) {
				$k=KuaidiniaoExpress::where(['plan_id'=>$request->input('plan_id'),'type'=>$request->input('type')])->update([
						'plan_id'=>$request->input('plan_id'),
						'sender'=>$request->input('sender'),
						'receiver'=>$request->input('receiver'),
						'type'=>$request->input('type'),
						'logistic_code'=>$request->input('logistic_code'),
						'shipper_code'=>$request->input('shipper_code'),
						'cost'=>$request->input('cost'),
						'status'=>0,
						'memo'=>$request->input('memo')
				]);
			}else{
				$k=KuaidiniaoExpress::create([
						'plan_id'=>$request->input('plan_id'),
						'sender'=>$request->input('sender'),
						'receiver'=>$request->input('receiver'),
						'type'=>$request->input('type'),
						'logistic_code'=>$request->input('logistic_code'),
						'shipper_code'=>$request->input('shipper_code'),
						'cost'=>$request->input('cost'),
						'status'=>0,
						'memo'=>$request->input('memo')
				]);
			}
			return [
					'status'=>true,
					'message'=>'数据已保存！'
			];
		}else{
			return [
					'status'=>false,
					'error'=>$check->errors()->first()
			];
		}
	}
	public function deleteOrder (Request $request) {
		$check = validator($request->all(),[
				'id'=>'required|exists:kuaidiniao_express,id,order_id,'.$request->input('order_id'),
		]);
		if ($check->passes()) {
			KuaidiniaoExpress::where(['id'=>$request->input('id')])->delete();
			return [
					'status'=>true,
					'message'=>'数据已删除！'
			];
		}else{
			return [
					'status'=>false,
					'error'=>$check->errors()->first()
			];
		}
	}
	
	public function getTraces($id) {
		// state 物流状态: 0-无轨迹，1-已揽收，2-在途中，3-签收,4-问题件
		$express = KuaidiniaoExpress::where(['id'=>$id])->first();
		if ($express) {
			switch($express->status){
				case 0:
					if($express->logistic_code && $express->shipper_code){
						$KD=json_decode((new KdniaoController())->getOrderTracesByJson($express->shipper_code, $express->logistic_code));
						$express->traces = serialize($KD);
						$express->status = $KD->State;
					}
					KuaidiniaoExpress::where(['id'=>$id])->update([
							'traces'=>$express->traces,
							'status'=>$express->status
					]);
					return collect(unserialize($express->traces))->all();
				case 1:
				case 2:
					if($express->logistic_code && $express->shipper_code){ 
						if(!$express->traces){
							$KD=json_decode((new KdniaoController())->getOrderTracesByJson($express->shipper_code, $express->logistic_code));
							$express->traces = serialize($KD);
							$express->status = $KD->State;
						}else{
							$KD=unserialize($express->traces);
							$newest=collect($KD->Traces)->last();
							if(!isset($newest) || time()-strtotime($newest->AcceptTime)>60*60*2){
								$KD=json_decode((new KdniaoController())->getOrderTracesByJson($express->shipper_code, $express->logistic_code));
								$express->traces = serialize($KD);
								$express->status = $KD->State;
							}
						}
						KuaidiniaoExpress::where(['id'=>$id])->update([
								'traces'=>$express->traces,
								'status'=>$express->status
						]);
						return collect(unserialize($express->traces))->all();
					}
					break;
				case 3:
					return collect(unserialize($express->traces))->all();
					break;
				case 4:
					return collect(unserialize($express->traces))->all();
					break;
				case 5:
					return response('该物流记录数据不全或有误，不可查看！');
					break;
				default:  return response('该物流状态不存在！',400);
			}
		}else{
			return response('记录不存在！',400);
		}
	}
	/**
	 * 家长查询借阅计划的物流信息
	 * @param unknown $id
	 */
	public function getTracesByMember ($id) {
		$express = KuaidiniaoExpress::where(['id'=>$id])->whereIn('plan_id',function($query){
			$query->select('read_plan.id')->from('read_plan')
						->crossjoin('students','read_plan.for','=','students.id')
						->where(['students.parent_id'=>auth('member')->user()->id]);
		})
		->first();
		if ($express) {
			return $this->getTraces($id);
		}else{
			return response('记录不存在！',400);
		}
	}
}
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
use Readingbar\Back\Models\PointOrder;
use Readingbar\Back\Models\PointStatus;
use Readingbar\Back\Models\PointMonth;
use DB;
use Readingbar\Back\Models\Students;
use Readingbar\Front\Controllers\Kdniao\KdniaoController;
use Readingbar\Back\Models\PointOrderProduct;
class PointOrderController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'PointOrder.head_title','url'=>'admin/PointOrder','active'=>true),
	);
	/*管理首页*/
	public function viewList(){
		$data['head_title']=trans('PointOrder.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$data['OPmsg']=collect(session('OPmsg')?session('OPmsg'):array())->toJson();
		$data['status']=trans('PointOrder.list.status');
		return $this->view('spoint.PointOrderList', $data);
	}
	/*表单*/
	public function viewForm(Request $request){
		$data['head_title']=trans('ppc.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		if($request->input('id')){
			$return=$this->getById($request);
			if($return['status']){
				$data['editObj']=collect($return['data'])->toJson();
			}else{
				return redirect()->back()->with(['OPmsg'=>$return]);
			}
			$data['action']=url('admin/PointOrder/update');
		}else{
			$data['editObj']=collect(array('type'=>0,'type_v'=>''))->toJson();;
			$data['action']=url('admin/PointOrder/create');
		}
		if(old()){
			$data['editObj']=collect(old())->toJson();
		}
		$data['cancel']=url('admin/PointOrder');
		$data['ShipperCode']=DB::table('kdniao_express_code')->get();
		
		return $this->view('spoint.PointOrderForm', $data);
	}
	/*查询*/
	public function getList(Request $request){
		$rs=PointOrder::leftjoin('students','students.id','=','s_point_order.student_id')
		->leftjoin('members','students.parent_id','=','members.id')
		->where(function($where) use($request){
			if($request->input('keyword')){
				$where->orwhere('s_point_order.order_id','like','%'.$request->input('keyword').'%');
				$where->orwhere('members.nickname','like','%'.$request->input('keyword').'%');
				$where->orwhere('students.nick_name','like','%'.$request->input('keyword').'%');
			}
			if($request->input('status')){
				$where->where(['s_point_order.status'=>$request->input('status')]);
			}
		})
		->orderBy($this->assignColumn($request->input('order')),in_array($request->input('sort'),['asc','desc'])?$request->input('sort'):'desc')
		->select(['s_point_order.*','members.nickname as member','students.nick_name as student'])
		->paginate($request->input('limit')?$request->input('limit'):10);
		foreach ($rs as $k=>$v){
			if($v->status==2 && $KD=$this->getKDNiao($v)){
				if($KD->State==3){
					$v->status=3;
				}
			}
			$rs[$k]['edit']=url('admin/PointOrder/form?id='.$v->id);
			$rs[$k]['status_text']=trans("PointOrder.list.status.".$v->status);
		}
		return $rs;
	}
	/**
	 * 更新
	 */
	public function update(Request $request){
		$rules=[
				'id'=>'required|exists:s_point_order,id',
				'tel'=>'required',
				'address'=>'required',
				'reciver'=>'required',
				'status'=>'required|in:0,1,2,3'
		];
		if($this->checkLogisticOrder($request->input('id'))){
			$rules['LogisticCode']='required';
			$rules['ShipperCode']='required';
		}
		$messages=trans('PointOrder.messages');
		$attributes=trans('PointOrder.attributes');
		$check=Validator::make($request->all(),$rules,$messages,$attributes);
		if($check->passes()){
			$update=array(
					'tel'=>$request->input('tel'),
					'reciver'=>$request->input('reciver'),
					'address'=>$request->input('address'),
					'LogisticCode'=>$request->input('LogisticCode'),
					'ShipperCode'=>$request->input('ShipperCode'),
					'status'=>$request->input('status')
			);
			PointOrder::where(['id'=>$request->input('id')])->update($update);
			return redirect('admin/PointOrder')->with(['OPmsg'=>array('status'=>true,'success'=>'更新成功!')])->withInput();
		}else{
			return redirect()->back()->withErrors($check)->withInput();
		}
	}
	public function getById(Request $request){
		$PointOrder= PointOrder::leftjoin('students','students.id','=','s_point_order.student_id')
								->leftjoin('members','students.parent_id','=','members.id')
								->where(['s_point_order.id'=>$request->input('id')])
								->first(['s_point_order.*','members.nickname as member','students.nick_name as student']);
		$PointOrder->product=PointOrder::leftjoin('s_point_order_product','s_point_order.id','=','s_point_order_product.order_id')
								->where(['s_point_order.id'=>$request->input('id')])
								->get(['s_point_order_product.*'])->toArray();
		if($KD=$this->getKDNiao($PointOrder)){
			$PointOrder->Traces=collect($KD->Traces)->last();
		}
		if($PointOrder){
			return array('status'=>true,'data'=>$PointOrder);
		}else{
			return '找不到数据！';
		}
	}
	/*获取快递鸟数据*/
	public function getKDNiao($order){
		if($order->LogisticCode && $order->ShipperCode){
			if(!$order->Traces){
				$KD=json_decode((new KdniaoController())->getOrderTracesByJson($order->ShipperCode, $order->LogisticCode));
				PointOrder::where(['id'=>$order->id])->update(['Traces'=>serialize($KD)]);
			}else{
				$KD=unserialize($order->Traces);
				if($KD->State!=3){
					$newest=collect($KD->Traces)->last();
					if(!isset($newest) || time()-strtotime($newest->AcceptTime)>60*60*2){
						$KD=json_decode((new KdniaoController())->getOrderTracesByJson($order->ShipperCode, $order->LogisticCode));
						PointOrder::where(['id'=>$order->id])->update(['Traces'=>serialize($KD)]);
					}
				}
			}
			if($KD->State==3){
				PointOrder::where(['id'=>$order->id])->update(['status'=>3]);
			}
			return $KD;
		}
		return false;
	}
	/*判断订单商品是否需要配送*/
	public function checkLogisticOrder($id){
		return PointOrderProduct::where(['type'=>0,'order_id'=>$id])->count();
	}
	/*字段分捡*/
	public function assignColumn($column){
		if($column){
			if(in_array($column,Schema::getColumnListing('s_point_order'))){
				return  's_point_order.'.$column;
			}else if(in_array($column,Schema::getColumnListing('members'))){
				return  'members.'.$column;
			}else if(in_array($column,Schema::getColumnListing('students'))){
				return  'students.'.$column;
			}else{
				return  's_point_order.id';
			}
		}else{
			return  's_point_order.id';
		}
	}
}
?>
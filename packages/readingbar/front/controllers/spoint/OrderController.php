<?php

namespace Readingbar\Front\Controllers\Spoint;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Readingbar\Front\Controllers\FrontController;
use App\Http\Requests;
use DB;
use Validator;
use Readingbar\Back\Models\PointStatus;
use Readingbar\Back\Models\PointProduct;
use Readingbar\Back\Models\PointOrder;
use Readingbar\Back\Models\Students;
use Readingbar\Back\Models\PointOrderProduct;
use Readingbar\Back\Models\Discount;
use Readingbar\Back\Controllers\Kdniao\KdniaoController;
use Readingbar\Back\Controllers\Spoint\PointOrderController;
class OrderController extends FrontController
{
	/*产品订单确认*/
	public function confirmProduct(Request $request){
		$data['head_title']='订单确认';
		$data['children']=$this->getChildren()->toJson();
		$product=PointProduct::where(['id'=>$request->input('product_id')])->first();
		if($product && $request->input('quantity')>=1){
			$data['products']=collect(array([
					'product_id'=>$product->id,
					'point'=>$product->point,
					'product_name'=>$product->product_name,
					'image'=>url($product->image),
					'desc'=>$product->desc,
					'type'=>$product->type,
					'type_v'=>$product->type_v,
					'quantity'=>$product->quantity>=$request->input('quantity')?$request->input('quantity'):$product->quantity,
					'stock_quantity'=>$product->quantity
			]))->toJson();
			return $this->view('spoint.confirmOrder',$data);
		}else{
			return  back()->with(['alert'=>'请选择商品或者商品已售完！']);
		}
	}
	/*购物车订单确认*/
	public function confirmCart(){
		$data['head_title']='订单确认';
		$data['children']=$this->getChildren()->toJson();
		$cart=new ShoppingCartController();
		$data['products']=collect($cart->getCart()['products'])->filter(function($item){
			return $item['pay_status'];
		})->toJson();
		return $this->view('spoint.confirmOrder',$data);
	}
	/*支付-购物车*/
	public function payCart(Request $request){
		$inputs=$request->all();
		$rules=[
				'student_id' =>'required|exists:students,id,parent_id,'.auth('member')->id(),
				'address'=>'required',
				'tel'=>'required',
				'reciver'=>'required'
		];
		$messages=trans('PointCart.messages');
		$check=Validator::make($inputs,$rules,$messages);
		if($check->passes()){
			$SCC=new ShoppingCartController();
			$cart=$SCC->getCart();
			//判断购物车是否有需要支付的商品
			if($cart['pay_total_product']){
				//获取学生信息
				$student=Students::leftjoin('s_point_status as sps','sps.student_id','=','students.id')
					->leftjoin('members as m','m.id','=','students.parent_id')
					->where(['students.id'=>$request->input('student_id')])
					->first(['students.*','m.cellphone','sps.point']);
				if($cart['pay_cart_status'] && $student->point >=$cart['total_points']){
					$order=PointOrder::create([
							'order_id'			=>$this->newOrderId(),
							'student_id'		=>$student->id,
							'total_points'	=>$cart['total_points'],
							'tel'					=>$request->input('tel'),
							'reciver'			=>$request->input('reciver'),
							'address'			=>$request->input('address'),
							'status'				=>0
					]);
					$poproducts=array();
					foreach($cart['products'] as $p){
						$np=PointProduct::where(['id'=>$p['product_id']])->first(['image']);
						if($p['pay_status']==1){
							$poproducts[]=[
									'order_id'=>$order->id,
									'product_id'=>$p['product_id'],
									'image'=>$np->image,
									'desc'=>$p['desc'],
									'point'=>$p['point'],
									'type'=>$p['type'],
									'type_v'=>$p['type_v'],
									'product_name'=>$p['product_name'],
									'quantity'=>$p['quantity']
							];
						}
					}
					PointOrderProduct::insert($poproducts);
					$r=DB::select('select f_reduce_point('.$order->student_id.','.$order->total_points.',"积分消费") as result');
					if($r && $r[0]->result==0){
						$SCC->clear();
						PointOrder::where(['id'=>$order->id])->update(['status'=>1]);
						foreach ($poproducts as $p){
							PointProduct::where(['id'=>$p['product_id']])->update(['quantity'=>DB::raw('quantity-'.$p['quantity'])]);
							switch($p['type']){
								//购买的积分商品是优惠券的话
								case 1:
									for ($i=1;$i<=$p['quantity'];$i++){
										Discount::giveByRule(auth('member')->id(), 'buy_discount_by_point',['product_id'=>$p['product_id']]);
									}
									break;
							}
						}
						/*判断订单是否需要实物配送*/
						if(!$this->checkLogisticOrder($order->id)){
							PointOrder::where(['id'=>$order->id])->update(['status'=>3]);
						}
						$return=array('status'=>true,'success'=>'支付完成');
					}else{
						$return=array('status'=>false,'error'=>'函数未执行');
					}
				}else{
					if(!$c1){
						$return=array('status'=>false,'error'=>'蕊丁币不足，赶快去赚吧~！');
					}else if(!$c2){
						$return=array('status'=>false,'error'=>'该产品数量不足！');
					}
				}
			}else{
				$return=array('status'=>false,'error'=>'请把商品加入购物车！');
			}
		}else{
			$return=array('status'=>false,'error'=>$check->error()->first());
		}
		return $return;
	}
	/*支付-单品*/
	public function payProduct(Request $request){
		$inputs=$request->all();
		$rules=[
				'product_id'=>'required|exists:s_point_product,id,status,1,del,0',
				'quantity'=>'required|integer|min:1',
				'student_id' =>'required|exists:students,id,parent_id,'.auth('member')->id(),
				'address'=>'required',
				'tel'=>'required',
				'reciver'=>'required',
		];
		$messages=trans('PointCart.messages');
		$check=Validator::make($inputs,$rules,$messages);
		if($check->passes()){
			//获取学生信息
			$student=Students::leftjoin('s_point_status as sps','sps.student_id','=','students.id')
											->leftjoin('members as m','m.id','=','students.parent_id')
											->where(['students.id'=>$request->input('student_id')])
											->first(['students.*','m.cellphone','sps.point']);
			//获取购买产品的信息
			$product=PointProduct::where(['id'=>$request->input('product_id')])->first();
			$c1=(int)$student->point>($product->point*$request->input('quantity'));
			$c2=$product->quantity>=$request->input('quantity');
			if($c1 && $c2){
				$order=PointOrder::create([
						'order_id'			=>$this->newOrderId(),
						'student_id'		=>$student->id,
						'total_points'	=>(int)$product->point*(int)$request->input('quantity'),
						'tel'					=>$request->input('tel'),
						'reciver'			=>$request->input('reciver'),
						'address'			=>$request->input('address'),
						'status'				=>0
				]);
				$poproduct=[
						'order_id'=>$order->id,
						'product_id'=>$product->id,
						'image'=>$product->image,
						'desc'=>$product->desc,
						'point'=>$product->point,
						'type'=>$product->type,
						'type_v'=>$product->type_v,
						'product_name'=>$product->product_name,
						'quantity'=>(int)$request->input('quantity'),
				];
				PointOrderProduct::create($poproduct);
				$r=DB::select('select f_reduce_point('.$order->student_id.','.$order->total_points.',"积分消费") as result');
				if($r && $r[0]->result==0){
					PointOrder::where(['id'=>$order->id])->update(['status'=>1]);
					PointProduct::where(['id'=>$product->id])->update(['quantity'=>DB::raw('quantity-'.(int)$request->input('quantity'))]);
					switch($product->type){
						//购买的积分商品是优惠券的话
						case 1:
							for ($i=1;$i<=(int)$request->input('quantity');$i++){
								Discount::giveByRule(auth('member')->id(), 'buy_discount_by_point',['product_id'=>$product->id]);
							}
							break;
					}
					/*判断订单是否需要实物配送*/
					if(!$this->checkLogisticOrder($order->id)){
						PointOrder::where(['id'=>$order->id])->update(['status'=>3]);
					}
					$return=array('status'=>true,'success'=>'支付完成');
				}else{
					$return=array('status'=>false,'error'=>'函数未执行:');
				}
			}else{
				if(!$c1){
					$return=array('status'=>false,'error'=>'积分不足！');
				}else if(!$c2){
					$return=array('status'=>false,'error'=>'该产品数量不足！');
				}
			}
		}else{
			$return=array('status'=>false,'error'=>$check->error()->first());
		}
		return $return ;
	}
	/*购物车订单完成界面*/
	public function completed(){
		$data['head_title']='订单完成支付';
		return $this->view('spoint.completedOrder',$data);
	}
	
	
	
	
	/*订单日志界面*/
	public function log(Request $request){
		$data['head_title']='我的订单';
		return $this->view('spoint.logOfOrders',$data);
	}
	/*获取订单列表*/
	public function getList(Request $request){
		$orders=DB::table('s_point_order as spo')
			->leftjoin('students as s','s.id','=','spo.student_id')
			->where(['s.parent_id'=>auth('member')->id(),'spo.del'=>0])
			->where(function($where) use($request){
				if($request->input('status')){
					$where->where(['spo.status'=>$request->input('status')]);
				}
			})
			->orderBy('spo.id','desc')
			->select(['spo.*','s.name'])
			->paginate($request->input('limit')?$request->input('limit'):10);
		$BPOC=new PointOrderController();
		foreach ($orders as $k=>$v){
			$KD=$BPOC->getKDNiao($v);
			if($KD && $KD->State==3){
				$v->status=3;
			}
			$v->products=DB::table('s_point_order_product as spop')
									->where(['order_id'=>$v->id])
									->get();
			foreach ($v->products as $k1=>$v1){
				$v->products[$k1]->image=url($v1->image);
			}
			$v->status_text=trans("PointOrder.list.status.".$v->status);
			$v->detail_url=url("member/spoint/order/detail/".$v->id);
		}
		return $orders;
	}
	/*删除订单*/
	public function delete(Request $request){
		$order=PointOrder::leftJoin('students','students.id','=','s_point_order.student_id')
			->where(['s_point_order.id'=>$request->input('oid'),'students.parent_id'=>auth('member')->id()])
			->first(['s_point_order.*']);
		if($order){
			PointOrder::where(['id'=>$order->id])->update(['del'=>1]);
			return array('status'=>true,'success'=>'数据已删除');
		}else{
			return array('status'=>false,'error'=>'数据不存在');
		}
		
	}
	/*获取订单详情*/
	public function detail($id){
		$data['head_title']='订单详情';
		$order=PointOrder::leftJoin('students','students.id','=','s_point_order.student_id')
					->leftjoin('kdniao_express_code','kdniao_express_code.express_code','=','s_point_order.ShipperCode')
					->where(['s_point_order.id'=>$id,'students.parent_id'=>auth('member')->id(),'s_point_order.del'=>0])
					->first(['s_point_order.*','kdniao_express_code.express_name']);
		if($order){
			$BPOC=new PointOrderController();
			$KD=$BPOC->getKDNiao($order);
			if($KD && $KD->State==3){
				$order->status=3;
				$order->Traces=collect($KD->Traces)->last();
			}else{
				$order->Traces='';
			}
			
			$order->LogisticStatus=$BPOC->checkLogisticOrder($order->id);
			$order->products=DB::table('s_point_order_product as spop')
											->where(['order_id'=>$order->id])
											->get();
			
			foreach ($order->products as $k=>$v){
				$v->image=url($v->image);
			}
			$order->status_text=trans("PointOrder.list.status.".$order->status);
			$data['order']=$order;
			return $this->view('spoint.detailOfOrder',$data);
		}else{
			return back()->with(['alert'=>'数据找不到，请确认再试！']);
		}
		
	}
	
	
	//获取关联孩子的积分信息
	public function getChildren(){
			$return=Students::crossjoin('s_point_status','s_point_status.student_id','=','students.id')
			->where(['students.parent_id'=>auth('member')->id(),'students.del'=>0])
			->get(['students.*','s_point_status.point',DB::raw("concat(students.province,students.city,students.area,students.address) as address")]);
			foreach ($return as $k=>$v){
				$return[$k]['avatar']=url($v->avatar);
			}
			return $return;
	}
	//生成订单号
	public function newOrderId(){
		$pre=date('YmdHis');
		do{
			$order_id=$pre.rand(100000,999999);
		}while(PointOrder::where(['order_id'=>$order_id])->first());
		return $order_id;
	}
	/*判断订单商品是否需要配送*/
	public function checkLogisticOrder($id){
		return PointOrderProduct::where(['type'=>0,'order_id'=>$id])->count();
	}
}

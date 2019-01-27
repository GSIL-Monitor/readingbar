<?php

namespace Readingbar\Front\Controllers\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Readingbar\Front\Controllers\FrontController;
use App\Http\Requests;
use Readingbar\Back\Models\Discount;
use DB;
use Readingbar\Back\Models\Products;
use Validator;
use Readingbar\Back\Models\CustomerIdea;
class CustomerIdeaController extends FrontController
{
	/*写点想法*/
	public function index(){
		$data['head_title']='写点想法';
		return $this->view('customer.customerIdeaIndex', $data);
	}
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'CustomerIdea.head_title','url'=>'admin/customer/idea','active'=>true),
	);
	/*新增*/
	public function create(Request $request){
		$rules=[
				'idea'=>'required'
		];
		$messages=trans('CustomerIdea.messages');
		$attributes=trans('CustomerIdea.attributes');
		$check=Validator::make($request->all(),$rules,$messages,$attributes);
		if($check->passes()){
			$create=array(
					'member_id'=>auth('member')->isLoged()?auth('member')->getId():0,
					'idea'=>$request->input('idea')
			);
			CustomerIdea::create($create);
			$return=array('status'=>true,'success'=>'想法已提交！');
		}else{
			$return=array('status'=>false,'error'=>$check->errors()->fist());
		}
		return $return;
	}
	public function getList(Request $request){
		$rs=CustomerIdea::leftjoin('members as m','m.id','=','customer_idea.member_id')
			->where(['del'=>0,'show_status'=>1])
			->select(['customer_idea.*',DB::raw('IF(customer_idea.member_id=0,"游客",m.nickname) as nickname')])
			->orderBy('customer_idea.id','desc')
			->paginate($request->input('limit')?$request->input('limit'):10);
		return $rs;
	}
}

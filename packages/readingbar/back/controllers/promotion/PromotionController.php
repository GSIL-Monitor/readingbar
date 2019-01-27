<?php
namespace Readingbar\Back\Controllers\Promotion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use Readingbar\Back\Controllers\BackController;
use Readingbar\Back\Models\Promotions;
use Readingbar\Back\Models\Members;
use Readingbar\Back\Models\Students;
use Readingbar\Back\Models\Orders;
use Readingbar\Back\Models\Products;
use Readingbar\Back\Models\PromotionsType;
use Validator;
use Excel;
class PromotionController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'promotion.head_title','url'=>'admin/promotion','active'=>true),
	);
	/*推广首页*/
	public function index(Request $request){
		$data['head_title']=trans('promotion.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		return $this->view('promotion.index', $data);
	}
	/*推广详情*/
	public function promotionInfo($pcode){
		$data['head_title']=trans('promotion.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$data['pcode']=$pcode;
		$data['dashboard']=json_encode($this->getDashboard($pcode));
		return $this->view('promotion.promotion_info', $data);
	}
	/*推广表单*/
	public function promotionEdit($id){
		$data['head_title']=trans('promotion.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$data['id']=$id;
		return $this->view('promotion.promotion_form', $data);
	}
	/*推广对象*/
	public function getPromotion(Request $request){
		$r=Promotions::leftjoin('members as m','promotions.member_id','=','m.id')
					   ->where(['promotions.id'=>$request->input('id')])
					   ->first(['promotions.*','m.nickname','m.cellphone','m.email']);
		return $r;
	}
	/*推广员列表*/
	public function getPromotions(Request $request){
		if($request->input('limit') && $request->input('limit')>0){
			$limit=(int)$request->input('limit');
		}else{
			$limit=10;
		}
		if($request->input('order') && in_array($request->input('order'),['id'])){
			$order=$request->input('order');
		}else{
			$order='promoters.id';
		}
		if($request->input('sort') && in_array($request->input('sort'),['asc','desc'])){
			$sort=$request->input('sort');
		}else{
			$sort='asc';
		}
		$ps=$this->getProducts()->toArray();
		$selectRaw=array(
			'promoters.*','promotions.pcode as pcode','prot.name as type','count(distinct pm.id) as members','promotions.id as pro_id'
		);
		foreach ($ps as $v){
			$selectRaw[]='count(IF(o.status=1 and p.id='.$v['id'].',1,null)) as product'.$v['id'];
		}
		$rs=Promotions::leftjoin('members as promoters','promoters.id','=','promotions.member_id')
				->leftjoin('members as pm','pm.pcode','=','promotions.pcode')
				->leftjoin('students as s','s.parent_id','=','pm.id')
				->leftjoin('orders as o','s.id','=','o.owner_id')
				->leftjoin('products as p','p.id','=','o.product_id')
				->leftjoin('promotions_type as prot','prot.id','=','promotions.type')
				->orderBy($order,$sort)
				->selectRaw(implode(',',$selectRaw))
				->groupBy('promoters.id')
				->paginate($limit);
		//获取关联会员数量
		foreach ($rs as $k=>$v){
			$rs[$k]['promotionInfo']=url('admin/promotion/'.$v['pcode'].'/promotionInfo');
			$rs[$k]['promotionEdit']=url('admin/promotion/'.$v['pro_id'].'/promotionEdit');
		}
		return $rs;
	}
	/**
	 * 获取会员
	 * @param Request $request
	 * @return unknown
	 */
	public function getMembers(Request $request){
		if($request->input('limit') && $request->input('limit')>0){
			$limit=(int)$request->input('limit');
		}else{
			$limit=10;
		}
		if($request->input('order') && in_array($request->input('order'),['id'])){
			$order=$request->input('order');
		}else{
			$order='members.id';
		}
		if($request->input('sort') && in_array($request->input('sort'),['asc','desc'])){
			$sort=$request->input('sort');
		}else{
			$sort='desc';
		}
		$rs=Members::leftjoin('promotions as pro','pro.pcode','=','members.pcode')
			     ->leftjoin('members as pm','pm.id','=','pro.member_id')
			     ->leftjoin('students as s','s.parent_id','=','members.id')
			     ->where(['members.pcode'=>$request->input('pcode')]);
		if($request->input('fromDate')){
			$rs=$rs->where('members.created_at','>',$request->input('fromDate'));
		}
		if($request->input('toDate')){
			$rs=$rs->where('members.created_at','<',date('Y-m-d',strtotime($request->input('toDate'))+60*60*24));
		}
		switch ($request->input('type')){
			case 'hc':$rs=$rs->havingRaw('count(s.id) > 0');break; //有孩子
			case 'nc':$rs=$rs->havingRaw('count(s.id) = 0');break; //无孩子
		}
		$rs=$rs->selectRaw('members.*,count(s.id) as children,pro.type')
			     ->orderBy($order,$sort)
			     ->groupBy('members.id')
			     ->paginate($limit);
		return $rs;
	}
	/**
	 * 获取订单
	 * @param Request $request
	 */
	public function getMOrders(Request $request){
		if($request->input('limit') && $request->input('limit')>0){
			$limit=(int)$request->input('limit');
		}else{
			$limit=10;
		}
		if($request->input('order') && in_array($request->input('order'),['id'])){
			$order=$request->input('order');
		}else{
			$order='orders.id';
		}
		if($request->input('sort') && in_array($request->input('sort'),['asc','desc'])){
			$sort=$request->input('sort');
		}else{
			$sort='asc';
		}
		$roids=Orders::where('order_type','=','2')->distinct()->get(['refund_oid'])->pluck('refund_oid');
		$rs=Orders::leftjoin('students as s','s.id','=','orders.owner_id')
					->leftjoin('products as p','p.id','=','orders.product_id')
					->leftjoin('members as m','s.parent_id','=','m.id')
					->leftjoin('promotions as pro','pro.pcode','=','m.pcode')
					->where(['m.pcode'=>$request->input('pcode')])
					->whereNotIn('orders.id',$roids)
					->distinct();
		if($request->input('fromDate')){
			$rs=$rs->where('orders.created_at','>',$request->input('fromDate'));
		}
		if($request->input('toDate')){
			$rs=$rs->where('orders.created_at','<',date('Y-m-d',strtotime($request->input('toDate'))+60*60*24));
		}
		switch ($request->input('type')){
			case 'hp':$rs=$rs->where(['orders.status'=>1]);break; //已付款
			case 'unp':$rs=$rs->where(['orders.status'=>0]);break; //未付款
		}
		$rs=$rs->selectRaw('orders.id,orders.owner_id,orders.product_id,orders.status,m.nickname,m.cellphone,m.email,s.name as child,s.province,p.product_name')
			->orderBy($order,$sort)
			->paginate($limit)
			->toArray();
		foreach ($rs['data'] as $key=>$o) {
			if ($o['status'] == 1) {
				$r=Orders::where('id','<',$o['id'])->where(
						[
								'owner_id' => $o['owner_id'],
								'product_id' =>   $o['product_id'],
								'status' => 1
						]
						)->first();
						if ($r) {
							$rs['data'][$key]['product_name'] = '续费+'.$o['product_name'];
						}
			}
		}
		return $rs;
	}
	/**
	 * 编辑推广员信息
	 * @param Request $request
	 */
	public function editPromotion(Request $request){
		$inputs=$request->all();
		$rules=array(
				'id'=>"required|exists:promotions,id",
				'type'=>"required|exists:promotions_type,id"
		);
		$check=Validator::make($inputs,$rules);
		if($check->passes()){
			$update=array(
					'type'=>$request->input('type')
			);
			Promotions::where(['id'=>$request->input('id')])->update($update);
			$json=array('status'=>true,'success'=>"数据保存成功！");
		}else{
			$json=array('status'=>false,'errors'=>$check->errors());
		}
		return $json;
	}
	/**
	 * 下载关联会员数据
	 */
	public function downloadExcel($pcode) {
		$m = Promotions::where(['promotions.pcode'=>$pcode])
			->leftjoin('members as m','m.pcode','=','promotions.pcode')
			->leftjoin('members as pm','pm.id','=','promotions.member_id')
			->distinct()
			->get(['m.nickname as member','m.cellphone','m.email','pm.nickname as promoter'])
			->toArray();
		$title = ['会员昵称','手机','邮箱','推广员'];
		$e = collect($m)->prepend($title)->all();
		ob_clean();
		Excel::create($pcode, function($excel) use($e)
		{
		    //创建sheet
		    $excel->sheet('sheet1',function($sheet)  use($e)
		    {
		            $sheet->rows($e);
		    });
		})->export('xls');
	}
	/**
	 * 获取面板数据
	 * @param unknown $pcode
	 * @return \Illuminate\Contracts\Routing\UrlGenerator|string
	 */
	public function getDashboard($pcode){
		$data['url']=url('register?pcode='.$pcode);
		$data['qrcode']=url('123');
		$data['members']=Members::leftjoin('students as s','s.parent_id','=','members.id')
						->where(['members.pcode'=>$pcode])
						->selectRaw('count(distinct members.id) as total,count(IF(s.id is null,1,null)) as nc_total,count(distinct members.id)-count(IF(s.id is null,1,null)) as hc_total')
						->first()
						->toArray();
		$data['orders'] =Orders::leftjoin('students as s','s.id','=','orders.owner_id')
								 ->leftjoin('members as m','m.id','=','s.parent_id')
								 ->where(['m.pcode'=>$pcode])
								 ->where('orders.total','>','10')
								 ->selectRaw('count(1) as total,count(IF(orders.status=1,1,null)) as hp_total,count(IF(orders.status=0,1,null)) as unp_total')
								 ->first()
								 ->toArray();
		return $data;
	}
	/**
	 * 获取产品
	 */
	public function getProducts(){
		return Products::get(['id','product_name']);
	}
	/**
	 * 获取表单参数
	 * */
	public function getFormPar(){
		$data['types']=PromotionsType::get(['id','name']);
		return $data;
	}
}
?>
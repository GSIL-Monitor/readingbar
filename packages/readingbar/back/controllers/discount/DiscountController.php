<?php
namespace Readingbar\Back\Controllers\Discount;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use Readingbar\Back\Controllers\BackController;
use Validator;
use Readingbar\Back\Models\Discount;
use DB;
class DiscountController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'Discount.head_title','url'=>'admin/Discount','active'=>true),
	);
	/**
	 * 列表
	 */
	public function DiscountList(){
		$data['head_title']=trans('Discount.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		return $this->view('discount.DiscountList', $data);
	}
	/**
	 * 获取优惠券折线图
	 * @param Request $request
	 */
	public function getLineChart(Request $request){
		$c=$this->getDiscountForCreated($request);
		$u=$this->getDiscountForUpdated($request);
		//VAR_DUMP($u->toArray());
		$data['columns'][]=collect($c->toArray())->pluck('lable')->prepend('x')->all();
		$data['columns'][]=collect($c->toArray())->pluck('data')->prepend('产生的优惠券')->all();
		$data['columns'][]=collect($u->toArray())->pluck('data')->prepend('已消费的优惠券')->all();
		return $data; 
	}
	public function getDiscountForCreated(Request $request){
		switch($request->input('type')){
			case 'year':$dateFormat="%Y";$minDate='2016';break;
			case 'month':$dateFormat="%Y-%m";$minDate='2016-10';break;
			case 'day':$dateFormat="%Y-%m-%d";$minDate='2016-11-01';break;
			default:return null;
		}
		$rs=Discount::rightjoin('assitant_date as ad',DB::raw("DATE_FORMAT(discount.created_at,'%Y-%m-%d')"),'=','ad.date');
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
		$rs=$rs->selectRaw("DATE_FORMAT(ad.date,'".$dateFormat."') as lable,count(discount.id) as data")
		->groupBy("lable")
		->having("lable",'<=',date('Y-m-d',time()))
		->having("lable",'>=',$minDate)
		->get();
		return $rs;
	}
	public function getDiscountForUpdated(Request $request){
		switch($request->input('type')){
			case 'year':$dateFormat="%Y";$minDate='2016';break;
			case 'month':$dateFormat="%Y-%m";$minDate='2016-10';break;
			case 'day':$dateFormat="%Y-%m-%d";$minDate='2016-11-01';break;
			default:return null;
		}
		$rs=Discount::rightjoin('assitant_date as ad',DB::raw("DATE_FORMAT(discount.updated_at,'%Y-%m-%d')"),'=','ad.date')
			->leftjoin('orders as o','o.id','=','discount.order_id');
		
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
		$rs=$rs->selectRaw("DATE_FORMAT(ad.date,'".$dateFormat."') as lable,count(IF(discount.status=1 and o.status=1,discount.id,null)) as data")
			->groupBy("lable")
			->having("lable",'<=',date('Y-m-d',time()))
			->having("lable",'>=',$minDate)
			->get();
		return $rs;
	}
	/**
	 * 获取优惠券饼图
	 * @param Request $request
	 */
	public function getPieChart(Request $request){
		$r=Discount::leftjoin('orders as o','o.id','=','discount.order_id')
			->first([DB::raw('count(IF(o.status is null or o.status=0,1,null))  as a'),DB::raw('count(IF(o.status=1,1,null)) as b')]);
		//var_dump($r);exit;
		return ['columns'=>[
			['未消费的优惠券',$r->a],
			['已消费的优惠券',$r->b]
		]];
	}
	/**
	 * 获取相关参数
	 * @param Request $request
	 */
	public function getPra(Request $request){
		
	}
}
?>
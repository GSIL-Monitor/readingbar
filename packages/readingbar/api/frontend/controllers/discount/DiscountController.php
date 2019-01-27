<?php

namespace Readingbar\Api\Frontend\Controllers\Discount;
use App\Http\Controllers\Controller;
use Readingbar\Api\Frontend\Controllers\FrontController;
use Illuminate\Http\Request;
use App\Http\Requests;
use Readingbar\Back\Models\Notice;
use Readingbar\Back\Models\DiscountType;
use Readingbar\Back\Models\Discount;
use DB;
use Readingbar\Back\Models\Members;
use Validator;
class DiscountController extends FrontController
{
	/**
	 * 被推广人获取推广折扣
	 * @param number $member_id
	 */
	static function createPromotedDiscountForMember($member_id=0,$pcode=null){
		if(!$member_id || !$pcode){
			return false;
		}
		$dicountType=DiscountType::join('promotions_type as prot','prot.o_discount','=','discount_type.id')
					->join('promotions as pro','pro.type','=','prot.id')
					->where(['pro.pcode'=>$pcode])
					->first(['discount_type.*']);
		if(!$dicountType){
			return false;
		}
		$expiration_time=date_create(date('Y-m-d H:i:s',time()));
		date_add($expiration_time,date_interval_create_from_date_string($dicountType['days']." days"));
		$create=array(
			'price'=>$dicountType['price'],	
			'expiration_time'=>date_format($expiration_time,'Y-m-d H:i:s'),	
			'status'=>0,
			'member_id'=>$member_id,
			'discount_type'=>$dicountType['id']	
		);
		Discount::create($create);
		return true;
	}
	/**
	 * 为已注册的用户发放 优惠券
	 * @param number $member_id
	 * @param unknown $pcode
	 */
	static function createdForHasRegisterMemeber($member_id=0,$pcode=null){
		if(!$member_id || !$pcode){
			return false;
		}
		//判断该用户是否发放过对应推广码的优惠券
		$r=Discount::crossjoin('discount_type as dt','dt.id','=','discount.discount_type')
			->crossjoin('promotions_type as prot','prot.o_discount','=','dt.id')
			->crossjoin('promotions as pro','pro.type','=','prot.id')
			->where(['pro.pcode'=>$pcode,'discount.member_id'=>$member_id])
			->count();
		if(!$r){
			return static::createPromotedDiscountForMember($member_id,$pcode);
		}else{
			return false;
		}
	}
	/**
	 * 被推广用户付款-推广员获取折扣券
	 * @param unknown $pcode
	 */
	static function createPayDiscountForPromoter($order_id=0){
		if(!$order_id){
			return false;
		}
		$m=Members::crossjoin('students as s','s.parent_id','=','members.id')
			->crossjoin('orders as o','o.owner_id','=','s.id')
			->where(['o.id'=>$order_id])
			->first(['pcode']);
		if(!$m || !$m['pcode']){
			return false;
		}
		$pcode=$m['pcode'];
		$dicountType=DiscountType::join('promotions_type as prot','prot.s_discount','=','discount_type.id')
			->join('promotions as pro','pro.type','=','prot.id')
			->where(['pro.pcode'=>$pcode])
			->first(['discount_type.*','pro.member_id']);
		if(!$dicountType){
			return false;
		}
		$expiration_time=date_create(date('Y-m-d H:i:s',time()));
		date_add($expiration_time,date_interval_create_from_date_string($dicountType['days']." days"));
		$create=array(
				'price'=>$dicountType['price'],
				'expiration_time'=>date_format($expiration_time,'Y-m-d H:i:s'),
				'status'=>0,
				'member_id'=>$dicountType['member_id'],
				'discount_type'=>$dicountType['id']
		);
		Discount::create($create);
		return true;
	}
	/**
	 * 用户购买对应产品-用户获取优惠券
	 * @param unknown $pcode
	 */
	static function createPayDiscountForProduct($order_id=0){
		if(!$order_id){
			return false;
		}
		$dicountType=DiscountType::crossJoin('products as p','p.discount_type_id','=','discount_type.id')
					->crossJoin('orders as o','o.product_id','=','p.id')
					->crossJoin('students as s','o.owner_id','=','s.id')
					->where(['o.id'=>$order_id])
					->first(['discount_type.*','s.parent_id as member_id']);
		
		if(!$dicountType){
			return false;
		}
		//限制单次STAR优惠券获赠次数
		if($dicountType->id==11 && $a=self::countDiscountsOfMemberByType($dicountType->id,$dicountType->member_id)>=2){
			return false;
		}
		$expiration_time=date_create(date('Y-m-d H:i:s',time()));
		date_add($expiration_time,date_interval_create_from_date_string($dicountType['days']." days"));
		$create=array(
				'price'=>$dicountType['price'],
				'expiration_time'=>date_format($expiration_time,'Y-m-d H:i:s'),
				'status'=>0,
				'member_id'=>$dicountType['member_id'],
				'discount_type'=>$dicountType['id']
		);
		Discount::create($create);
		return true;
	}
	/**
	 * 获取折扣价格
	 * @param number $member_id
	 * @param unknown $order_id
	 * @param array $dids 折扣券序列号
	 * @return number  折扣价格
	 */
	static function getDiscountPrice($member_id=0,$dids=array(),$product_id){
		if(!$member_id || !$dids){
			return 0;
		}
		$dids=self::filterDiscountsId($member_id,$product_id,$dids);
		
		$discounts=Discount::where(['member_id'=>$member_id,'status'=>0])->whereIn('id',$dids)->get();
		$dicountPrice=0;
		foreach ($discounts as $d){
			$dicountPrice+=$d->price;
		}
		return $dicountPrice;
	}
	/**
	 * 使用折扣券
	 * @param number $member_id
	 * @param unknown $order_id
	 * @param array $dids 折扣券序列号
	 * 
	 */
	static function useDiscounts($member_id=0,$order_id=0,$dids=array(),$product_id=0){
		if(!$member_id || !$order_id || !$dids || !$product_id){
			return false;
		}
		$dids=self::filterDiscountsId($member_id,$product_id,$dids);
		Discount::where(['member_id'=>$member_id,'status'=>0])
			->where('expiration_time','>=',DB::raw('NOW()'))
			->whereIn('id',$dids)
			->update(['status'=>1,'order_id'=>$order_id]);
		return true;
	}
	/**
	 * 过滤用户选定而不能使用的优惠券序号
	 * @param unknown $product_id
	 * @param unknown $discountIds
	 */
	static function filterDiscountsId($member_id,$product_id,$discountIds){
		return Discount::leftJoin('discount_type as dt','dt.id','=','discount.discount_type')
			->where(['discount.member_id'=>$member_id,'discount.status'=>0])
			->where('discount.expiration_time','>=',DB::raw('NOW()'))
			->whereIn('discount.id',$discountIds)
			->get(['discount.id','dt.products'])
			->filter(function($item) use($product_id){
				$products=unserialize($item['products']);
				if(in_array($product_id,$products)){
					return true;
				}else{
					return false;
				}
			})
			->pluck(['id'])
			->all();
	}
	/**
	 * 折扣券回收
	 * @param number $order_id  订单序列号
	 * @param number $expired	过期时间天数 默认1天
	 * @return boolean
	 */
	static function returnDiscount($order_id=0){
		if(!$order_id){
			return false;
		}
		$ids=Discount::leftjoin('orders as o','o.id','=','discount.order_id')
					->where(['o.id'=>$order_id,'discount.status'=>1,'o.status'=>0])
					->get(['discount.id'])
					->pluck('id')
					->all();
		if($ids){
			Discount::whereIn('id',$ids)->update(['status'=>0,'order_id'=>null]);
		}
		return true;
	}
	/**
	 * 获取当前登录用户的折扣券
	 * @return unknown
	 */
	public function getDiscounts(Request $request){
		if($request->input('type')=='all'){
			$rs=Discount::crossjoin('discount_type as dt','dt.id','=','discount.discount_type')
				->where(['discount.member_id'=>auth('member')->getId()])
				->select([
						'discount.*',
						'dt.name',
						DB::raw('IF(discount.expiration_time > NOW() and discount.status=0,TRUE,FALSE) as useAble'),
						DB::raw('IF(discount.status,"已使用","未使用") as status'),
						DB::raw('IF(discount.expiration_time >=NOW(),discount.expiration_time,"已过期") as expiration_time'),
				])
				->orderBy('useAble','desc')
				->paginate($request->input('limit')>0?$request->input('limit'):10);
		}else{
			Discount::where('expiration_time','<',DB::raw('NOW()'))->where(['status'=>0])->update(['status'=>2]);
			$inputs=$request->all();
			$rules=[
					'product_id'=>'required|exists:products,id'
			];
			$check=Validator::make($inputs,$rules);
			if($check->passes()){
				$all=Discount::crossjoin('discount_type as dt','dt.id','=','discount.discount_type')
					->where(['discount.member_id'=>auth('member')->getId(),'discount.status'=>0])
					->get(['dt.products','dt.name','discount.*']);
				$rs=array();
				foreach ($all as $v){
					if(in_array($request->input('product_id'),unserialize($v->products))){
						$rs[]=$v;
					}
				}
			}else{
				$rs=array();
			}
		}
		return $rs;
	}

	/**
	 * 获取用户获取当前优惠券的数量
	 * */
	static function countDiscountsOfMemberByType($tid,$mid){
		return Discount::where(['discount_type'=>$tid,'member_id'=>$mid])->count();
	}
}

<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Log;
class Discount extends Model
{
	public $table='discount';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('price','expiration_time','status','order_id','member_id','discount_type','operate_tag','donation_times');
    static function giveByRule($mid,$rule,$param=array(),$operate_tag=''){
    	$dts=self::getDiscountTypesByRules($rule,$param);
    	$member=DB::table('members')->where(['id'=>$mid])->first();
    	if(count($dts) && $member){
    		foreach ($dts as $dt){
    			self::giveDiscountToMember($dt,$member,$param,$operate_tag);
    		}
    	}
    }
    /**
     * 根据id获取对应优惠券类型
     */
   static function getDiscountTypeById($id){
   		return DB::table('discount_type as dt')->where(['id'=>$id])->first();
   }
   /**
    * 根据获取规则获取优惠券类型
    * @param unknown $rule
    */
   static function getDiscountTypesByRules($rule,$param=array()){
	   	switch($rule){
	   		//注册
	   		case 'register':
	   		// 书评
	   		case 'book_comment':
	   				return DB::table('discount_type as dt')->where(['get_rule'=>$rule,'del'=>0,'status'=>1])->get();
	   		break;
	   		//被推广注册-会员获得优惠券
	   		case 'promoted_register':
	   			 $dts=DB::table('discount_type as dt')->where(['get_rule'=>$rule,'del'=>0,'status'=>1])->get();
	   			 $returns=array();
	   			 foreach ($dts as $item){
	   			 	if(in_array($param['promotions_type_id'],unserialize($item->get_rule_promotions_types))){
	   			 		$returns[]=$item;
	   			 	}
	   			 }
	   			return $returns;
	   		break;
	   		//成为推广员
	   		case 'become_promoter':
	   			$dts=DB::table('discount_type as dt')->where(['get_rule'=>$rule,'del'=>0,'status'=>1])->get();
	   			$returns=array();
	   			 foreach ($dts as $item){
	   			 	if(in_array($param['promotions_type_id'],unserialize($item->get_rule_promotions_types))){
	   			 		$returns[]=$item;
	   			 	}
	   			 }
	   			return $returns;
	   		break;
	   		//会员购买-会员获得优惠券
	   		case 'member_buy':
	   			$dts=DB::table('discount_type as dt')->where(['get_rule'=>$rule,'del'=>0,'status'=>1])->get();
	   			$returns=array();
	   			foreach ($dts as $item){
	   				if(in_array($param['product_id'],unserialize($item->get_rule_products))){
	   					$returns[]=$item;
	   				}
	   			}
	   			return $returns;
	   		break;
	   		//被推广会员购买-会员获得优惠券
	   		case 'promoted_member_buy_tm':
	   			$dts=DB::table('discount_type as dt')->where(['get_rule'=>$rule,'del'=>0,'status'=>1])->get();
	   			$returns=array();
	   			foreach ($dts as $item){
	   				if(in_array($param['product_id'],unserialize($item->get_rule_products)) && in_array($param['promotions_type_id'],unserialize($item->get_rule_promotions_types))){
	   					$returns[]=$item;
		   			}
	   			}
	   			return $returns;
	   		break;
	   		//被推广会员购买-推广员获得优惠券
	   		case 'promoted_member_buy_tp':
	   			$dts=DB::table('discount_type as dt')->where(['get_rule'=>$rule,'del'=>0,'status'=>1])->get();
	   			$returns=array();
	   			foreach ($dts as $item){
	   				if(in_array($param['product_id'],unserialize($item->get_rule_products)) && in_array($param['promotions_type_id'],unserialize($item->get_rule_promotions_types))){
	   					$returns[]=$item;
	   				}
	   			}
	   			return $returns;
	   			break;
	   		//推广一个新会员-推广员获得优惠券
	   		case 'promote_new_member':
	   			$dts=DB::table('discount_type as dt')->where(['get_rule'=>$rule,'del'=>0,'status'=>1])->get();
	   			$returns=array();
	   			 foreach ($dts as $item){
	   			 	if(in_array($param['promotions_type_id'],unserialize($item->get_rule_promotions_types))){
	   			 		$returns[]=$item;
	   			 	}
	   			 }
	   			return $returns;
	   		break;
	   		//积分购买优惠券
	   		case 'buy_discount_by_point':
	   				$dts=DB::table('discount_type as dt')
		   				->leftjoin('s_point_product as spp','spp.type_v','=','dt.id')
		   				->where(['dt.get_rule'=>$rule,'dt.del'=>0,'dt.status'=>1,'spp.id'=>$param['product_id']])
		   				->get(['dt.*']);
	   				return $dts;
	   		break;
	   		//会员创建第一个孩子，会员获得优惠券
	   		case 'create_first_child_tm':
	   			$returns=array();
	   			//判断当前会员是否第一次创建孩子
	   			if(DB::table('students as s')->where(['s.parent_id'=>$param['member_id']])->count()==1){
	   				$returns=DB::table('discount_type as dt')->where(['get_rule'=>$rule,'del'=>0,'status'=>1])->get();
	   			}
	   			return $returns;
   			//会员创建第一个孩子，会员获得优惠券
   			case 'create_first_child_tp':
   				$returns=array();
   				//判断当前会员是否第一次创建孩子
   				if(DB::table('students as s')->where(['s.parent_id'=>$param['member_id']])->count()==1){
   					$dts=DB::table('discount_type as dt')->where(['get_rule'=>$rule,'del'=>0,'status'=>1])->get();
   					foreach ($dts as $item){
   						if(in_array($param['promotions_type_id'],unserialize($item->get_rule_promotions_types))){
   							$returns[]=$item;
   						}
   					}
   				}
   				return $returns;
	   		break;
	   	}
   }
	/**
	 *  给用户优惠券
	 * @param unknown $dt
	 * @param unknown $member
	 */
    static function giveDiscountToMember($dt,$member,$param,$operate_tag){
    	if(self::checkLimit($dt,$member,$param)){
    		$expiration_time=date_create(date('Y-m-d H:i:s',time()));
    		date_add($expiration_time,date_interval_create_from_date_string($dt->days." days"));
    		$create=array(
    				'price'=>$dt->price,
    				'expiration_time'=>date_format($expiration_time,'Y-m-d H:i:s'),
    				'status'=>0,
    				'member_id'    =>$member->id,
    				'discount_type'=>$dt->id,
    				'operate_tag'	 =>$operate_tag
    		);
    		self::create($create);
    	}
    }
    /**
     * 校验获取限制
     * @param unknown $dt
     * @param unknown $member
     * @return boolean
     */
    static function checkLimit($dt,$member,$param){
    	switch($dt->get_limit){
    		case '1':
    			$r=self::where(['discount_type'=>$dt->id])->where(function($where)use($member){
    				$where->where(['member_id'=>$member->id])
    							->orWhere(['old_member_id'=>$member->id]);
    			})->count();
    			return !$r;
    			break;
    		case '2':
    			$ym=date('Y-m',time());
    			$r=self::where(['discount_type'=>$dt->id])->where('created_at','like',$ym.'%')->where(function($where)use($member){
    				$where->where(['member_id'=>$member->id])
    							->orWhere(['old_member_id'=>$member->id]);
    			})->count();
    			return !$r;
    			break;
    		case '3':
    			$y=date('Y',time());
    			$r=self::where(['discount_type'=>$dt->id])->where('created_at','like',$y.'%')->where(function($where)use($member){
    				$where->where(['member_id'=>$member->id])
    							->orWhere(['old_member_id'=>$member->id]);
    			})->count();
    			return !$r;
    			break;
    		case '4':
    			if(!isset($param['buy_member_id'])){
    				dd('buy_member_id（购买产品的会员id）参数不存在！');
    			}
    			if(!isset($param['product_id'])){
    				dd('product_id（购买产品的id）参数不存在！');
    			}
    			//判断购买产品的会员是否是第一次购买当前产品
    			$count=DB::table('orders as o')
	    			->crossjoin('students as s','s.id','=','o.owner_id')
	    			->where(['s.parent_id'=>$param['buy_member_id'],'o.status'=>1,'o.product_id'=>$param['product_id']])
	    			->count();
    			return $count==1;
    			break;
    		default:return true;
    	}
    }
    /**
     * 根据操作标签修改优惠券状态
     * @param unknown $operate_tag
     * @param unknown $status
     */
    static function changeDiscountStatusByOerateTag($operate_tag,$status){
    	self::where(['operate_tag'=>$operate_tag])->update(['status'=>$status]);
    }
    /**
     * 根据id修改优惠券状态
     * @param unknown $id
     * @param unknown $status
     */
    static function changeDiscountStatusByID($id,$status){
    	self::where(['id'=>$id])->update(['status'=>$status]);
    }
    /**
     * 修改优惠券所属
     * @param unknown $did
     * @param unknown $mid
     */
    static function changeDiscountBelong($did,$mid){
    	self::where(['id'=>$did])->update(['member_id'=>$mid]);
    }
    /**
     * 可使用优惠券转赠
     * @param unknown $did
     * @param unknown $mid
     */
    static function changeDiscountBelongS0($did,$mid){
    	self::where(['id'=>$did,'status'=>0])->update(['old_member_id'=>DB::raw('member_id'),'member_id'=>$mid,'donation_times'=>DB::raw('donation_times+1')]);
    }
    /**
     * 更新过期且未使用的优惠券的状态
     */
    static function updateExpiratedDiscountStatus(){
    	self::where('expiration_time','<=',DB::raw('NOW()'))->where(['status'=>0])->update(['status'=>2]);
    }
    /**
     * 更新指定会员所有过期且未使用的优惠券的状态
     * @param unknown $mid
     */
    static function updateExpiratedDiscountStatusForMember($mid){
    	self::where('expiration_time','<=',DB::raw('NOW()'))->where(['status'=>0,'member_id'=>$mid])->update(['status'=>2]);
    }
}

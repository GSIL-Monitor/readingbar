<?php

namespace Readingbar\Front\Controllers\Discount;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Readingbar\Front\Controllers\FrontController;
use App\Http\Requests;
use Readingbar\Back\Models\Discount;
use DB;
use Readingbar\Back\Models\Products;
use Validator;
class DiscountController extends FrontController
{
	/*个人中心折扣券列表*/
	public function index(){
		$data['head_title']='优惠券';
		$data['members']=$this->getPromotedMembers();
		return $this->view('discount.discountList', $data);
	}
	/**
	 * 获取当前登录用户的折扣券
	 * @return unknown
	 */
	public function getDiscountsList(Request $request){
		$rs=Discount::crossjoin('discount_type as dt','dt.id','=','discount.discount_type')
			->where(function($where){
				$where->where(['discount.member_id'=>auth('member')->getId()])
					->orWhere(['discount.old_member_id'=>auth('member')->getId()]);
			})
			->select([
					'discount.*',
					'dt.name',
					'dt.products',
					'dt.donation',
					DB::raw('IF(discount.expiration_time > NOW() and discount.status=0,FALSE,TRUE) as has_exprited'),
			])
			->orderBy('status','asc')
			->paginate($request->input('limit')>0?$request->input('limit'):10);
			foreach ($rs as $key=>$value){
				if($value->has_exprited && $rs[$key]['status']==0){
					Discount::changeDiscountStatusByID($value->id, 2);
					$rs[$key]['status']=2;
				}
				if($rs[$key]['old_member_id']==auth('member')->getId()){
					$rs[$key]['status']=3;
					$rs[$key]['status_text']='已转赠';
				}else{
					$rs[$key]['status_text']=trans('discount.status.'.$rs[$key]['status']);
				}
				$rs[$key]['products']=Products::whereIn('id',unserialize($value->products))->get(['product_name']);
				if($rs[$key]['status']==0 && $rs[$key]['donation']=='to_promoted_member' && $rs[$key]['donation_times']==0){
					$rs[$key]['donation_able']=true;
				}else{
					$rs[$key]['donation_able']=false;
				}
			}
			return $rs;
	}
	/**
	 * 转赠优惠券
	 */
	public function donation(Request $request){
		$inputs=$request->all();
		$inputs['donation']=(int)$this->checkDonationToPromotedMember($request->input('id'),$request->input('username'));
		$rules=[
			'id'=>'required|exists:discount,id,status,0,member_id,'.auth('member')->getId(),
			'username'=>'required|exist_member',
			'donation'=>'required|in:1'
		];
		$messages=array('id.exists'=>':attribute不存在或已不可用！','donation.in'=>'同一会员最多可转赠1张优惠券！');
		$attributes=array('id'=>'优惠券');
		$check=Validator::make($inputs,$rules,$messages,$attributes);
		if($check->passes()){
			$member=DB::table('members as m')
									->where(['m.cellphone'=>$request->input('username')])
									->orWhere(['m.email'=>$request->input('username')])
									->first();
			Discount::changeDiscountBelongS0($request->input('id'),$member->id);
			$return= array('status'=>true,'success'=>'转赠成功');
		}else{
			$return= array('status'=>false,'error'=>$check->errors()->first());
		}
		return $return;
	}
	/**
	 * 校验用户是否可以转赠优惠券
	 */
	public function checkDonationToPromotedMember($id,$username){
		$dt=DB::table('discount as d')->crossjoin('discount_type as dt','dt.id','=','d.discount_type')->where(['d.id'=>$id])->first(['dt.*']);
		switch($dt->donation){
			//蕊丁使者优惠券转赠校验
			case 'to_promoted_member':
				//校验要转赠的用户是否是当前用户名下
				$a1=DB::table('members as m')
					->crossjoin('promotions as p','m.pcode','=','p.pcode')
					->where(['p.member_id'=>auth('member')->getId()])
					->where(function($where) use($username){
						$where->orWhere(['m.cellphone'=>$username])
									->orWhere(['m.email'=>$username]);
					})->count();
				 //校验当前用户是否转赠过优惠券给要转赠的用户
				$a2=DB::table('discount as d')
				 	->crossjoin('members as m','m.id','=','d.member_id')
				 	->where(['d.old_member_id'=>auth('member')->getId()])
				 	->where(function($where) use($username){
						$where->orWhere(['m.cellphone'=>$username])
									->orWhere(['m.email'=>$username]);
					})->count();
					if($a1 && !$a2){
						return true;
					}else{
						return false;
					}
			break;
			default:return false;
		}
	}
	/**
	 * 获取当前会员所推广的用户
	 * @param Request $request
	 * @return unknown
	 */
	public function getPromotedMember(Request $request){
		$member=DB::table('members as m')
			->crossjoin('promotions as p','m.pcode','=','p.pcode')
			->where(['p.member_id'=>auth('member')->getId()])
			->where(function($where) use($request){
				$where->orWhere(['m.cellphone'=>$request->input('username')])
							->orWhere(['m.email'=>$request->input('username')]);
			})->first(['m.nickname']);
		if($member){
			return array('nickname'=>$member->nickname);
		}else{
			return array('nickname'=>null);
		}
	}
	/**
	 * 获取当前会员所推广的用户
	 * @param Request $request
	 * @return unknown
	 */
	public function getPromotedMembers(){
		$members=DB::table('members as m')
		->crossjoin('promotions as p','m.pcode','=','p.pcode')
		->where(['p.member_id'=>auth('member')->getId()])
		->get(['m.cellphone','m.email','m.nickname']);
		return $members;
	}
}

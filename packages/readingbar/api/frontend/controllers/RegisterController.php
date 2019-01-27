<?php

namespace Readingbar\Api\Frontend\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use Readingbar\Api\Functions\MemberFunction;
use Validator;
use Readingbar\Api\Frontend\Models\Members;
use Readingbar\Api\Frontend\Models\Promotions;
use Readingbar\Api\Frontend\Controllers\Discount\DiscountController;
use Readingbar\Back\Models\Discount;
use Readingbar\Back\Models\PromotionsType;
use Readingbar\Back\Controllers\Spoint\PointController;
use Readingbar\Back\Models\Students;
class RegisterController extends FrontController
{
	/*注册*/
	public function register(Request $request){
			$registercode=session('registercode');
			$column=MemberFunction::checkUsernameType($request->input('username'));
			$code=$request->input('username').$request->input('code');
			$input=array(
				'username'=>$column,
				'nickname'=>$request->input('nickname'),
				//'license'=>$request->input('license'),
				'password'=>$request->input('password'),
				'password_confirmation'=>$request->input('password_confirmation'),
				'registercode'=>$registercode?$registercode['username'].$registercode['code']:null,
				'code'=>$code,
				'verification_code_expire'=>$registercode['expire']
			);
			$rules=array(
				'username'=>'required|in:email,cellphone',
				'nickname'=>'required|max:15|unique:members,nickname',
				//'license'=>'required|in:agree',
				'password'=>'required|regex:/^(?=.*[0-9].*)(?=.*[a-zA-Z].*).{8,20}$/|confirmed',
				'registercode'=>'required',
				'code'=>'required|same:registercode',
				'verification_code_expire'=>'required|numeric|min:'.time()
			);
			if($column!='undefined'){
				$input[$column]=$request->input('username');
				$rules[$column]='required|unique:members,'.$column;
			}
			$messages=array(
				'license.in'=>trans('register.validator_license_in'),
				'username.in'=>trans('register.validator_username_in'),
				'code.same'=>trans('register.validator_code_same'),
				'registercode.required'=>trans('register.validator_registercode_required'),
				'password.confirmed'=>trans('register.validator_password_confirmed'),
				'password.regex'=>trans('register.validator_password_regex'),
			);
			$attributes=array(
				'email'=>trans('register.column_email'),
				'cellphone'=>trans('register.column_cellphone'),
				'nickname'=>trans('register.column_nickname'),
				'password'=>trans('register.column_password'),
				'license'=>trans('register.column_licence'),
				'username'=>trans('register.column_username'),
				'code'=>trans('register.column_code'),
				'registercode'=>trans('register.cloumn_registercode'),
			);
			$check=Validator::make($input,$rules,$messages,$attributes);
			if($check->passes()){
				    $member=array(
						$column=>$request->input('username'),
						'nickname'=>$request->input('nickname'),
						'password'=>bcrypt($request->input('password')),
						'actived'=>1
					);
					$member=Members::create($member);
					session()->forget('registercode');
					//推广人关联用户记录
					if(session('pcode')){
						$promotion=Promotions::where(['pcode'=>session('pcode')])->first();
						if($promotion){
							Members::where(['id'=>$member->id])->update(['pcode'=>session('pcode')]);
							//被推广注册获取折扣券
							if($promotion->type){
								Discount::giveByRule($member->id, 'promoted_register',['promotions_type_id'=>$promotion->type]);
								Discount::giveByRule($promotion->member_id, 'promote_new_member',['promotions_type_id'=>$promotion->type]);
							}
						}
						//推广员获得积分
						$this->givePointToPormoter(session('pcode'));
					}
					
					//一般用户注册获取优惠券
					Discount::giveByRule($member->id, 'register');
					if ($request->ajax()) {
						return ['message'=>'注册成功！'];
					}else{
						return redirect("/login")->with(['success'=>'注册成功！']);
					}
					
			}
			if ($request->ajax()) {
				return response(['errors'=>$check->errors(),'message'=>'申请信息有误！'],400);
			}else{
				return redirect('/register')->withErrors($check->errors())->withInput();
			}
			
			//$this->echoJson();
	}
	/*注册给予积分*/
	public function givePointToPormoter($pcode){
		$students=Students::crossjoin('members as m','students.parent_id','=','m.id')
								->crossjoin('promotions as p','p.member_id','=','m.id')
								->where('p.pcode','=',$pcode)
								->get(['students.id','p.type']);
		foreach($students as $s){
			PointController::increaceByRule([
					'rule'=>'promote_new_member',
					'promotions_type'=>$s->type,
					'student_id'=>$s->id,
			]);
		}
	}
}

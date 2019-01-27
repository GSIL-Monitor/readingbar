<?php

namespace Readingbar\Api\Functions;
use Validator;
class MemberFunction
{
	/**
	 * 校验用户名判断用户名是否存在
	 * 校验正确并反
	 * @param unknown $username
	 * @return unknown
	 */
	static function existsUsername($username){
		$input=array(
			'email'=>$username,
			'cellphone'=>$username
		);
		$rules=array(
			'email'=>'required|exists:members,email',
			'cellphone'=>'required|exists:members,cellphone',
		);
		$messages=array(
			'required'=>trans('myvalidator.required'),
			'exists'=>trans('myvalidator.exists'),
		);
		$attributes=array(
			'email'=>trans('members.column_email'),
			'cellphone'=>trans('members.column_cellphone'),
		);
		$c=Validator::make($input,$rules,$messages,$attributes);
		//判断邮箱是否验证通过
		$c_email=!$c->errors()->has('email');
		//判断手机号码是否验证通过
		$c_cellphone=!$c->errors()->has('cellphone');
		if($c_cellphone || $c_email){
			return true;
		}else{
			return false;
		}
	}
	/**
	 * 校验用户名判断用户名是否是否是激活的用户
	 * 校验正确并反
	 * @param unknown $username
	 * @return unknown
	 */
	static function activedUsername($username){
		$input=array(
				'email'=>$username,
				'cellphone'=>$username
		);
		$rules=array(
				'email'=>'required|exists:members,email,actived,1',
				'cellphone'=>'required|exists:members,cellphone,actived,1',
		);
		$messages=array(
				'required'=>trans('myvalidator.required'),
				'exists'=>trans('myvalidator.exists'),
		);
		$attributes=array(
				'email'=>trans('members.column_email'),
				'cellphone'=>trans('members.column_cellphone'),
		);
		$c=Validator::make($input,$rules,$messages,$attributes);
		//判断邮箱是否验证通过
		$c_email=!$c->errors()->has('email');
		//判断手机号码是否验证通过
		$c_cellphone=!$c->errors()->has('cellphone');
		if($c_cellphone || $c_email){
			return true;
		}else{
			return false;
		}
	}
	/**
	 * 验证用户名类型  返回用户名对应字段名
	 * @param unknown $username
	 * @return string
	 */
	static function checkUsernameType($username){
		$input=array(
				'email'=>$username,
				'cellphone'=>$username
		);
		$rules=array(
				'cellphone'=>'required|regex:/^[1][3578][0-9]{9}$/',
				'email'=>'required|email'
		);
		$messages=array(
				'required'=>trans('myvalidator.regex'),
				'exists'=>trans('myvalidator.regex'),
		);
		$attributes=array(
				'email'=>trans('members.column_email'),
				'cellphone'=>trans('members.column_cellphone')
		);
		$c=Validator::make($input,$rules,$messages,$attributes);
		//判断邮箱是否验证通过
		$c_email=!$c->errors()->has('email');
		//判断手机号码是否验证通过
		$c_cellphone=!$c->errors()->has('cellphone');
		if($c_cellphone || $c_email){
			if($c_cellphone){
				return 'cellphone';
			}
			if($c_email){
				return 'email';
			}
		}else{
			return 'undefined';
		}
}
}

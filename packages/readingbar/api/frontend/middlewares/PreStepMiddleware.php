<?php

namespace Readingbar\Api\Frontend\Middlewares;

use Closure;
use App;
use Illuminate\View\ViewServiceProvider;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\json_encode;
use Illuminate\Support\Facades\Session;
use Readingbar\Api\Frontend\Models\Students;
class PreStepMiddleware
{	
    public function handle($request, Closure $next)
    {	
    	switch($request->getRequestUri()){
    		//购买的前置操作
//     		case '/product/list':
//     			if($r=$this->stepBeforeBuy()){
//     				return $r;
//     			}
    		//创建孩子的前置操作
    		case '/member/children/create':
    			if($r=$this->stepBeforeAddChild()){
    				return $r;
    			}
    		break;
    	}
        return $next($request);
    }
    //添加孩子的前置操作
    public function stepBeforeAddChild(){
    	//判断用户是否完善手机和邮箱信
    	$member=auth('member')->member();
    	if($member->email=='' || $member->cellphone==''){
    		$messages=array('alert'=>'添加孩子前,请完善手机和邮箱信息！');
    		if(session('theme')=='mobile'){
    			return redirect('member/baseinfoForm')->with($messages);
    		}else{
    			return redirect('member/baseinfo')->with($messages);
    		}
    	}else{
    		return false;
    	}
    }
    //购买的前置操作
    public function stepBeforeBuy(){
    	//判断用户是否完善手机和邮箱信
    	$member=auth('member')->member();
    	if($member->email=='' || $member->cellphone==''){
    		$messages=array('message'=>'购买前，请完善手机和邮箱信息！');
    		return redirect('member/baseinfo')->with($messages);
    	}
    	//判断用户是否有添加了孩子信息
    	if(!Students::where(['parent_id'=>$member->id])->count()){
    		$messages=array('message'=>'购买前，请添加孩子信息！');
    		return redirect('/member/children/create')->with($messages);
    	}
    	return false;
    }
}
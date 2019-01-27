<?php

namespace Readingbar\Back\Middlewares;

use Closure;
use App;
use Illuminate\View\ViewServiceProvider;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\json_encode;
use Illuminate\Support\Facades\Session;
use Readingbar\Back\Models\Messages;


class ShareMiddleware
{	
    public function handle($request, Closure $next)
    {	
    	 $messages=Messages::leftjoin('users',function($join){
						$join->on('users.id','=','messages.sendto')->orOn('users.id','=','messages.sendfrom');
					})->
					leftjoin('members',function($join){
						$join->on('members.email','=','messages.sendto')
						->orOn('members.cellphone','=','messages.sendto')
						->orOn('members.email','=','messages.sendfrom')
						->orOn('members.cellphone','=','messages.sendfrom');
					})
					->where(['sendto'=>Auth::user()->id,'receiver_del'=>0])
					->whereNull('reply')
					->orwhere(['sendfrom'=>Auth::user()->id,'sender_del'=>0])
					->whereNull('reply')
					->orderBy('messages.created_at','desc')
					
					->skip(0)->take(3)
					->get(['messages.*',
							'users.name as user_name',
							'users.avatar as user_avatar',
							'members.nickname as member_name',
							'members.avatar as member_avatar'])
					->toArray();
		foreach ($messages as $k=>$v){
			if($v['sendfrom']=='system'){
				$messages[$k]['sender_name']='系统';
				$messages[$k]['sender_avatar']=url('files/avatar/default_avatar.jpg');
			}else
				if($v['sendfrom']==Auth::user()->id){
					$messages[$k]['sender_name']=$v['user_name'];
					$messages[$k]['sender_avatar']=$v['user_avatar']?url($v['user_avatar']):url('files/avatar/default_avatar.jpg');
			}else{
				$messages[$k]['sender_name']=$v['member_name'];
				$messages[$k]['sender_avatar']=$v['member_avatar']?url($v['member_avatar']):url('files/avatar/default_avatar.jpg');
			}
		}
    	$data['BMessages']=array(
    		'unread'=>Messages::where(['sendto'=>Auth::user()->id,'receiver_read'=>0])->count(),
    		'messages'=>$messages
    	);
    	session($data);
        return $next($request);
    }
}
<?php

namespace Readingbar\Api\Frontend\Controllers\Notice;
use App\Http\Controllers\Controller;
use Readingbar\Api\Frontend\Controllers\FrontController;
use Illuminate\Http\Request;

use App\Http\Requests;
use Readingbar\Back\Models\Notice;

class NoticeController extends FrontController
{
	/*获取公告*/
	static function getNotices(){
		$rs=Notice::where(['status'=>1])->get();
		foreach ($rs as $k=>$v){
			$rs[$k]['url']=$rs[$k]['url']?$rs[$k]['url']:'javascript:void(0)';
		}
		return $rs;
	}
}

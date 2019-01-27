<?php

namespace Readingbar\Front\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Readingbar\Api\Frontend\Controllers\Notice\NoticeController;
use Readingbar\Back\Models\FriendlyLink;
use Readingbar\Back\Models\BtnLink;
use Readingbar\Back\Models\Products;
use Readingbar\Back\Models\Students;

class HomeController extends FrontController
{
	public function index(Request $request){
		$data['head_title']='蕊丁吧-首页';
		$data['products']=Products::get();
		/*获取当前家长的孩子信息*/
		$data['students']=Students::where(['parent_id'=>auth('member')->getId()])
		->get(['students.*'])->each(function($item,$key){
			$item->avatar = url($item->avatar);
			$item->point = $item->point();
			$item->ge = $item->lastGe();
			return $item;
		});;
		return $this->view('home.home_20181106', $data);
	}
}

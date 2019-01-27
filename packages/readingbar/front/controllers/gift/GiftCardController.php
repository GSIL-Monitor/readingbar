<?php

namespace Readingbar\Front\Controllers\Gift;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Readingbar\Front\Controllers\FrontController;
use App\Http\Requests;

class GiftCardController extends FrontController
{
	/*个人中心折扣券列表*/
	public function index(){
		$data['head_title']='礼品卡充值流程';
		return $this->view('gift.giftCardProcess', $data);
	}
}

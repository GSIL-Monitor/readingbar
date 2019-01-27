<?php

namespace Readingbar\Front\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use Readingbar\Back\Models\Students;
use Readingbar\Back\Models\Products;
use DB;
use Readingbar\Back\Models\ServiceStatus;
class ProductController extends FrontController
{
	/*产品页*/
	public function index(){
		header("Content-type:text/html;charset=utf-8");
		$data['head_title']='产品页';
		$data['products']=Products::get();
		/*获取当前家长的孩子信息*/
		$data['students']=Students::where(['parent_id'=>auth('member')->getId()])
							->get(['students.*']);
		return $this->view('product.list', $data);
	}
	/*购买须知*/
	public function purchaseNotice(){
		$data['head_title']='购买须知';
		$data['products']=Products::get();
		return $this->view('product.purchaseNotice', $data);
	}
	/*单次阅读体验*/
	public function singleReadingExperience(){
		$data['head_title']='单次阅读体验';
		$data['products']=Products::get();
		/*获取当前家长的孩子信息*/
		$data['students']=Students::where(['parent_id'=>auth('member')->getId()])
			->where('expiration_time','<',date('Y-m-d',time()))
			->get(['students.*']);
		return $this->view('product.singleReadingExperience', $data);
	}
	/*产品详情*/
	public function productDetail($id){
		switch ($id){
			//case '1':$data['head_title']='定制阅读';break;
			//case '3':$data['head_title']='自主阅读';break;
			//case '4':$data['head_title']='能力评测';break;
			//case '5':$data['head_title']='Reading Camp';break;
			//case '6':$data['head_title']='暑期阅读借阅';break;
			//case '7':$data['head_title']='单次star测评';break;
			//case '8':$data['head_title']='测试系统体验';break;
			//case '9':$data['head_title']='寒假悦读养成计划';break;
			default:return '产品不存在';
		}
		$data['students']=Students::where(['parent_id'=>auth('member')->getId(),'del'=>0])->get(['students.*'])->each(function($item,$key){
			$item->avatar = url($item->avatar);
			$item->point = $item->point();
			$item->ge = $item->lastGe();
			return $item;
		});
		
		$data['products']=Products::get();
		return $this->view('product.detail'.$id, $data);
	}
	/**
	 * 2017-11-07 上线产品
	 */
	public function product20171107(){
		$data['head_title']='产品页';
		$data['students'] = Students::where(['parent_id'=>auth('member')->id(),'del'=>0])->get()->each(function($item,$key){
			$item->avatar = url($item->avatar);
			$item->point = $item->point();
			$item->ge = $item->lastGe();
			return $item;
		});
		$data['products']=Products::get(['id','show','quantity']);
		//dd($data['students']->toArray());
		return $this->view('product.product20171107',$data);
	}
}

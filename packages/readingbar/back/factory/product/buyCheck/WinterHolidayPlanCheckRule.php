<?php 
namespace Readingbar\Back\Factory\Product\BuyCheck;

use Readingbar\Back\Models\Products;
use Readingbar\Back\Models\Students;
use Readingbar\Back\Models\ProductBuyCheck;
use Readingbar\Back\Models\ReadPlan;

class WinterHolidayPlanCheckRule implements Rules{
	private $check = true;
	private $message = '';
	public function __construct(Products $product,Students $student, ProductBuyCheck $checkBasis){
		$plan=ReadPlan::where(['type'=>2,'for'=>$student->id])->where(function ($where){
				$where->where('status','<',5)->orWhere('status','=',6);
		})->first();
		$this->check = $plan?false:true;
		if (!$this->check) {
			switch($plan->status){
				case '-1':
					$message = '您的书单信息正在创建中，请耐心等待哦，暂时还不能申请新的寒假悦读计划服务~';
					break;
				case '0':
					$message = '您的书单信息已经创建，请前往【我的书单】中进行确认，暂时还不能申请新的寒假悦读计划服务哦~';
					break;
				case '1':
				case '2':
					$message = '您的书籍已经在路上啦，请您耐心等待，暂时还不能申请新的寒假悦读计划服务哦~';
					break;
				case '3':
				case '4':
				case '6':
					$message = '您的书籍还未归还，暂时还不能购买新的寒假悦读计划服务哦~';
					break;
			};
			$this->message = $message;
		}
		return $this;
	}
	static function make(Products $product,Students $student,ProductBuyCheck $checkBasis) {
		return new self($product,$student,$checkBasis);
	}
	public function result(){
		return [
			'check'=>$this->check,
			'message'=>$this->message
		];
	}
	public function check(){
	   return $this->check;
	}
	public function message(){
		return $this->message;
	}
}
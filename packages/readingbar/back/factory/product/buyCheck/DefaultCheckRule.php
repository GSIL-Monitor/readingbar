<?php 
namespace Readingbar\Back\Factory\Product\BuyCheck;

use Readingbar\Back\Models\Products;
use Readingbar\Back\Models\Students;
use Readingbar\Back\Models\ServiceStatus;
use Readingbar\Back\Models\ProductBuyCheck;
use DB;
use Readingbar\Back\Models\StarReport;
/**
 * 通过所有校验的默认返回对象
 */
class DefaultCheckRule implements Rules{
	private $check = true;
	private $message = '产品不存在！';
	public function __construct($product){
		$this->check=$product->show?true:false;
		return $this;
	}
	static function make(Products $product,Students $student,ProductBuyCheck $checkBasis) {
		return new self();
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
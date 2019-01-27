<?php 
namespace Readingbar\Back\Factory\Product\BuyCheck;

use Readingbar\Back\Models\Products;
use Readingbar\Back\Models\Students;
use Readingbar\Back\Models\ServiceStatus;
use Readingbar\Back\Models\ProductBuyCheck;
use DB;
use Readingbar\Back\Models\StarReport;

class AllowBuyCheckRule implements Rules{
	private $check = true;
	private $message = '';
	public function __construct(Products $product,Students $student, ProductBuyCheck $checkBasis){
		$this->check=$product->show?true:false;
		if (!$this->check) {
			$this->message = $checkBasis->message;
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
<?php 
namespace Readingbar\Back\Factory\Product\BuyCheck;

use Readingbar\Back\Models\Products;
use Readingbar\Back\Models\Students;
use Readingbar\Back\Models\ProductBuyCheck;
use Readingbar\Back\Models\Orders;

class BoughtAnyByMemberCheckRule implements Rules{
	private $check = true;
	private $message = '';
	public function __construct(Products $product,Students $student, ProductBuyCheck $checkBasis){
		$hasBought=Orders::where(['status'=>1])
			->whereIn('owner_id',function($query) use($student){
				return $query->select('id')->from('students')->where(['parent_id'=>$student->parent_id]);
			})
			->count()?true:false;
		$this->check = !$hasBought;
		if (!$this->check) {
			$this->message = $checkBasis->message;
		}
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
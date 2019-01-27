<?php
namespace Readingbar\Back\Factory\Product\renewDiscount;

use Readingbar\Back\Models\ProductRenewDiscount;
use Readingbar\Back\Models\Products;
use Readingbar\Back\Models\Students;
use Readingbar\Back\Models\Orders;

class AfterBuyProduct implements RenewDiscountRuleInterface{
	private $price = 0; 
	public function __construct(Products $product,Students $student,ProductRenewDiscount $checkBasis){
		$lastOrder = Orders::where(['product_id'=>$checkBasis->product,'status'=>1,'owner_id'=>$student->id])
										  ->orderBy('id','desc')->first();
		if ($lastOrder) {
			$now=time();
			$buytimestemp =$lastOrder->completed_at?strtotime($lastOrder->completed_at):0;
			$diff = $now - $buytimestemp;
			if ($diff >= 0) {
				if ($diff/(24*60*60)<=$checkBasis->days) {
					$this->price = $checkBasis->discount_price;
				}
			}
		}
	}
	static function make (Products $product,Students $student,ProductRenewDiscount $checkBasis) {
		return new self ($product,$student,$checkBasis);
	}
	public function discountPrice(){
		return $this->price;
	}
}
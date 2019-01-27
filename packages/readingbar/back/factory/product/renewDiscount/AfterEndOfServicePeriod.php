<?php
namespace Readingbar\Back\Factory\Product\renewDiscount;

use Readingbar\Back\Models\ProductRenewDiscount;
use Readingbar\Back\Models\ServiceStatus;
use Readingbar\Back\Models\Products;
use Readingbar\Back\Models\Students;

class AfterEndOfServicePeriod implements RenewDiscountRuleInterface{
	private $price = 0; 
	public function __construct(Products $product,Students $student,ProductRenewDiscount $checkBasis){
		$ssp = ServiceStatus::where(['student_id'=>$student->id,'service_id'=>$checkBasis->service_id])->first();
		if ($ssp) {
			$now=time();
			$expirated = $ssp->expirated?strTotime($ssp->expirated):0;
			$diff = $now - $expirated;
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
<?php
namespace Readingbar\Back\Factory\Product\RenewDiscount;

use Readingbar\Back\Models\ProductRenewDiscount;
use Readingbar\Back\Models\ServiceStatus;
use Readingbar\Back\Models\Products;
use Readingbar\Back\Models\Students;
use DB;
/**
 * 判断选定的服务是否走在服务期内
 * @author johnathan
 */
class DuringServicePeriod implements RenewDiscountRuleInterface{
	private $price = 0; 
	public function __construct(Products $product,Students $student,ProductRenewDiscount $checkBasis){
		$checkServices = $checkBasis->services?unserialize($checkBasis->services):[];
		$studentServices = ServiceStatus::where(['student_id'=>$student->id])->where('expirated','>',DB::raw('NOW()'))->get()->pluck('service_id')->all();
		$boolean = true; // 判断是否全部满足条件
		foreach ($checkServices as $sid) {
			if (!in_array($sid,$studentServices)) {
				$boolean = false;
				break;
			}
		}
		if ($boolean) {
			$this->price = $checkBasis->discount_price;
		}
	}
	static function make (Products $product,Students $student,ProductRenewDiscount $checkBasis) {
		return new self ($product,$student,$checkBasis);
	}
	public function discountPrice(){
		return $this->price;
	}
}
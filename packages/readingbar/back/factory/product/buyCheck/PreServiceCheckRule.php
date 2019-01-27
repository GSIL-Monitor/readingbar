<?php 
namespace Readingbar\Back\Factory\Product\BuyCheck;

use Readingbar\Back\Models\Products;
use Readingbar\Back\Models\Students;
use Readingbar\Back\Models\ServiceStatus;
use Readingbar\Back\Models\ProductBuyCheck;
use DB;

class PreServiceCheckRule implements Rules{
	private $check = true;
	private $message = '';
	public function __construct(Products $product,Students $student, ProductBuyCheck $checkBasis){
		$hasServiceIds = ServiceStatus::where(['service_status.student_id'=>$student->id])
			->where('service_status.expirated','>',DB::raw('NOW()'))
			->get(['service_id'])
			->pluck('service_id')
			->all();
		$checkServiceIds = $checkBasis->array?unserialize($checkBasis->array):null;
		if ($checkServiceIds) {
			switch ($checkBasis->type) {
				case 1: // 购买前必须拥有的前置服务
					$this->check = false;
					foreach ($checkServiceIds as $id) {
					   if (in_array($id,$hasServiceIds)) {
					   	  $this->check = true;
					   	  break;
					   }
					}
					break;
				case 2: // 购买前不能拥有的前置服务
					$this->check = true;
					foreach ($checkServiceIds as $id) {
						if (in_array($id,$hasServiceIds)) {
							$this->check = false;
							break;
						}
					}
					break;
			}
		}
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
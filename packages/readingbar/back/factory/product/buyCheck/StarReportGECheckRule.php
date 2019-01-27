<?php 
namespace Readingbar\Back\Factory\Product\BuyCheck;

use Readingbar\Back\Models\Products;
use Readingbar\Back\Models\Students;
use Readingbar\Back\Models\ServiceStatus;
use Readingbar\Back\Models\ProductBuyCheck;
use DB;
use Readingbar\Back\Models\StarReport;

class StarReportGECheckRule implements Rules{
	private $check = true;
	private $message = '';
	public function __construct(Products $product,Students $student, ProductBuyCheck $checkBasis){
		$maxGe=StarReport::where(['student_id'=>$student->id])->max('ge');
		$maxGe = $maxGe>0?$maxGe:0;
		if ($checkBasis->boolean) {
			$this->check = $maxGe >= $checkBasis->number;
		}else{
			$this->check = $maxGe <= $checkBasis->number;
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
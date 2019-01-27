<?php 
namespace Readingbar\Back\Factory\Product;

use Readingbar\Back\Models\Products;
use Readingbar\Back\Models\Students;
use Readingbar\Back\Models\ProductBuyCheck;
use Readingbar\Back\Factory\Product\BuyCheck\PreServiceCheckRule;
use Readingbar\Back\Factory\Product\BuyCheck\StarReportCheckRule;
use Readingbar\Back\Factory\Product\BuyCheck\BorrowPlanCheckRule;
use Readingbar\Back\Factory\Product\BuyCheck\StarReportGECheckRule;
use Readingbar\Back\Factory\Product\BuyCheck\AllowBuyCheckRule;
use Readingbar\Back\Factory\Product\BuyCheck\BoughtAnyByMemberCheckRule;
use Readingbar\Back\Factory\Product\BuyCheck\DefaultCheckRule;
use Readingbar\Back\Factory\Product\BuyCheck\WinterHolidayPlanCheckRule;
use Readingbar\Back\Models\ProductRenewDiscount;
use Readingbar\Back\Factory\Product\RenewDiscount\DuringServicePeriod;
use Readingbar\Back\Factory\Product\RenewDiscount\AfterEndOfServicePeriod;
use Readingbar\Back\Factory\Product\renewDiscount\AfterBuyProduct;

class ProductFactory{
	/**
	 * 购买前校验
	 * 
	 * 产品购买校验规则
	 * 1.必须拥有的前置服务校验
	 * 2.不能拥有的前置服务校验
	 * 3.未做过测试报告
	 * 4.有未完成的借阅计划
	 * 5.产品不可购买
	 * 6.GE值是否达标
	 * 7.曾购买过任意产品
	 * 8.有未完成的寒假阅读计划
	 * @author tangjiajia
	 */
	static function checkBeforeBuy(Products $product,Students $student){
		$checkBasises=ProductBuyCheck::where(['product_id'=>$product->id])->orderBy('display','asc')->get();
		$checkResult = '';
		if (count($checkBasises)) {
			$checkResult = new DefaultCheckRule($product);
			if ($checkResult->check()) {
				foreach ($checkBasises as $checkBasis) {
					switch ($checkBasis->type) {
						case 1:
						case 2:
							$checkResult = PreServiceCheckRule::make($product, $student, $checkBasis);
							break;
						case 3:
							$checkResult = StarReportCheckRule::make($product, $student, $checkBasis);
							break;
						case 4:
							$checkResult = BorrowPlanCheckRule::make($product, $student, $checkBasis);
							break;
						case 5:
							$checkResult = AllowBuyCheckRule::make($product, $student, $checkBasis);
							break;
						case 6:
							$checkResult = StarReportGECheckRule::make($product, $student, $checkBasis);
							break;
						case 7:
							$checkResult = BoughtAnyByMemberCheckRule::make($product, $student, $checkBasis);
							break;
						case 8:
							$checkResult = WinterHolidayPlanCheckRule::make($product, $student, $checkBasis);
							break;
						default: echo '校验规则不存在！';exit;
					}
					if (!$checkResult->check()) {
						break;
					}
				}
			}
			return $checkResult;
		}else{
			return new DefaultCheckRule($product);
		}
	}
	static function renewDiscountPrice (Products $product,Students $student){
		$checkBasises=ProductRenewDiscount::where(['product_id'=>$product->id])->orderBy('display','asc')->get();
		$price = 0;
		foreach ($checkBasises as $checkBasis){
			switch ($checkBasis->type) {
				case 1: 
					$price=DuringServicePeriod::make($product, $student, $checkBasis)->discountPrice();
					break;
				case 2: 
					$price=AfterEndOfServicePeriod::make($product, $student, $checkBasis)->discountPrice();
					break;
				case 3:
					$price=AfterBuyProduct::make($product, $student, $checkBasis)->discountPrice();
					break;
			}
			if ($price>0) {
				break;
			}
		}
		return $price;
	}
}
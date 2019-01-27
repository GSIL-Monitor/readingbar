<?php
namespace Readingbar\Back\Factory\Product\RenewDiscount;

use Readingbar\Back\Models\Products;
use Readingbar\Back\Models\Students;
use Readingbar\Back\Models\ProductRenewDiscount;

interface RenewDiscountRuleInterface{
	static function make (Products $product,Students $student,ProductRenewDiscount $checkBasis);
	public function discountPrice();
}
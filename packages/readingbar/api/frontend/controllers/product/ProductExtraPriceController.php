<?php

namespace Readingbar\Api\Frontend\Controllers\Product;
use App\Http\Controllers\Controller;
use Readingbar\Api\Frontend\Controllers\FrontController;
use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use Readingbar\Back\Models\ProductExtraPrice;

class ProductExtraPriceController extends FrontController
{
	/**
	 * 计算附加价格
	 * @param unknown $product_id   产品编号
	 * @param unknown $area  学生所在省份
	 * @return number 额外价格
	 */
	static function getExtraPrice($product_id,$area){
		$PEPs=ProductExtraPrice::where(['product_id'=>$product_id,'status'=>1])
			->get();
		$extraPrice=0.00;
		foreach ($PEPs as $PEP){
			switch($PEP->type){
				//区域类型计算
				case '1':
					$areas=explode(',',$PEP->areas);
					if(in_array($area,$areas)){
						$extraPrice+=$PEP->extra_price;
					}
					break;
			}
		}
		return $extraPrice;
	}
}

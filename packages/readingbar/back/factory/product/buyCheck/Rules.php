<?php 
namespace Readingbar\Back\Factory\Product\BuyCheck;

use Readingbar\Back\Models\Products;
use Readingbar\Back\Models\Students;
use Readingbar\Back\Models\ProductBuyCheck;

interface Rules{
	/**
	 * 设置校验参数
	 */
	static function make(Products $product,Students $student,ProductBuyCheck $checkBasis);
	/**
	 * 获取校验结果 
	 * return array
	 */
	public function result();
	/**
	 * 获取校验结果
	 * return boolean
	 */
	public function check();
	/**
	 * 获取校验结果
	 * return string
	 */
	public function message();
}
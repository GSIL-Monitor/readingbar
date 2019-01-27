<?php 
	namespace Packages\Pay\Facades;
	use Illuminate\Support\Facades\Facade;
	class WxPayFacade extends Facade{
		/**
		 * 获取组件注册名称
		 *
		 * @return string
		 */
		protected static function getFacadeAccessor() {
			return 'WxPay';
		}
	}
?>
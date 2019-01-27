<?php
return [

	// 安全检验码，以数字和字母组成的32位字符。
	'key' => 'uf43zo7pcwe074pbzvlnaiqrpsd0gvid',

	//签名方式
	'sign_type' => 'MD5',

	// 服务器异步通知页面路径。
	'notify_url' => 'https://www.readingbar.net/api/order/alipayNotifyUrl',

	// 页面跳转同步通知页面路径。
	'return_url' => 'https://www.readingbar.net/api/order/alipayReturnUrl'
];

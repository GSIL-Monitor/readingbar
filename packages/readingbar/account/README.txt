1.config/app.php 服务提供者
Readingbar\Account\AccountProvider::class,
 
2.composer.json
"Readingbar\\Account\\": "packages/readingbar/account",
3.config/auth 
	在 guards 键值内添加
	'member' => [
	    'driver' => 'member',
	    'provider' => 'users',
	],
	
4.composer dump-auto
5.php artisan vendor:publish

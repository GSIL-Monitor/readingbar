    
1.composer.json
Readingbar\Member\MemberProvider::class,

2.config/app.php

"Readingbar\\Member\\": "packages/readingbar/member",

3.app/http/kernel.php
 protected $middlewareGroups = [ 下添加
       
        'member' => [
	        \App\Http\Middleware\EncryptCookies::class,
	        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
	        \Illuminate\Session\Middleware\StartSession::class,
	        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
	        \App\Http\Middleware\VerifyCsrfToken::class,
	        \Readingbar\Member\Frontend\Middlewares\MemberMiddleware::class,
        ],

4.composer dump-auto

5.php artisan vendor:publish
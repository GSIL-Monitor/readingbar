1.config/app.php 服务提供者
Superadmin\Backend\SuperadminProvider::class,
Superadmin\Frontend\SuperadminFrontEndProvider::class,
2.app/Http/Kernel.php ---protected $middlewareGroups 

'pauth' => [
	        \App\Http\Middleware\EncryptCookies::class,
	        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
	        \Illuminate\Session\Middleware\StartSession::class,
	        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
	        \App\Http\Middleware\VerifyCsrfToken::class,
	        \Superadmin\Backend\Middleware\Authenticate::class,
	        \Superadmin\Backend\Middleware\LocaleMiddleware::class,
],
        
3.composer.json  "psr-4"
"Superadmin\\Backend\\": "packages/star2003/superadmin/Backend",
"Superadmin\\Frontend\\": "packages/star2003/superadmin/Frontend"
4. composer dump-autoload

5. /admin/install

6. /admin
admin@star2003.com
123456
   
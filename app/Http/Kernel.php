<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Readingbar\Front\Middlewares\ThemeMiddleware::class,
        	\Readingbar\Api\Frontend\Middlewares\PartnerMiddleware::class,
        	\Readingbar\Front\Middlewares\AccessLogMiddleware::class,
			\Readingbar\Api\Frontend\Middlewares\FirstLoginMiddleware::class
        ],
        'member' => [
	        \Readingbar\Api\Frontend\Middlewares\MemberMiddleware::class,
        	\Readingbar\Api\Frontend\Middlewares\PreStepMiddleware::class,
        ],
        'pauth' => [
	        \App\Http\Middleware\EncryptCookies::class,
	        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
	        \Illuminate\Session\Middleware\StartSession::class,
	        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
	        \App\Http\Middleware\VerifyCsrfToken::class,
	        \Superadmin\Backend\Middleware\Authenticate::class,
	        \Superadmin\Backend\Middleware\LocaleMiddleware::class,
        	\Superadmin\Backend\Middleware\LocaleMiddleware::class,
        	\Readingbar\Back\Middlewares\ShareMiddleware::class,
			\Readingbar\Front\Middlewares\AccessLogMiddleware::class,
        ],
        'api' => [
            'throttle:200,1',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'can' => \Illuminate\Foundation\Http\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    	'access_log'=>\Readingbar\Front\Middlewares\AccessLogMiddleware::class,
    ];
}

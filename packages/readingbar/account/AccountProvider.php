<?php

namespace Readingbar\Account;

use Illuminate\Support\ServiceProvider;
use Readingbar\Account\Frontend\Guard\MemberGuard;
use Readingbar\Account\Frontend\Services\QQ_OAuth;
use Auth;
class AccountProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {	
       $this->loadViewsFrom(__DIR__.'/frontend/views', 'Readingbar/account/frontend');
       $this->publishes([
       		__DIR__.'/frontend/lang' => base_path('resources/lang'),
       ]);
       //guard
//        Auth::extend('member', function($app, $name, array $config) {
//        		return new MemberGuard($app);
//        });
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {	
    	//routes
   		include __DIR__."/routes/AccountRoutes.php";	
    }
}

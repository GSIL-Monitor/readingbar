<?php

namespace Readingbar\Api;

use Illuminate\Support\ServiceProvider;
use Readingbar\Api\Frontend\Guard\MemberGuard;
use Auth;
class ApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/lang', 'apilang');
        $this->registerGuard();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        require 'ApiRoutes.php';
    }
    /**
     * 
     */
    public function registerGuard(){
    	//guard
    	Auth::extend('member', function($app, $name, array $config) {
    		return new MemberGuard($name,Auth::createUserProvider($config['provider']),$app['session.store'],$app['cookie'],$app['request']);
    	});
    }
}

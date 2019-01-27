<?php

namespace Tools\Oauth;

use Illuminate\Support\ServiceProvider;
use Artisan;
use Illuminate\Filesystem\Filesystem;
class OauthProvider extends ServiceProvider
{
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;
	
	/**
	 * The console commands.
	 *
	 * @var bool
	 */
	protected $commands = [
		
	];
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    	 $this->commands($this->commands);
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    	include __DIR__.'/route.php';
    	$this->app->bind('Oauth', function ($app) {
    		return new OauthHelper($app);
    	});
    }
}

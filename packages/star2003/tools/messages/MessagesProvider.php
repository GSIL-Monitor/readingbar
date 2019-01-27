<?php

namespace Tools\Messages;

use Illuminate\Support\ServiceProvider;
use Artisan;
use Illuminate\Filesystem\Filesystem;
class MessagesProvider extends ServiceProvider
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
    	 $this->loadViewsFrom(__DIR__.'/views', 'messages');
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
    	$this->app->bind('Messages', function ($app) {
    		return new MessagesHelper($app);
    	});
    }
}

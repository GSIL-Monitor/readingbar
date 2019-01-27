<?php

namespace Tools\Pcurd\Backend;

use Illuminate\Support\ServiceProvider;
use Artisan;
class ToolsProvider extends ServiceProvider
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
		'Tools\Pcurd\Backend\Console\Commands\CreatePackage'
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

    }
}

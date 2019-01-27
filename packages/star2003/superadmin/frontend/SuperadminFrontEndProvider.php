<?php

namespace Superadmin\Frontend;

use Illuminate\Support\ServiceProvider;
use Artisan;
class SuperadminFrontendProvider extends ServiceProvider
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
		'Superadmin\Backend\Console\Commands\Superadmin'
	];
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
      
       $this->loadViewsFrom(__DIR__.'/views', 'superadmin/frontend');
//        $this->commands($this->commands);
//        view()->composer(
//        		'superadmin/backend::layouts.sidebar', 'Superadmin\Backend\ViewComposers\Sidebar'
//        );

    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__.'/routes.php';
       
    }
  
}

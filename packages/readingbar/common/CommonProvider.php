<?php

namespace Readingbar\Common;

use Illuminate\Support\ServiceProvider;
class CommonProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {	
       $this->loadViewsFrom(__DIR__.'/frontend/views', 'Readingbar/common/frontend');
       $this->publishes([
       		//__DIR__.'/frontend/lang' => base_path('resources/lang'),
       		__DIR__.'/frontend/lang' => base_path('resources/lang'),
       ]);
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

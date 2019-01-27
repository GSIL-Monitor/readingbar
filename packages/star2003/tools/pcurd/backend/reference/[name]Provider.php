<?php

namespace [vendor]\[ucfirst_name];

use Illuminate\Support\ServiceProvider;
class [ucfirst_name]Provider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
       $this->loadViewsFrom(__DIR__.'/backend/views', '[vendor]/[name]/backend');
       $this->publishes([
       		__DIR__.'/backend/lang' => base_path('resources/lang'),
       ]);
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {	
    	//routes
    	include __DIR__."/routes/[ucfirst_model]Routes.php";
    }
}

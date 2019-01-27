<?php

namespace Readingbar\Bookmanager;

use Illuminate\Support\ServiceProvider;
class BookmanagerProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
       $this->loadViewsFrom(__DIR__.'/backend/views', 'Readingbar/bookmanager/backend');
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
    	include __DIR__."/routes/BookmanagerRoutes.php";
    }
}

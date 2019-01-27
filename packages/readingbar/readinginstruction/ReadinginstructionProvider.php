<?php

namespace Readingbar\Readinginstruction;

use Illuminate\Support\ServiceProvider;
class ReadinginstructionProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
       $this->loadViewsFrom(__DIR__.'/backend/views', 'Readingbar/readinginstruction/backend');
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
   		include __DIR__."/routes/ReadinginstructionRoutes.php";
    	include __DIR__."/routes/Readinginstruction.php";
    }
}

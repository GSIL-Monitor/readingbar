<?php

namespace Readingbar\Survey;

use Illuminate\Support\ServiceProvider;
class SurveyProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {	
       $this->loadViewsFrom(__DIR__.'/frontend/views', 'Readingbar/survey/frontend');
       $this->loadViewsFrom(__DIR__.'/backend/views', 'Readingbar/survey/backend');
       $this->publishes([
       		//__DIR__.'/frontend/lang' => base_path('resources/lang'),
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
   		include __DIR__."/routes/SurveyRoutes.php";
    }
}

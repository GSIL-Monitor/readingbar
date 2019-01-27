<?php

namespace Readingbar\Teacher;

use Illuminate\Support\ServiceProvider;
class TeacherProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
       $this->loadViewsFrom(__DIR__.'/backend/views', 'Readingbar/teacher/backend');
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
   		include __DIR__."/routes/TstudentsRoutes.php";
    	include __DIR__."/routes/FavoritesRoutes.php";
    	include __DIR__."/routes/TeacherRoutes.php";
    	include __DIR__."/routes/StarRoutes.php";
    }
}

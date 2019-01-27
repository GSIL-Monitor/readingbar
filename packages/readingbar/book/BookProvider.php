<?php

namespace Readingbar\Book;

use Illuminate\Support\ServiceProvider;
class BookProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
       $this->loadViewsFrom(__DIR__.'/backend/views', 'Readingbar/book/backend');
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
   		include __DIR__."/routes/BooksRoutes.php";
    }
}

<?php
namespace Readingbar\Bookcomment;

use Illuminate\Support\ServiceProvider;
class BookcommentProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {	
        $this->loadViewsFrom(__DIR__.'/frontend/views', 'Readingbar/bookcomment/frontend');
        $this->loadViewsFrom(__DIR__.'/backend/views', 'Readingbar/bookcomment/backend');
       $this->publishes([
       		__DIR__.'/frontend/lang' => base_path('resources/lang'),
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
   		include __DIR__."/routes/Book_commentRoutes.php";
   		include __DIR__."/route.php";
    }
}

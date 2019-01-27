<?php

namespace Readingbar\Back;

use Illuminate\Support\ServiceProvider;

class BackServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'back');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        require 'BackRoutes.php';
    }
}

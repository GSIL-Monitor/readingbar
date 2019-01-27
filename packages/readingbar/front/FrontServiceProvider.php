<?php

namespace Readingbar\Front;

use Illuminate\Support\ServiceProvider;

class FrontServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'front');
        view()->composer(['front::default.common.main','front::mobile.common.main','front::responsive.common.main','front::mobile.common.main2l','front::mobile.common.mainUC'],'Readingbar\Front\Composer\SettingComposer');
        
        view()->composer(['front::default.home.home','front::default.common.footer'],'Readingbar\Front\Composer\FriendlyLinksComposer');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        require 'FrontRoutes.php';
    }
}

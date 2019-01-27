<?php

namespace Packages\Pay;

use Illuminate\Support\ServiceProvider;

class PayProvider extends ServiceProvider
{
	protected $services = [
			'WxPay'      => 'Packages\\Pay\\Wxpay\\Services\\WxPay',
	];
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
      
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
     	foreach ($this->services as $alias => $service) {
            $this->app->singleton([$service => $alias], function($app) use ($service){
                return new $service();
            });
        }
    }
}

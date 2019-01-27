<?php

namespace Superadmin\Backend;

use Illuminate\Support\ServiceProvider;
use Artisan;
use Validator;
class SuperadminProvider extends ServiceProvider
{
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;
	
	/**
	 * The console commands.
	 *
	 * @var bool
	 */
	protected $commands = [
		'Superadmin\Backend\Console\Commands\Superadmin'
	];
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
       $this->validators();
       $this->loadViewsFrom(__DIR__.'/views', 'superadmin/backend');
       $this->commands($this->commands);
       view()->composer(
       		'superadmin/backend::layouts.sidebar', 'Superadmin\Backend\ViewComposers\Sidebar'
       );
       $this->publishes([
       		__DIR__.'/public' => base_path('public'),
       		__DIR__.'/lang' => base_path('resources/lang'),
       		__DIR__.'/config' => base_path('/config'),
       ]);
       
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__.'/routes.php';
        $this->registerAccess();
    }
    //权限服务
	private function registerAccess()
    {
        $this->app->bind('access', function ($app) {
            return new Services\Access\Access($app);
        });
    }
    // 自定义验证规则
    private function validators() {
    	Validator::extend('ext', function($attribute, $value, $parameters) {
    		$parameters=explode(',',strtolower(implode(',',$parameters)));
    		if(in_array(strtolower($value->extension()),$parameters)){
    			return true;
    		}else {
    			return false;
    		}
    	});
    	Validator::replacer('ext', function($message, $attribute, $rule, $parameters) {
    			return str_replace('{exts}',implode(',',$parameters),$message);
    	});
    }
}

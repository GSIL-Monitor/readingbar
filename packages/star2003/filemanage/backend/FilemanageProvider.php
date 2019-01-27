<?php

namespace Filemanage\Backend;

use Illuminate\Support\ServiceProvider;
use Artisan;
use Illuminate\Filesystem\Filesystem;
class FilemanageProvider extends ServiceProvider
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
		'Filemanage\Backend\Console\Commands\Filemanage'
	];
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'filemanage/backend');
        $this->commands($this->commands);
        $this->publishes([
        		__DIR__.'/lang' => base_path('/resources/lang'),
        		__DIR__.'/public' => base_path('/public'),
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
    }
	//上传文件目录修改
}

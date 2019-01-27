<?php

namespace Filemanage\Backend\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use Artisan;
class Filemanage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'filemanage:install  {--i}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install filemanage';
    /**
     * Filesystem  class.
     * @var object
     */
    protected $file;
    /**	
     * Create a new command instance.
     *
     * @return void
     */
    
    public function __construct(Filesystem $file)
    {
        parent::__construct();
        $this->file = $file;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    	//发布filemanage
    	$ms=Artisan::call('vendor:publish',[
    		'--provider' => 'Filemanage\Backend\FilemanageProvider',
    		'--force' => true
    	]);
    	//修改文件管理目录
    	$filesystemsDir=base_path("/config/filesystems.php");
    	if($this->file->exists($filesystemsDir)){
    		$content=$this->file->get($filesystemsDir);
    		$content=str_replace("'root' => storage_path('app'),","'root' => public_path('uploads'),",$content);
    		$this->file->put($filesystemsDir,$content);
    	}
    	echo "Filemanage installed!";
    }
}

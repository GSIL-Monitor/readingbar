<?php

namespace Tools\Pcurd\Backend\Console\Commands;

use Illuminate\Console\Command;
use Tools\Pcurd\Backend\ReferenceHelper;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use Artisan;
use Superadmin\Backend\Models\Access;
use Superadmin\Backend\Models\Menu;
use Cache;
class CreatePackage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:create {vendor} {name} {model} {--i}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new package';
    /**
     * ReferenceHelper  class.
     * @var object
     */
    protected $helper;
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
    
    public function __construct(ReferenceHelper $helper,Filesystem $file)
    {
        parent::__construct();
        $this->helper = $helper;
        $this->file = $file;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    	//获取参数
    	$vendor = $this->argument('vendor');
    	$name = $this->argument('name');
    	$model = $this->argument('model');
    	//创建目录
    	$newPackageDir=base_path("packages/".$vendor."/".$name);
    	if(!$this->file->exists($newPackageDir)){
    		mkdir($newPackageDir, 0777, true);
    		echo "Package dir created ! \n";
    	}else{
    		echo "The Package dir existed! \n";
    	}
    	//拷贝包的参考结构
    	$reference=base_path("packages/star2003/tools/pcurd/backend/reference");
    	$this->file->copyDirectory($reference,$newPackageDir);
    	echo "Reference copied ! \n";
    	//修改参考文件内容
    	$this->helper->init($vendor,$name,$model,$newPackageDir,$this->file);
    	
    	//注册composer.json
    	$content=$this->file->get('composer.json');
    	$replace='"psr-4": {';
    	$packageInfo="\"".ucfirst($vendor)."\\\\".ucfirst($name)."\\\\\":\"packages/".$vendor."/".$name."\",";
    	if(!strpos($content,$packageInfo)){
    		$content=str_replace($replace,$replace."
    		".$packageInfo,$content);
    		$content=$this->file->put('composer.json',$content);
    	}else{
    		echo "Info existed in composer.json!\n";
    	}
    	
    	//注册config/app.php
    	$content=$this->file->get('config/app.php');
    	$replace="'providers' => [";
    	$providerInfo=ucfirst($vendor)."\\".ucfirst($name)."\\".ucfirst($name)."Provider::class,";
    	if(!strpos($content,$providerInfo)){
    		$content=str_replace($replace,$replace."
    	".$providerInfo,$content);
    		$content=$this->file->put('config/app.php',$content);
    	}else{
    		echo "Info existed in config/app.php!\n";
    	}
    	//注册权限
    	if(!Access::where("access","=","admin.$model")->count()){
    		$access=array(
    				'name'=>$model,
    				'access'=>"admin.$model",
    		);
    		Access::create($access);
    		
    	}
    	//注册菜单
    	if(!Menu::where("access","=","admin.$model")->count()){
    		$menu=array(
    			'name'=>$model,
    			'access'=>"admin.$model",
    			'url'=>"admin/$model",
    			'pre_id'=>'1',
    			'rank'=>'2',
    			'status'=>'1',
    			'display'=>'3',
    			'icon'=>'',
	    	);
	    	Menu::create($menu);
    	}
    	Cache::flush();
    	echo "Success!";
    	
    	
    }
}

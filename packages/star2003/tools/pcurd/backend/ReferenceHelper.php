<?php

namespace Tools\Pcurd\Backend;
use DB;
/**
 * Helper functions for the Packager commands.
 *
 * @package Packager
 * @author JeroenG
 * 
 **/
class ReferenceHelper
{
   private $vendor;
   private $name;
   private $dir;
   private $file;
   private $model;
   private $columns;
   public function init($vendor,$name,$model,$dir,$file){
   		$this->vendor=$vendor;
   		$this->name=$name;
   		$this->dir=$dir;
   		$this->file=$file;
   		$this->model=$model;
   		$this->getColumns();
   		$this->modifyModel();
   		$this->modifyView();
   		$this->modifyController();
   		$this->modifyLanguage();
   		$this->modifyRoutes();
   		$this->modifyProvider();
   }
   //修改服务提供者
   public function modifyProvider(){
   		$d=$this->dir."/[name]Provider.php";
   	    $newProvider=str_replace('[name]',ucfirst($this->name),$d);
   		if($this->file->exists($newProvider)){
   			$this->file->delete($d);
   			$content=$this->file->get($newProvider);
   			$route="
   		include __DIR__.\"/routes/".ucfirst($this->model)."Routes.php\";";
   			$content=str_replace('//routes','//routes'.$route,$content);
   			$this->file->put($newProvider,$content);
   		}else{
   			$content=$this->file->get($d);
   			$this->file->put($d,$this->replaceTag($content));
   			rename($d,$newProvider);
   		}
   		echo "Provider success!\n";
   }
   //修改路由
   public function modifyRoutes(){
	   	$d=$this->dir."/routes/[model]Routes.php";
	   	$content=$this->file->get($d);
	   	$this->file->put($d,$this->replaceTag($content));
	   	rename($d,str_replace('[model]',ucfirst($this->model),$d));
	   	echo "Routes success!\n";
   }
   //修改模型
   public function modifyModel(){
	   	$d=$this->dir."/backend/models/[model].php";
	   	$content=$this->file->get($d);
	   	$this->file->put($d,$this->replaceTag($content));
	   	rename($d,str_replace('[model]',ucfirst($this->model),$d));
	   	echo "Model success!\n";
   }
   //修改视图
   public function modifyView(){
	   	$d=$this->dir."/backend/views/[model]_form.blade.php";
	   	$content=$this->file->get($d);
	   	preg_match('/\[input\]([\s\S]*)\[\/input\]/',$content,$match);
	    $input='';
	  
	   	foreach ($this->columns['columns'] as $column){
	   		$input.=str_replace('[column]',$column,$match[1])."
	   				";
	   	}
	   	$content=preg_replace('/\[input\]([\s\S]*)\[\/input\]/',$input,$content);
	   	$this->file->put($d,$this->replaceTag($content));
	   	rename($d,str_replace('[model]',$this->model,$d));
	   	
	   	$d=$this->dir."/backend/views/[model]_list.blade.php";
	   	$content=$this->file->get($d);
	   	$this->file->put($d,$this->replaceTag($content));
	   	rename($d,str_replace('[model]',$this->model,$d));
	   	echo "View success!\n";
   }
   //修改控制器
   public function modifyController(){
	   	$d=$this->dir."/backend/controllers/[model]Controller.php";
	   	$content=$this->file->get($d);
	   	$this->file->put($d,$this->replaceTag($content));
	   	rename($d,str_replace('[model]',ucfirst($this->model),$d));
	   	echo "Controller success!\n";
   }
   //修改语言文件
   public function modifyLanguage(){
   		$lang="<?php
    return [
        'menu_title' =>'". $this->name."',
        'head_title'=>'".$this->name." Manager',
        'column_id'=>'ID#',
            ";
   		foreach ($this->columns['columns'] as $column){
   			$lang.="'column_".$column."'=>'".$column."',
   	    ";
   		}
   		$lang.="
        'column_created_at'=>'Created time',
   		'column_updated_at'=>'Updated time',
   		    
   		'list_title'=>'[model] List',
   		 'form_title'=>'[model] Form',
		];";
   		
   		//英文
	   	$d=$this->dir."/backend/lang/en/[model].php";
	   	$this->file->put($d,$this->replaceTag($lang));
	   	rename($d,str_replace('[model]',ucfirst($this->model),$d));
	   	//中文
	   	$d=$this->dir."/backend/lang/zh/[model].php";
	   	$this->file->put($d,$this->replaceTag($lang));
	   	rename($d,str_replace('[model]',ucfirst($this->model),$d));
	   	
	   	echo "Language success!\n";
	   	$this->file->copyDirectory($this->dir."/backend/lang",base_path('resources/lang'));
	   	echo "Language copy to resources/lang!\n";
   }
   //替换标签
   public function replaceTag($content){
   		$content=str_replace('[ucfirst_name]',ucfirst($this->name),$content);
   		$content=str_replace('[name]',$this->name,$content);
   		$content=str_replace('[ucfirst_model]',ucfirst($this->model),$content);
   		$content=str_replace('[model]',$this->model,$content);
   		$content=str_replace('[vendor]',ucfirst($this->vendor),$content);
   		$content=str_replace('[model_columns]',$this->columns['model_columns'],$content);
   		$content=str_replace('[list_columns]',$this->columns['list_columns'],$content);
   		$content=str_replace('[update_columns]',$this->columns['update_columns'],$content);
   		$content=str_replace('[store_columns]',$this->columns['store_columns'],$content);
   		return $content;
   }
   //获取数据表字段
   public function getColumns(){
   		$columns=array();
   		foreach (DB::select("SHOW FULL COLUMNS FROM ".$this->model."") as $v){
   			$columns[]=$v->Field;
   		}
   		$this->columns['columns']=array_diff($columns,array('id','created_at','updated_at'));
   		//model_columns
   		$model_columns=array_diff($columns,array('id','created_at','updated_at'));
   		$this->columns['model_columns']="array('".implode("','",$model_columns)."')";
   		//list_columns
   		$list_columns=array_diff($columns,array());
   		$this->columns['list_columns']="array('".implode("','",$list_columns)."')";
   		//update_columns
   		$update_columns=array_diff($columns,array('id','created_at','updated_at'));
   		$this->columns['update_columns']="array('".implode("','",$update_columns)."')";
   		//store_columns
   		$store_columns=array_diff($columns,array('id','created_at','updated_at'));
   		$this->columns['store_columns']="array('".implode("','",$store_columns)."')";
   }
}
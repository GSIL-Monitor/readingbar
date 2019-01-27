<?php

namespace Filemanage\Backend\Controllers;

use App\Http\Controllers\Controller;
use Filemanage\Backend\StorageHelper;
use Illuminate\Http\Request;

class FilemanageController extends Controller
{	
	private $storage;
	private $breadcrumbs=array(
			array('name'=>'home','url'=>'admin','active'=>false),
			array('name'=>'system','url'=>'','active'=>false),
			array('name'=>'upload','url'=>'admin/upload','active'=>true),
	);
	public function __construct(StorageHelper $storage){
		$this->storage=$storage;
	}
    /**
     * Show page of files / subfolders
     */
    public function index(Request $request)
    {
        $folder = $request->get('folder');     
        $data['breadcrumbs']=$this->breadcrumbs;
        $data['head_title']=trans("filemanage.head_title");
        return view("filemanage/backend::index",$data);
    }
    public function operations(Request $request){
    	switch($request->input('operation')){
    		case 'get_folders':$this->get_folders($request);break;
    		case 'get_files'  :$this->get_files($request);break;
    		case 'create_node':$this->create_node($request);break;
    		case 'rename_node':$this->rename_node($request);break;
    		case 'delete_node':$this->delete_node($request);break;
    		case 'load_filemanage_html':return $this->load_filemanage_html($request);break;
    		case 'demo':return $this->demo($request);break;
    	}
    }
    public function load_filemanage_html(){
    	$data=array();
    	return view("filemanage/backend::filemanage",$data);
    }
    public function demo(){
    	$data=array();
    	$data['breadcrumbs']=$this->breadcrumbs;
    	$data['head_title']=trans("filemanage.head_title");
    	return view("filemanage/backend::demo",$data);
    }
    public function get_folders($request){
    	$info=$this->storage->folderDetails($request->input('id'),$request->input('filetype'));
    	echo json_encode($info);
    }
    public function get_files($request){
    	$info=$this->storage->getFileDetail($request->input('id'),$request->input('filetype'));
    	echo json_encode($info);
    }
    public function create_node($request){
    	$dir=$request->input('id');
    	$text=$request->input('text');
    	$r=$this->storage->newFolder($dir,$text);
    	if($r){
    		echo json_encode(['id'=>$dir.'/'.$text]);
    	}else{
    		
    	}
    }
    public function rename_node($request){
    	$old=$request->input('id');
    	$text=$request->input('text');
    	$new=str_replace(basename($old),$text,$old);
    	$r=$this->storage->rename($old,$new);
    	if($r){
    		echo json_encode(['id'=>$new]);
    	}else{
    		echo false;
    	}
    }
    public function delete_node($request){
    	$dir=$request->input('id');
    	$r=$this->storage->delete($dir);
    }
    public function file_upload(Request $request){
    	if(!$request->input('jstree_path')){
    		echo "<script>alert('请选择上传文件夹！')</script>";
    		return;
    	}
    	
    	echo "<meta charset='utf8'>";
    	if(!$request->hasFile('uploadfile')){
    		exit('<script>alert("上传文件为空！");</script>');
    	}
    	$file = $request->file('uploadfile');
    	//判断文件上传过程中是否出错
    	if(!$file->isValid()){
    		exit('<script>alert("文件上传出错！");</script>');
    	}
    	$newFileName = $file->getClientOriginalName();
    	$savePath = $request->input('jstree_path')."/".$newFileName;
    	$this->storage->saveFile($savePath,file_get_contents($file->getRealPath()));
    	
    	echo "<script>window.parent.refleshJstree();</script>";
		//return redirect()->back();
    }
}
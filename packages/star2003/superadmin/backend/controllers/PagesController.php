<?php

namespace Superadmin\Backend\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Storage;
use Illuminate\Filesystem\Filesystem;
class PagesController extends Controller
{
	private $base_dir;
	private $file;
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'pages.head_title','url'=>'admin/role','active'=>true),
	);
	public function __construct(Filesystem $file){
		$this->base_dir= $this->dellDir(str_replace("\\backend\\controllers","\\frontend\\views",__DIR__));
		$this->file=$file;
	}
	public function index(Request $request){
		$data=array();
		$data['success']=$request->session()->get('success');
		$data['error']=$request->session()->get('error');
		$data['head_title']=trans('pages.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		return view("superadmin/backend::pages.pages_list",$data);
	}
	public function operations(Request $request){
		switch($request->input("operation")){
			case 'get_folders':$this->get_folders($request);break;
			case 'get_files':$this->get_files($request);break;
			case 'create_node':$this->create_node($request);break;
			case 'rename_node':$this->rename_node($request);break;
			case 'delete_node':$this->delete_node($request);break;
			case 'move_node':$this->move_node($request);break;
			case 'copy_node':$this->copy_node($request);break;
		
			case 'edit_file':return $this->edit_file($request);break;
			case 'save_file':return $this->save_file($request);break;
			case 'static_file':return $this->static_file($request);break;
		}
	}
	public function get_folders($request){
		$dir=$this->dellDir($request->input("direct"));
		if(!$dir || $dir=='#' || $dir==''){
			$folders=$this->file->directories($this->base_dir);
		}else{
			$folders=$this->file->directories($this->base_dir."/".$dir);
		}
		$json=array();
		foreach ($folders as $folder){
			$json[]=array(
					'id'=>str_replace($this->base_dir."/","",$this->dellDir($folder)),
					'text'=>basename($folder),
					'children'=>count($this->file->directories($folder))?true:count($this->file->files($folder))?true:false
			);
		}
		$files=$this->file->files($this->base_dir."/".$dir);
		foreach ($files as $file){
			if(preg_match('/\.blade\.php/',basename($file))){
				$json[]=$this->fileDetail($file);
			}
		}

		echo json_encode($json);
	}
	public function create_node($request){
		$id=$this->dellDir($request->input("id"));
		$text=$this->dellDir($request->input("text"));
		$type=$request->input("type");
		if(!$id || $id=='#' || $id==''){
			$dir=$this->base_dir.'/'.$text;
		}else{
			$dir=$this->base_dir."/".$id."/".$text;
		}
		switch ($type){
			case 'default':$this->file->makeDirectory($dir);break;
			case 'html':$this->file->put($dir,'');break;
		}
		$json=array('id'=>$id."/".$text);
		echo json_encode($json);
	}
	public function rename_node($request){
		$old=$this->dellDir($request->input("id"));
		$text=$request->input("text");

		$old_arr=explode('/',$old);
		$old_arr[count($old_arr)-1]=$text;
		$new=implode('/',$old_arr);
		
		rename($this->base_dir."/".$old,$this->base_dir."/".$new);
		$json=array('id'=>$new);
		echo json_encode($json);
	}
	public function delete_node($request){
		$id=$this->dellDir($request->input("id"));
		$text=$request->input("text");
		if($this->file->isFile($this->base_dir."/".$id)){
			$this->file->delete($this->base_dir."/".$id);
		}
		if($this->file->isDirectory($this->base_dir."/".$id)){
			$this->file->deleteDirectory($this->base_dir."/".$id);
		}
		
		
		$json=array('id'=>$id);
		echo json_encode($json);
	}
	public function move_node($request){
		$id=$this->base_dir."/".$this->dellDir($request->input("id"));
		$parent=$this->base_dir."/".$this->dellDir($request->input("parent"));
		if($this->file->isDirectory($id) && $this->file->isDirectory($parent)){
			if($this->file->moveDirectory($id,$parent)){
				echo "success";
			}else{
				echo "failed";
			}
		}
		if($this->file->isFile($id) && $this->file->isDirectory($parent)){
			if($this->file->moveDirectory($id,$parent)){
				echo "success";
			}else{
				echo "failed";
			}
		}
	}
	public function copy_node($request){
		$id=$this->base_dir."/".$this->dellDir($request->input("id"));
		$parent=$this->base_dir."/".$this->dellDir($request->input("parent"));
		if($this->file->isDirectory($id) && $this->file->isDirectory($parent)){
			if($this->file->copyDirectory($id,$parent)){
				echo "success";
			}else{
				echo "failed";
			}
		}
	}
	public function get_files($request){
		$direct=$this->dellDir($request->input("direct"));
		$files=$this->file->files($this->base_dir."/".$direct);

		$json=array();
		foreach ($files as $file){
			if(preg_match('/\.blade\.php/',basename($file))){
				$json[]=$this->fileDetail($file);
			}
		}
		echo json_encode($json);
	}
	public function edit_file($request){
		$direct=$this->dellDir($request->input("direct"));
		if($this->file->exists($this->dellDir($this->base_dir."/".$direct))){
			$data=array();
			$data['direct']=$direct;
			$data['content']=$this->file->get($this->dellDir($this->base_dir."/".$direct));
			$data['breadcrumbs']=$this->breadcrumbs;
			$data['head_title']=trans('pages.head_title');
			return view("superadmin/backend::pages.pages_form",$data);
		}else{
			return redirect('admin/pages');
		}
	}
	public function save_file($request){
		$direct=$this->dellDir($request->input("direct"));
		if($this->file->exists($this->dellDir($this->base_dir."/".$direct))){
			$this->file->put($this->dellDir($this->base_dir."/".$direct),$request->input('content'));
			$request->session()->flash('success', trans('pages.success_file_save'));
		}else{
			$request->session()->flash('error', trans('pages.error_file_unexist'));
			return redirect('admin/pages');
		}
		return redirect('admin/pages');
	}
	public function static_file($request){
		$direct=$this->dellDir($request->input("direct"));
		$view=str_replace('.blade.php','',$request->input('direct'));
		$view=str_replace('/','.',$view);
		if(!$this->file->isDirectory(public_path('pages'))){
			$this->file->makeDirectory(public_path('pages'));
		}
		$staticHtml=str_replace('.blade.php','',basename($request->input('direct'))).".html";
		$this->file->put(public_path('pages')."/".$staticHtml,view("superadmin/frontend::".$view));
		return redirect(url('pages/'.$staticHtml));
	}
	public function fileDetail($file){
		$r=array(
				'name'    =>basename($file),
				'text'    =>basename($file),
				'type'	  =>'file',
				'dir'     =>str_replace($this->base_dir."/",'',$this->dellDir($file)),
				'icon'   =>'fa fa-file-code-o',
				'id'     =>str_replace($this->base_dir."/",'',$this->dellDir($file)),
				'modified'=>date("Y-m-d H:i:s",$this->file->lastModified($file)),
				'webPath' =>url("view?direct=".str_replace($this->base_dir."/",'',$this->dellDir($file)))
		);
		return $r;
	}
	public function dellDir($dir){
		$dir=str_replace("\\\\", "/",$dir);
		$dir=str_replace("\\", "/",$dir);
		$dir=str_replace("//", "/", $dir);
		$dir=str_replace("/../", "/", $dir);
		$dir=str_replace("\\..\\", "/", $dir);
		return $dir;
	}
}
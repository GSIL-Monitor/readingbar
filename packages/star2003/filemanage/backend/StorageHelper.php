<?php 
namespace Filemanage\Backend;
use Storage;
use Illuminate\Filesystem\Filesystem;
class StorageHelper{
	private $disk;
	private $driver;
	private $root;
	private $webPath;
	private $file;
	function __construct($disk='local',Filesystem $file){
		$this->disk = Storage::disk($disk);
		$this->driver=config('filesystems.disks.'.$disk.'.driver');
		$this->root=config('filesystems.disks.'.$disk.'.root');
		$this->webPath=config('filesystems.disks.'.$disk.'.webPath');
		$this->file=$file;
	}
	//获取路径下的信息
	public function folderDetails($dir,$type=''){
		$dir=self::dellDir($dir);
		$folder=array();
		$files=array();
		$folder=$this->getFolderDetail($dir);
		if($dir!=''){
			$files=$this->getFileDetail($dir,$type);
		}else{
			$files=array();
		}
		$arr=array_merge($folder,$files);
		return $arr;
	}
	//获取文件夹详情
	public function getFolderDetail($dir){
		$folders=$this->disk->directories($dir);
		$foldersD=array();	
		foreach ($folders as $f){
			if(count($this->disk->directories($f)) || count($this->disk->files($f))){
				$children=true;
			}else{
				$children=false;
			}
			$foldersD[]=array(
					'text'=>basename($f),
					'id'  =>$f,
					'type'=>'folder',
					'modified'=>$this->disk->lastModified($f),
					'children'=>$children
			);
		}
		return $foldersD;
	}
	//获取文件详情
	public function getFileDetail($dir,$type=''){
		$files=$this->disk->files($dir);
		$filesD=array();
		foreach ($files as $f){
			$type=explode('/',$this->disk->mimeType($f))[0];
			if($type==''){
				$filesD[]=array(
					'text'=>basename($f),
					'id'  =>$f,
					'type'=>pathinfo($f)['extension'],
					'modified'=>$this->disk->lastModified($f),
					'href'	  =>url($f),
					'size'=>$this->disk->size($f),
				);
			}else if(explode('/',$this->disk->mimeType($f))[0]==$type){
				$filesD[]=array(
					'text'=>basename($f),
					'id'  =>$f,
					'type'=>pathinfo($f)['extension'],
					'modified'=>$this->disk->lastModified($f),
					'href'	  =>url($f),
					'size'=>$this->disk->size($f),
				);
			}
		}
		return $filesD;
	}
	/**
	 * 新增文件夹
	 * 
	 * input string,string
	 * return bool
	 * */
	public function newFolder($dir,$text){
		if($this->disk->exists($dir)){
			$this->disk->makeDirectory($dir."/".$text);
			return true;
		}else{
			return false;
		}
	}
	//删除文件和文件夹
	public function delete($dir){
		if($this->file->isFile($this->getFullPath($dir))){
			$this->disk->delete($dir);
		}else{
			$this->disk->deleteDirectory($dir);
		}
	}
	/**
	 * 文件重命名
	 * 
	 * input string,string
	 * return bool
	 * */
	public function rename($old,$new){
		if($this->disk->exists($old) && !$this->disk->exists($new)){
			$this->disk->rename($old,$new);
			return true;
		}else{
			return false;	
		}
	}
	/**
	 * 获取文件访问路径
	 */
	public function getWebPath($dir){
		if($this->webPath){
			return url($this->webPath."/".$dir);
		}else{
			return url($dir);
		}
	}
	/**
	 * 获取文件绝对路径
	 */
	public function getFullPath($dir){
		return $this->root.$this->webPath.'/'.$dir;
	}
	//剔除特定字符
	public function dellDir($dir){
		$dir=str_replace('..','',$dir);
		$dir=str_replace('//','/',$dir);
		$dir=str_replace('#','',$dir);
		return $dir;
	}
	public function saveFile($dir,$content){
		$this->disk->put($dir,$content);
	}
}
?>
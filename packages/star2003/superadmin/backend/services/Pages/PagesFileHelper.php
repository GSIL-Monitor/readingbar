<?php

namespace Filemanage\Backend\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class PagesFileHelper
{
    protected $disk;


    public function __construct()
    {
        $this->disk = Storage::disk(config('blog.uploads.storage'));
    }

    /**
     * 返回当前文件夹目录
     */
	public function directories($direct){
		$directories=Storage::directories($direct);
		foreach ($directories as $d){
			$return[]=array(
					"text"=>basename($d),
					"id"=>$d,
					"type"=>"folder",
					"icon"=>"fa fa-folder",
					"children"=>count(Storage::directories($direct."/".basename($d)))?true:false
			);
		}
		return $return;
	}
	/**
	 * 返回所有文件
	 */
	public function files($direct){
		$filesDirects=Storage::files($direct);
		$files=array();
		foreach ($filesDirects as $path) {
			$files[] = $this->fileDetails($path);
		}
		return $files;
	}
    /**
     * Sanitize the folder name
     */
    protected function cleanFolder($folder)
    {
        return '/' . trim(str_replace('..', '', $folder), '/');
    }
    /**
     * 返回文件详细信息数组
     */
    protected function fileDetails($path)
    { 
        $path = '/' . ltrim($path, '/');

        return [
            'name' => basename($path),
            'fullPath' => $path,
            'webPath' => $this->fileWebpath($path),
            'mimeType' => $this->fileMimeType($path),
            'size' => $this->fileSize($path),
            'modified' => $this->fileModified($path),
        ];
    }

    /**
     * 返回文件完整的web路径
     */
    public function fileWebpath($path)
    { 
        $path = rtrim(config('blog.uploads.webpath'), '/') . '/' .ltrim($path, '/');
        return url($path);
    }

    /**
     * 返回文件MIME类型
     */
    public function fileMimeType($path)
    {
       
    }

    /**
     * 返回文件大小
     */
    public function fileSize($path)
    {
        return $this->disk->size($path);
    }

    /**
     * 返回最后修改时间
     */
    public function fileModified($path)
    {
        return Carbon::createFromTimestamp(
            $this->disk->lastModified($path)
        );
    }
    /**
     * 创建目录
     */
    public function createFolder($directory){
    	if(!$this->disk->exists($directory)){
    		Storage::makeDirectory($directory);
    		return true;
    	}else{
    		return false;
    	}
    }
    /**
     * 删除目录
     */
    public function deleteFolder($directory){
    	Storage::deleteDirectory($directory);
    	return true;
    }
    /**
     * 修改目录
     */
    public function renameFolder($old,$new){
    	if($this->disk->exists($old)){
    		rename(public_path('uploads')."/".$old,public_path('uploads')."/".$new);
    		return true;
    	}else{
    		return false;
    	}
    }
}
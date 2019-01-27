<?php

namespace Readingbar\Api\Functions;
use Validator;
use Storage;
use Readingbar\Api\Classes\ImageFunction;
class AvatarFunction
{
	/**
	 * 头像设置
	 * @param unknown $file
	 * @param unknown $width
	 * @param unknown $height
	 * @param unknown $x
	 * @param unknown $y
	 */
	static function setAvatar($file,$filename,$width,$height,$x,$y){
		if($file && in_array($file->extension(),['gif','jpg','png','jpeg'])){
			$dir='files/avatar/'.$filename.'.'.$file->extension();
			Storage::put(
					$dir,
					file_get_contents($file->getRealPath())
					);
			$image=new ImageFunction(public_path($dir));
			$image->crop($x,$y,$x+$width,$y+$height);
			$image->save(public_path($dir));
			return $dir;
		}else{
			return false;
		}
		
	}
}

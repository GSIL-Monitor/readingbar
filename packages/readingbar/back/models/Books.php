<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
	public $table='books';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('book_name','author','ISBN','LCCN','publisher','PublishDate','ARQuizNo','language','summary','ARQuizType','type','WordCount','PageCount','rating','IL','BL','ARPts','atos','topic','series');
    
    /**
     * 获取库存信息 / 获取指定状态的库存信息
     */
    public function Storages($status = 0){
    	return $this->hasMany(BookStorage::class,'book_id','id')
    			->where(function ($where) use($status) {
    				if (is_array($status)){
    					$where->whereIn('status',$status);
    				}else if ($status) {
    					$where->where(['status'=>$status]);
    				}
    			})
    			->get()
    			->each(function ($item,$key){
    				$item['relates']= $item->getInfoByStatus();
    				return $item;
    			});
    }
}

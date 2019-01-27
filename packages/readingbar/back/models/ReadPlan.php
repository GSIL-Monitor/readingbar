<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class ReadPlan extends Model
{
	public $table='read_plan';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('plan_name','from','to','for','created_by','status','type');
	/**
	 * 获取计划详情书单
	 */
    public function books(){
    	return $this->hasMany('Readingbar\Back\Models\ReadPlanDetail', 'plan_id', 'id')
    			->crossJoin('books','books.id','=','book_id')
    			->get(['books.*']);
    }
    /**
     * 获取借出状态的关联书籍数量
     */
    public function booksCount($status = 0) {
    	return $this->hasMany('Readingbar\Back\Models\ReadPlanDetail', 'plan_id', 'id')
    	->crossJoin('book_storage',function ($join){
    		$join->on('book_storage.book_id','=','read_plan_detail.book_id');
    		$join->on('book_storage.serial','=','read_plan_detail.serial');
    	})
    	->where(function($where) use($status) {
    		if ($status) {
    			$where->where('book_storage.status','=',$status);
    		}
    	})
    	->count();
    }
}

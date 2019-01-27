<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class ReadPlanDetail extends Model
{
	public $table='read_plan_detail';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('plan_id','book_id','serial','Ar_id','Ar_pdf_rar_en','Ar_pdf_rar_zh','Ar_pdf_vt_zh','Ar_pdf_vt_en','Ar_pdf_rwaar_zh','Ar_pdf_rwaar_en');
    /**
     * 对应计划
     */
	public function plan() {
		return $this->hasOne(ReadPlan::class,'id','plan_id')->first();
	}
	/**
	 * 关联书籍
	 */
	public function book() {
		return BookStorage::where(['book_id'=>$this->book_id,'serial'=>$this->serial])->first();
	}
}

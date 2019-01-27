<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class StarReport extends Model
{
	public $table='star_report';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('student_id','star_account','test_date','report_id','time_used','grade','ss','pr','estor','ge','lm','irl','zpd','wks','cscm','alt','uac','aaet','result','explain','vo','ui','er','wr','pdf_en','pdf_zh','pdf_stage','memo','star_version','report_type','created_by');
}

<?php

namespace Readingbar\Api\Frontend\Models;

use Illuminate\Database\Eloquent\Model;

class StarReport extends Model
{
	public $table='star_report';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('student_id','test_date','report_id','time_used','grade','ge','irl','zpd','wks','cscm','alt','uac','aaet','result','explain','created_by');
}

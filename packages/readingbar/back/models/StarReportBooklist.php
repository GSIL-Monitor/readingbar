<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class StarReportBooklist extends Model
{
	public $table='star_report_booklist';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('report_id','book_id','reason');
}

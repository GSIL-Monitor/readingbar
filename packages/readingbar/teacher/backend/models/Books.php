<?php

namespace Readingbar\Teacher\Backend\Models;

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

}

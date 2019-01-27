<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class BooksImport extends Model
{
	public $table='books_import';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('book_name','author','ISBN','LCCN','publisher','PublishDate','ARQuizNo','language','summary','ARQuizType','type','WordCount','PageCount','rating','IL','BL','ARPts','atos','topic','series');

}

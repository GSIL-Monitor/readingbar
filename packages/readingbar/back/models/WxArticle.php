<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class WxArticle extends Model
{
	public $table='wx_article';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array( 'title','title_image','summary','lable','url','status');
}

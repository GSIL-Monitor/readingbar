<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class kdniaoExpressCode extends Model
{
	public $table='kdniao_express_code';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    		'express_name',
    		'express_code'
    ];

}

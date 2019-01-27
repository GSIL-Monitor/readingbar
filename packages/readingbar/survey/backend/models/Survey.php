<?php

namespace Readingbar\Survey\Backend\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
	public $table='survey';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('survey_id','question','required','answer_type','YesNextID','NoNextID','NextID','option1','option2','option3','option4','option5','option6','option7','option8','option9','option10');

}

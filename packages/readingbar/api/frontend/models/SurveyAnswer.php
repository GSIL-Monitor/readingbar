<?php

namespace Readingbar\Api\Frontend\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyAnswer extends Model
{
	public $table='survey_answer';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('student_id','survey_id','answer1','answer2','answer3','answer4','answer5','answer6','answer7','answer8','answer9','answer10');

}

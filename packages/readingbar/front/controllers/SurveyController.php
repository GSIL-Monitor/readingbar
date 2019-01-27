<?php

namespace Readingbar\Front\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use Readingbar\Api\Frontend\Models\Survey;

class SurveyController extends FrontController
{
	/*孩子基础问卷界面*/
	public function index(Request $request,$student_id=null){
		$data['head_title']='基础问卷';
		$data['questions']=Survey::get()->toArray();
		$data['student_id']=$student_id;
		return $this->view('member.surveyForm',$data);
	}
}

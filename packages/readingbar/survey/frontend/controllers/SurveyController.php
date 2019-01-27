<?php

namespace Readingbar\Survey\Frontend\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Readingbar\Member\Frontend\Models\members;
use Validator;
use Auth;
use Readingbar\Survey\Frontend\Models\Survey;
use Readingbar\Survey\Frontend\Models\Survey_answer;
use Readingbar\Survey\Frontend\Models\Student;
class SurveyController extends Controller
{
	public function index($student_id){
		//验证学生id是否属于当前登录会员
		$check=Validator::make([
					'student_id'=>$student_id
				],
				[
					'student_id'=>'required|exists:students,id,parent_id,'.Auth::guard("member")->getId()
		]);
		if($check->fails()){
			session()->forget('NextID');
			session()->forget('survey_student_id');
			return redirect("member/student");
		}
		if($student_id!==session('survey_student_id')){
			session()->forget('NextID');
			session()->forget('survey_student_id');
		}
		if(session('NextID')){
			$NextID=session('NextID');
		}else{
			$NextID=1;
		}
		$survey=Survey::where('survey_id','=',$NextID)->get()->first();
		$data['survey']=$survey;
		session(array('survey_student_id'=>$student_id));
		return view("Readingbar/survey/frontend::survey",$data);
	}
	public function answer($survey_id,Request $request){
		$survey_id=(int)$survey_id;
		$survey=Survey::where('survey_id','=',$survey_id)->get()->first();
		if((int)$survey['required'] && (!$request->input('option') && !$request->input('answer'))){
			return redirect()
					->back()
					->withErrors(['answer'=>"answer is required!"])
					->withInput();
		}
		$option=$request->input('option');
		switch ($survey->answer_type){
			case '1':
				$survey_answer=array(
						'survey_id'=>$survey_id,
						'answer'.$option=>$survey['option'.$option],
						'student_id'=>session("survey_student_id")
				);
				break;
			case '2':
				$survey_answer=array(
					'survey_id'=>$survey_id,
					'student_id'=>session("survey_student_id")
				);
				foreach ($option as $v){
					$v=(int)$v;
					if($request->input('answer'.$v)){
						$survey_answer['answer'.$v]=$request->input('answer'.$v);
					}else{
						$survey_answer['answer'.$v]=$survey['option'.$v];
					}
				}
				break;
			case '3':
				$survey_answer=array(
					'survey_id'=>$survey_id,
					'student_id'=>session("survey_student_id"),
					'answer1'=>$request->input('answer'),
				);
				break;
		}
		if(Survey_answer::where(array('survey_id'=>$survey_id,'student_id'=>session("survey_student_id")))->count()){
			Survey_answer::where(array('survey_id'=>$survey_id,'student_id'=>session("survey_student_id")))->delete();
		}
		Survey_answer::create($survey_answer);
		
		if($option<=2 && $survey['YesNextID']!='' && $survey['NoNextID']!=''){
			switch ($option){
				case '1':
					session(['NextID'=>$survey['YesNextID']]);
					break;
				case '2':
					session(['NextID'=>$survey['NoNextID']]);
					break;
			}
		}else{
			session(['NextID'=>$survey['NextID']]);
		}
		if((int)session('NextID')){
			return redirect('member/student/'.session("survey_student_id").'/survey');
		}else{
			Student::where(array('id'=>session('survey_student_id')))->update(array('survey_status'=>1));
			session()->forget('NextID');
			session()->forget('survey_student_id');
			echo "thank you !";
		}
	}
}
<?php

namespace Readingbar\Survey\Backend\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Readingbar\Survey\Backend\Models\members;
use Validator;
use Auth;
use Readingbar\Survey\Frontend\Models\Survey;
use Readingbar\Survey\Frontend\Models\Survey_answer;
use Readingbar\Survey\Backend\Models\Students;

class SurveyController extends Controller
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'survey.head_title','active'=>true),
	);
	/**
	 * 参与问卷调查的会员列表+条件查询（账号）
	 */
	public function memberList(){
		$data['head_title']=trans('books.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$data['columns']=array('id','nickname','cellphone','email');
		$data['success'] = session('success')?session('success'):'';
		$data['error'] = session('error')?session('error'):'';
		return view("Readingbar/survey/backend::member_list",$data);
	}
	public function ajax_studentList(Request $request){
		$columns=array('students.id','members.nickname as parent','students.name as student','members.cellphone','members.email');
		$ordersColumns=array('students.id','members.nickname','students.name','members.cellphone','members.email');
		$input=$request->all();
		/* $members=Members::where("id","like","%".$input['search']['value']."%")
			->orWhere("nickname","like","%".$input['search']['value']."%")
			->orWhere("cellphone","like","%".$input['search']['value']."%")
			->orWhere("email","like","%".$input['search']['value']."%")
			->orderBy($columns[$input['order'][0]['column']],$input['order'][0]['dir'])
			->skip($input['start'])->take($input['length'])
			->get($columns);
		$members_count=Members::where("id","like","%".$input['search']['value']."%")
			->orWhere("nickname","like","%".$input['search']['value']."%")
			->orWhere("cellphone","like","%".$input['search']['value']."%")
			->orWhere("email","like","%".$input['search']['value']."%")
			->orderBy($columns[$input['order'][0]['column']],$input['order'][0]['dir'])
			->count(); */
		$students=Students::leftJoin('members','members.id','=','students.parent_id')
				->orWhere("members.nickname","like","%".$input['search']['value']."%")
				->orWhere("members.cellphone","like","%".$input['search']['value']."%")
				->orWhere("students.name","like","%".$input['search']['value']."%")
				->orWhere("members.email","like","%".$input['search']['value']."%")
				->orderBy($ordersColumns[$input['order'][0]['column']],$input['order'][0]['dir'])
				->skip($input['start'])->take($input['length'])
				->get($columns);
		$students_count=Students::leftJoin('members','members.id','=','students.parent_id')
				->orWhere("members.nickname","like","%".$input['search']['value']."%")
				->orWhere("members.cellphone","like","%".$input['search']['value']."%")
				->orWhere("students.name","like","%".$input['search']['value']."%")
				->orWhere("members.email","like","%".$input['search']['value']."%")
				->orderBy($ordersColumns[$input['order'][0]['column']],$input['order'][0]['dir'])
				->count();
		$d_students=array();
		foreach ($students as $m){
			$d_students[]=array(
					$m->id,
					$m->parent,
					$m->student,
					$m->cellphone,
					$m->email
			);
		}
		$datatable=array(
			'recordsFiltered'=>$students_count,
			'data'=>$d_students,
			'draw'=>$input['draw'],
			'recordsTotal'=>$students_count				
		);
		echo json_encode($datatable,JSON_UNESCAPED_UNICODE);
	}
	/**
	 * 问卷结果（会员）
	 */
	public function resultSurvey($student_id){
		$data['head_title']=trans('books.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$data['result']=Survey_answer::where(['student_id'=>$student_id])->leftJoin('survey', 'survey_answer.survey_id', '=', 'survey.id')->get();
		return view("Readingbar/survey/backend::result",$data);
	}
}
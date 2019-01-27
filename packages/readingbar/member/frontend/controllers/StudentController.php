<?php

namespace Readingbar\Member\Frontend\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Auth;
use Validator;
use Readingbar\Member\Frontend\Models\Student;
use Illuminate\Http\Response;
class StudentController extends Controller
{
	//view
	public function index(Request $request){
		$data=array();
		return view("Readingbar/member/frontend::student.list",$data);
	}
	//ajax
	public function getStudents(Request $request){
		$results=Student::where(['parent_id'=>Auth::guard('member')->getId()])->get()->toArray();
		$Students['data']=$results;
		if($request->ajax()){
			return Response()->json($Students);
		}else{
			return $Students;
		}
	}
	public function getStudent($id,Request $request){
		$result=Student::where(['parent_id'=>Auth::guard('member')->getId(),'id'=>(int)$id])->first()->toArray();
		$Student['data']=$result;
		if($request->ajax()){
			return Response()->json($Student);
		}else{
			return $Student;
		}
	}
	
	public function create(Request $request){
		$input=array(
				'name'=>$request->input('name'),
				'nick_name'=>$request->input('nick_name'),
				'avatar'=>$request->input('avatar'),
				'dob'=>$request->input('dob'),
				'sex'=>$request->input('sex'),
				'parent_id'=>Auth::guard('member')->getId()
		);
		$checkStudent=Validator::make($input,[
			'name'      =>'required|min:2',
			'nick_name' =>'required|min:2',
			'dob'		=>'required',
			'sex'		=>'required'
		]);
		if($checkStudent->fails()){
			foreach ($input as $key=>$v){
				if($checkStudent->errors()->has($key)){
					$msg['errors'][$key]=$checkStudent->errors()->first($key);
				}
			}
		}else{
			Student::create($input);
			$msg=array('success'=>"f_student.succsee_create");
		}
		if($request->ajax()){
			return Response()->json($msg);
		}else{
			return $msg;
		}
	}
	public function edit(Request $request){
		$input=array(
				'id'=>$request->input('id'),
				'name'=>$request->input('name'),
				'nick_name'=>$request->input('nick_name'),
				'avatar'=>$request->input('avatar'),
				'dob'=>$request->input('dob'),
				'sex'=>$request->input('sex'),
				'parent_id'=>Auth::guard('member')->getId()
		);
		$checkStudent=Validator::make($input,[
				'id'		=>'required|exists:students,id,parent_id,'.$input['parent_id'],
				'name'      =>'required|min:2',
				'nick_name' =>'required|min:2',
				'dob'		=>'required',
				'sex'		=>'required'
		]);
		if($checkStudent->fails()){
			foreach ($input as $key=>$v){
				if($checkStudent->errors()->has($key)){
					$msg['errors'][$key]=$checkStudent->errors()->first($key);
				}
			}
		}else{
			Student::where(['id'=>$input['id'],'parent_id'=>$input['parent_id']])->update($input);
			$msg=array('success'=>"f_student.succsee_edit");
		}
		if($request->ajax()){
			return Response()->json($msg);
		}else{
			return $msg;
		}
	}
	public function destroy(Request $request){
		$input=array(
				'id'=>$request->input('id'),
				'parent_id'=>Auth::guard('member')->getId()
		);
		$checkStudent=Validator::make($input,[
				'id' =>'required|exists:students,id,parent_id,'.$input['parent_id']
		]);
		if($checkStudent->fails()){
			$msg['error']="f_student.no_permission_delete";
		}else{
			Student::where($input)->delete();
			$msg=array('success'=>"f_student.succsee_delete");
		}
		if($request->ajax()){
			return Response()->json($msg);
		}else{
			return $msg;
		}
	}
}
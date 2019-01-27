<?php

namespace Readingbar\Front\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use Readingbar\Api\Frontend\Models\ReadPlanDetail;

class BookController extends FrontController
{
	/*书评界面*/
	public function comment(Request $request){
		$data['head_title']='书评界面';
		$inputs=$request->all();
		$rules=array(
				'student_id'=>'required|exists:students,id,parent_id,'.auth('member')->getId(),
				'book_id'	=>'required|exists:books,id'
		);
		$check=Validator::make($inputs,$rules);
		if($check->passes()){
			//校验用户是否可以评论了
			$rpd=ReadPlanDetail::leftjoin('read_plan','read_plan.id','=','read_plan_detail.plan_id')
				->where(['read_plan.for'=>$inputs['student_id'],'read_plan_detail.book_id'=>$inputs['book_id']])
				->where('read_plan.status','>=',2)
				->count();
			if($rpd){
				$data=array(
						'student_id'=>$inputs['student_id'],
						'book_id'	=>$inputs['book_id']
				);
				return $this->view('book.comment', $data);
			}else{
				return redirect()->back();
			}
		}else{
			if($check->errors()->has('student_id')){
				$error="孩子不存在！";
			}else{
				$error="书籍不存在！";
			}
			return redirect()->back()->with(['alert'=>$error]);
		}
		
	}
}

<?php

namespace Readingbar\Api\Frontend\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use Readingbar\Api\Frontend\Models\BookComment;
use Readingbar\Api\Frontend\Models\ReadPlanDetail;
class BookController extends FrontController
{
	/*获取某个学生的评论*/
	public function getCommentOfChild(Request $request){
		$inputs=$request->all();
		$rules=array(
			'student_id'=>'required|exists:students,id,parent_id,'.auth('member')->getId(),
			'book_id'	=>'required|exists:books,id'
		);
		$check=Validator::make($inputs,$rules);
		if($check->passes()){
			$where=array(
					'commented_by'=>$inputs['student_id'],
					'book_id'=>$inputs['book_id']
			);
			$comment=BookComment::where($where)->first();
			if($comment){
				$comment=$comment->toArray();
			}
			$this->json=array('status'=>true,'success'=>'数据获取成功！','data'=>$comment);
		}else{
			if($check->errors()->has('student_id')){
				$error="孩子不存在！";
			}else{
				$error="书籍不存在！";
			}
			$this->json=array('status'=>false,'error'=>$error);
		}
		$this->echoJson();
	}
	/*评论*/
	public function commentForBook(Request $request){
		$inputs=$request->all();
		$rules=array(
				'student_id'=>'required|exists:students,id,parent_id,'.auth('member')->getId(),
				'book_id'	=>'required|exists:books,id',
				'comment'	=>'required'
		);
		$check=Validator::make($inputs,$rules);
		
		if($check->passes()){
			$rpd=ReadPlanDetail::leftjoin('read_plan','read_plan.id','=','read_plan_detail.plan_id')
				->where(['read_plan.for'=>$inputs['student_id'],'read_plan_detail.book_id'=>$inputs['book_id']])
				->where('read_plan.status','>=',2)
				->count();
			if($rpd){
				$where=array(
						'commented_by'=>$inputs['student_id'],
						'book_id'=>$inputs['book_id']
				);
				if(BookComment::where($where)->count()){
					BookComment::where($where)->update(['comment'=>$inputs['comment']]);
				}else{
					$comment=$where;
					$comment['comment']=$inputs['comment'];
					BookComment::create($comment);
				}
				$this->json=array('status'=>true,'success'=>'评论成功！');
			}else{
				$this->json=array('status'=>false,'error'=>'您现在不能评论！');
			}
		}else{
			if($check->errors()->has('student_id')){
				$error="孩子不存在！";
			}elseif($check->errors()->has('book_id')){
				$error="书籍不存在！";
			}else{
				$error="评论的内容不能为空！";
			}
			$this->json=array('status'=>false,'error'=>$error);
		}
		$this->echoJson();
	}
}

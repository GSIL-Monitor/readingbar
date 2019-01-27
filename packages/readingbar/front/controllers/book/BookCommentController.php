<?php

namespace Readingbar\Front\Controllers\Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use Readingbar\Api\Frontend\Models\ReadPlanDetail;
use Readingbar\Front\Controllers\FrontController;
use Readingbar\Back\Models\BookComment;
use Readingbar\Back\Models\Discount;
class BookCommentController extends FrontController
{
	/*书评界面*/
	public function index(Request $request){
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
				->where('read_plan.status','>=',1)
				->count();
			if($rpd){
				$data['student_id']=$inputs['student_id'];
				$data['book_id']=$inputs['book_id'];
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
	// 提交评论
	public function comment(Request $request){
		$inputs=$request->all();
		$rules=array(
				'student_id'=>'required|exists:students,id,parent_id,'.auth('member')->id(),
				'book_id'	=>'required|exists:books,id',
				'comment'	=>'required'
		);
		$check=Validator::make($inputs,$rules);
	
		if($check->passes()){
			$rpd=ReadPlanDetail::leftjoin('read_plan','read_plan.id','=','read_plan_detail.plan_id')
			->where(['read_plan.for'=>$inputs['student_id'],'read_plan_detail.book_id'=>$inputs['book_id']])
			->where('read_plan.status','>=',1)
			->count();
			if($rpd){
				$where=array(
						'commented_by'=>$inputs['student_id'],
						'book_id'=>$inputs['book_id']
				);
				if(BookComment::where($where)->count()){
					return array('status'=>true,'success'=>'您已经评论过了，谢谢您的支持！');
				}else{
					$comment=$where;
					$comment['comment']=$inputs['comment'];
					BookComment::create($comment);
					Discount::giveByRule(auth('member')->id(), 'book_comment');
				}
				return array('status'=>true,'success'=>'评论成功！');
			}else{
				return array('status'=>false,'error'=>'您现在不能评论！');
			}
		}else{
			if($check->errors()->has('student_id')){
				$error="孩子不存在！";
			}elseif($check->errors()->has('book_id')){
				$error="书籍不存在！";
			}else{
				$error="评论的内容不能为空！";
			}
			 return array('status'=>false,'error'=>$error);
		}
	}

	// 获取孩子对某本书的书评
	public function getCommentBySBID($student_id, $book_id) {
		$inputs=[
				'student_id'=>$student_id,
				'book_id'	=>$book_id
		];
		$rules=array(
				'student_id'=>'required|exists:students,id,parent_id,'.auth('member')->id(),
				'book_id'	=>'required|exists:books,id'
		);
		$check=Validator::make($inputs,$rules);
		if($check->passes()){
			$where=array(
					'commented_by'=>$student_id,
					'book_id'=>$book_id
			);
			$comment=BookComment::where($where)->first();
			if($comment){
				$comment=$comment->toArray();
			}
			return array('status'=>true,'success'=>'数据获取成功！','data'=>$comment);
		}else{
			if($check->errors()->has('student_id')){
				$error="孩子不存在！";
			}else{
				$error="书籍不存在！";
			}
			return array('status'=>false,'error'=>$error);
		}
	}
}

<?php

namespace Readingbar\Bookcomment\Frontend\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Validator;
use Auth;
use Readingbar\Bookcomment\Frontend\Models\book_comment;
use GuzzleHttp\json_encode;
class CommentController extends Controller
{
	private $default_order="created_at";
	private $default_sort="desc";
	private $default_limit=5;
	private $status=1;
	/**
	 * 获取评论列表
	 * @param Request $request
	 */
	public function commentsjson(Request $request){
		$json=array();
		if($request->input("ISBN")){
			$order=$request->input("order")?$request->input("order"):$this->default_order;
			$sort=$request->input("sort")?$request->input("sort"):$this->default_sort;
			$page=(int)$request->input("page")>0?(int)$request->input("page"):1;
			$columns=['book_comment.id as id','nickname','ISBN'];
			$data=book_comment::leftJoin('members as c','book_comment.commented_by', '=', 'c.id' )
				->where("ISBN","=",$request->input("ISBN"))
				->where('status','=',1)
				->orwhere("ISBN","=",$request->input("ISBN"))
				->where('commented_by','=',Auth::guard('member')->getId())
				->orderBy('book_comment.'.$order, $sort)
				->skip(($page-1)*$this->default_limit)
				->take($this->default_limit)
				->get($columns)->toArray();
			$total=book_comment::leftJoin('members as c','book_comment.commented_by', '=', 'c.id' )
				->where("ISBN","=",$request->input("ISBN"))
				->where('status','=',1)
				->orwhere("ISBN","=",$request->input("ISBN"))
				->where('commented_by','=',Auth::guard('member')->getId())
				->count();
			$json['total']=$total;
			$json['per_page']=$this->default_limit;
			$json['current_page']=$page;
			$json['data']=$data;
			$json['total_pages']=round($json['total']/$json['per_page']);
			$json['order']=$order;
			$json['sort']=$sort;
		}
		echo json_encode($json);
	}
	/**
	 * 获取评论详情
	 * @param int $id
	 */
	public function commentjson($id){
		$v=Validator::make([
			'id'=>$id
		],[
			'id'=>'required|exists:book_comment,id'
		]);
		if($v->fails()){
			$json=array(
				'error'=>trans('f_bookcomment.comment_no_exist')
			);
		}else{
			$json=book_comment::where("id","=",$id)
			->first();
		}
		echo json_encode($json);
	}
	/**
	 * 评论
	 * @param Request $request
	 */
	public function comment(Request $request){
			$v=Validator::make([
				'ISBN'=>$request->input('ISBN'),
				'comment'=>$request->input('comment')
			],[
				'ISBN'=>'required|exists:books,ISBN',
				'comment'=>'required|min:4'
			]);
			if($v->fails()){
				if($v->errors()->has('ISBN')){
					$json=array(
						'error'=>trans('f_bookcomment.book_no_exist')
					);
				}
				if($v->errors()->has('comment')){
					$json=array(
						'error'=>trans('f_bookcomment.commont_atleast_4')
					);
				}
			}else{
				$c=array(
						'commented_by'=>Auth::guard('member')->getId(),
						'ISBN'=>$request->input('ISBN'),
						'comment'=>$request->input('comment'),
						'status'=>$this->status,
				);
				$json=book_comment::create($c);
			}
		echo json_encode($json);
	}
	/**
	 * 评论编辑
	 */
	public function edit(Request $request){
		$json=array();
			$id=(int)$request->input('id');
			$v=Validator::make([
				'commented_by'=>Auth::guard('member')->getId(),
				'comment'=>$request->input('comment')
			],[
				'commented_by'=>'required|exists:book_comment,commented_by,id,'.$id,
				'comment'=>'required|min:4'
			]);
			if($v->fails()){
				if($v->errors()->has('commented_by')){
					$json=array(
							'error'=>trans('f_bookcomment.no_permission_edit')
					);
				}
				if($v->errors()->has('comment')){
					$json=array(
							'error'=>trans('f_bookcomment.commont_atleast_4')
					);
				}
			}else{
				$c=array(
						'comment'=>$request->input('comment'),
						'status'=>$this->status,
				);
				book_comment::where(['id'=>$id])->update($c);
				$json=book_comment::where("id","=",$id)->get();
			}
		echo json_encode($json);
	}
}

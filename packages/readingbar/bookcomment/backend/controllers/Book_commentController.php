<?php

namespace Readingbar\Bookcomment\Backend\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Readingbar\Bookcomment\Backend\Models\book_comment;
use Validator;
class Book_commentController extends Controller
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'book_comment.head_title','url'=>'admin/book_comment','active'=>true),
	);
   public function index2(){
	   	$data['head_title']=trans('book_comment.head_title');
	   	$data['breadcrumbs']=$this->breadcrumbs;
   		$data['columns']=array('id','ISBN','commented_by','comment','status','created_at','updated_at');
   		$data['book_comments'] = book_comment::select($data['columns'])->paginate(15);
   		$data['success'] = session('success')?session('success'):'';
   		$data['error'] = session('error')?session('error'):'';
   		return view("Readingbar/bookcomment/backend::book_comment_list",$data);
   }
   public function index(){
	   	$data['head_title']=trans('book_comment.head_title');
	   	$data['breadcrumbs']=$this->breadcrumbs;
	   	$data['columns']=array('id','ISBN','commented_by','comment','status','created_at','updated_at');
	   	$data['success'] = session('success')?session('success'):'';
	   	$data['error'] = session('error')?session('error'):'';
	   	return view("Readingbar/bookcomment/backend::book_comment_list_ajax",$data);
   }
   public function ajax_comments(Request $request){
	   	$columns=array('book_comment.id as seleted','book_comment.id','ISBN','nickname as commented_by','comment','status','book_comment.created_at','book_comment.updated_at');
	   	$order=array('id','id','ISBN','commented_by','comment','status','created_at','updated_at');
	   	
	   	$input=$request->all();
	   	$comments=book_comment::
	   		leftJoin('members','members.id','=','book_comment.commented_by')
	   		->where("book_comment.id","like","%".$input['search']['value']."%")
		   	->orWhere("nickname","like","%".$input['search']['value']."%")
		   	->orWhere("comment","like","%".$input['search']['value']."%")
		   	->orderBy($order[$input['order'][0]['column']],$input['order'][0]['dir'])
		   	->skip($input['start'])->take($input['length'])
		   	->get($columns);
	   	$comments_count=book_comment::
		   	leftJoin('members','members.id','=','book_comment.commented_by')
		   	->where("book_comment.id","like","%".$input['search']['value']."%")
		   	->orWhere("nickname","like","%".$input['search']['value']."%")
		   	->orWhere("comment","like","%".$input['search']['value']."%")
		   	->count();
	   	$d_comments=array();
	   	foreach ($comments as $c){
	   		$d_comments[]=array_values($c->toArray());
	   	}
	   	$datatable=array(
	   			'recordsFiltered'=>$comments_count,
	   			'data'=>$d_comments,
	   			'draw'=>$input['draw'],
	   			'recordsTotal'=>$comments_count
	   	);
	   	echo json_encode($datatable,JSON_UNESCAPED_UNICODE);
   }
   public function show(){}
   public function edit($id){
   		return $this->getForm($id);
   }
   public function create(){
   		return $this->getForm();
   }
   public function getForm($id=0){
	   	$data['head_title']=trans('book_comment.head_title');
	   	$data['breadcrumbs']=$this->breadcrumbs;
   		if($id){
   			$data['action']="admin/book_comment/$id";
   			$data['method']="PUT";
   			$data['book_comment']=book_comment::where('id','=',$id)->first();
   		}else{
   			$data['action']="admin/book_comment";
   			$data['method']="POST";
   		}
   		return view("Readingbar/bookcomment/backend::book_comment_form",$data);
   }
   public function update(Request $request){
   		$columns=array('ISBN','commented_by','comment','status');
   		$id=(int)$request->input('id');
   		$validator = Validator::make($request->all(), [
   					'id'	=>'required|in:book_commentes,id,'.$id,
   		]);
   		if ($validator->fails()) {
   			return redirect("admin/book_comment/$id/edit")
   			->withErrors($validator)
   			->withInput();
   		}else{
   			//执行
   			$book_comment=array();
   			foreach ($columns as $column){
   				switch ($column){
   					default:$book_comment[$column]=$request->input($column);
   				}
   			}
   			book_comment::where("id","=",$id)->update($book_comment);
   			$request->session()->flash('success', trans("common.operate_success"));
   			return redirect('admin/book_comment');
   		}
   		
   }
   public function store(Request $request){
   		//校验
   		$validator = Validator::make($request->all(), [

   		]);
   		if ($validator->fails()) {
   			return redirect('admin/book_comment/create')
   			->withErrors($validator)
   			->withInput();
   		}else{
   			//执行
   			$columns=array('ISBN','commented_by','comment','status');
   			$book_comment=array();
   			foreach ($columns as $column){
   				switch ($column){
   					default:$book_comment[$column]=$request->input($column);
   				}
   			}
   			book_comment::create($book_comment);
   			$request->session()->flash('success', trans("common.operate_success"));
   			return redirect('admin/book_comment');
   		}
   }
   public function destroy(Request $request){
   		if(null!==$request->input('selected') && is_array($request->input('selected'))){
   			foreach ($request->input('selected') as $v){
   				book_comment::where("id","=",$v)->delete();
   			}
   		}
   		$request->session()->flash('success', trans("common.operate_success"));
   		return redirect('admin/book_comment');
   }
   
}

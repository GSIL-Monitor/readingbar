<?php

namespace Readingbar\Front\Controllers\Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Readingbar\Front\Controllers\FrontController;
use App\Http\Requests;
use Readingbar\Back\Models\Books;
use Readingbar\Back\Models\BookAttach;
use Auth;
class BookSearchController extends FrontController
{
	/*书籍查询列表*/
	public function index(){
		if(!auth('member')->isPaidMember()){
			return redirect()->back();
		}
		$data['head_title']='书单查询';
		return $this->view('book.BookSearchList', $data);
	}
	/*书籍查询详情*/
	public function detail(){
		if(!auth('member')->isPaidMember()){
			return redirect()->back();
		}
		$data['head_title']='书籍详情';
		return $this->view('book.BookSearchDetail', $data);
	}
	//书单检索
	public function doSearchBooks(Request $request){
		$books=Books::where(['in_book_list'=>1])->where(function($where) use($request){
			if($request->input('BL')){
				$BL=explode('-',$request->input('BL'));
				if(count($BL)==2){
					$where->whereBetween('BL',$BL);
				}
			}
			if($request->input('IL')){
				$where->where(['IL'=>$request->input('IL')]);
			}
			if($request->input('type')){
				$where->where(['type'=>$request->input('type')]);
			}
			if($request->input('topic')){
				$where->where('topic','like','%'.$request->input('topic').'%');
			}
		})->paginate((int)$request->input('limit'));
		foreach ($books as $k=>$b){
			$image=BookAttach::where(['BookID'=>$b->id,'type'=>'image'])->first();
			$books[$k]['image']=$image?url($image->path):config('readingbar.isbnImage').$b->ISBN.'.jpg';
		}
		return $books;
	}
}

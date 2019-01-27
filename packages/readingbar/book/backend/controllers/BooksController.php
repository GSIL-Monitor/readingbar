<?php

namespace Readingbar\Book\Backend\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Readingbar\Back\Models\Books;
use Validator;
use Readingbar\Book\BooksHelper;
use Readingbar\Book\Backend\Models\BookStorage;
use Storage;
use Readingbar\Book\Backend\Models\BookAttach;
use DB;
class BooksController extends Controller
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'books.head_title','url'=>'admin/books','active'=>true),
	);
   public function index(Request $request){
	   	$data['head_title']=trans('books.head_title');
	   	$data['breadcrumbs']=$this->breadcrumbs;
	   	$data['columns']=array('id','book_name','author','ISBN','publisher','PublishDate','ARQuizNo','language','summary','series','rating','IL','BL','ARPts','ARQuizType','price_rmb','in_book_list','created_at','updated_at');
	   	// 库存状态查询
	   	$havingRaw = 'books.id > 0';
	   	if ($request->input('status') && in_array($request->input('status'),[1,2,3,4,5,6])) {
	   		$havingRaw = 'count(IF(book_storage.status='.$request->input('status').',1,null)) > 0';
	   	}
	   	$bookList = Books::crossjoin('book_storage','book_storage.book_id','=','books.id')
	   	->where(function ($where) use($request,$data){
	   		switch ($request->input('search_mode')) {
	   			case 'keyword_search':
	   				if ($request->input('keyword')) {
	   					if (in_array($request->input('search_column'),$data['columns'])) {
	   						$where->where('books.'.$request->input('search_column'),'like','%'.$request->input('keyword').'%');
	   					} else {
	   						foreach ($data['columns'] as $column) {
	   							$where->orwhere('books.'.$column,'like','%'.$request->input('keyword').'%');
	   						}
	   					}
	   				}
	   				break;
	   			case 'advanced_search':
	   				if (is_array($request->all())){
	   					foreach ($request->all() as $k=>$v) {
	   						if (in_array($k,$data['columns'])) {
	   							$where->where('books.'.$k,'like','%'.$request->input($k).'%');
	   						}
	   					}
	   				}
	   				break;
	   		}
	   	})
	   	->groupBy('books.id')
	   	->havingRaw($havingRaw)
	   	->select([
	   			'books.*',
	   			DB::raw('count(book_storage.id) as storage')
	   	])
	   	->paginate(15);
   		foreach($bookList as $k=>$v) {
   			if ($request->input('status') && in_array($request->input('status'),[3,4,5,6])) {
		   			$v->storages=$v->Storages($request->input('status'));
		   	}else {
		   		$v->storages = $v->Storages([3,4,5,6]);
		   	}
   			$image=BookAttach::where(['BookId'=>$v['id'],'type'=>'image'])->first();
   			$v->image=$image?url($image->path):'http://coverscans.renlearn.com/'.$v['ISBN'].'.jpg';
   		}
	   	$data['bookList']=$bookList;
	   	$data['success'] = session('success')?session('success'):'';
	   	$data['error'] = session('error')?session('error'):'';
	   	return view("Readingbar/book/backend::books_list",$data);
   }
   public function show(){}
   public function edit($id,Request $request){
   		return $this->getForm($id,$request);
   }
   public function create(Request $request){
   		if($request->all()){
   			if(Books::where(['ISBN'=>$request->input('ISBN')])->orwhere(['ARQuizNo'=>$request->input('ARQuizNo')])->count()){
   				return redirect('admin/books?ISBN='.$request->input('ISBN').'&ARQuizNo='.$request->input('ARQuizNo'));
   			}
   		}
   		return $this->getForm(0,$request);
   }
   public function getForm($id=0,Request $request){
	   	$data['head_title']=trans('books.head_title');
	   	$data['breadcrumbs']=$this->breadcrumbs;
   		if($id){
   			$check=Validator::make(['id'=>$id],
   					['id'=>'required|integer|exists:books,id']
   			);
   			if($check->fails()){
   				$request->session()->flash('error', trans("common.data_no_exist"));
   				return redirect('admin/books');
   			}
   			$data['action']="admin/books/$id";
   			$data['method']="PUT";
   			$book=new BooksHelper($id);
   			$data['books']=$book->books->toArray();
   			$data['attaches']=$book->book_attach->toArray();
   			$data['storages']=$book->book_storage->toArray();
   			foreach ($data['storages'] as $k=>$v){
   				if($v['status']==3){
   					$student=DB::table('students as s')
   						->crossjoin('read_plan as pl','pl.for','=','s.id')
   						->crossjoin('read_plan_detail as pld','pld.plan_id','=','pl.id')
   						->leftjoin('star_account as sa','sa.asign_to','=','s.id')
   						->where(['pld.book_id'=>$v['book_id'],'pld.serial'=>$v['serial']])
   						->orderBy('pld.id','desc')
   						->first(['s.nick_name','name','sa.star_account']);
   					$data['storages'][$k]['lend_student']=$student;
   				}
   			}
   		}else{
   			$data['action']="admin/books";
   			if($request->input('ISBN')){
   				$data['books']['ISBN']=$request->input('ISBN');
   			}
   			if($request->input('ARQuizNo')){
   				$data['books']['ARQuizNo']=$request->input('ARQuizNo');
   			}
   			$data['method']="POST";
   		}
   		return view("Readingbar/book/backend::book_edit_form",$data);
   }
   public function update(Request $request){
   		$columns=array('book_name','author','ISBN','LCCN','publisher','PublishDate','ARQuizNo','language','summary','ARQuizType','type','WordCount','PageCount','rating','IL','BL','ARPts','atos','topic','series');
   		$id=(int)$request->input('id');
   		$validator = Validator::make($request->all(), [
   					'id'	=>'required|in:bookses,id,'.$id,
   		]);
   		if ($validator->fails()) {
   			return redirect("admin/books/$id/edit")
   			->withErrors($validator)
   			->withInput();
   		}else{
   			//执行
   			BooksHelper::update($request);
   			$request->session()->flash('success', trans("common.operate_success"));
   			return redirect('admin/books');
   		}
   		
   }
   public function store(Request $request){
   		//校验
   		$validator = Validator::make($request->all(), [

   		]);
   		if ($validator->fails()) {
   			return redirect('admin/books/create')
   			->withErrors($validator)
   			->withInput();
   		}else{
   			BooksHelper::create($request->all());
   			$request->session()->flash('success', trans("common.operate_success"));
   			return redirect('admin/books');
   		}
   }
   public function destroy(Request $request){
   		if(null!==$request->input('selected') && is_array($request->input('selected'))){
   			BooksHelper::delete($request->input('selected'));
   		}
   		$request->session()->flash('success', trans("common.operate_success"));
   		return redirect('admin/books');
   }
   public function delete($id,Request $request){
	   	BooksHelper::delete($id);
	   	$request->session()->flash('success', trans("common.operate_success"));
	   	return redirect('admin/books');
   }
   //导出书籍数据
   public function exportBooks(){
   		$exportColumns=array('book_name','BL','IL','ARPts','ARQuizNo','price_rmb');
   		$books=Books::get($exportColumns)->toArray();
   		$SqlText="
   					DROP TABLE IF EXISTS `books`;
					CREATE TABLE `books` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `book_name` varchar(255) DEFAULT NULL,
					  `author` varchar(255) DEFAULT NULL,
					  `ISBN` varchar(30) DEFAULT NULL,
					  `LCCN` varchar(255) DEFAULT NULL,
					  `publisher` varchar(255) DEFAULT NULL,
					  `PublishDate` date DEFAULT NULL,
					  `ARQuizNo` char(10) DEFAULT NULL,
					  `language` char(10) DEFAULT NULL,
					  `summary` varchar(500) DEFAULT NULL,
					  `ARQuizType` varchar(255) DEFAULT NULL COMMENT 'RP/LS/RV/VP',
					  `type` varchar(255) DEFAULT NULL COMMENT 'Nonfiction/fiction',
					  `WordCount` int(11) DEFAULT NULL,
					  `PageCount` int(255) DEFAULT NULL,
					  `rating` float(11,0) DEFAULT NULL,
					  `IL` char(10) DEFAULT NULL COMMENT 'LG(K-3)/MG(4-8)/MG+(6 and up)/UG(9-12)',
					  `BL` char(10) DEFAULT NULL,
					  `ARPts` float DEFAULT NULL,
					  `atos` int(255) DEFAULT NULL COMMENT '这个要删除掉',
					  `topic` varchar(2500) DEFAULT NULL COMMENT 'topic-subtopic',
					  `series` varchar(255) DEFAULT NULL,
					  `price_rmb` varchar(255) DEFAULT NULL,
					  `price_usd` varchar(255) DEFAULT NULL,
					  `amount` int(11) DEFAULT NULL,
					  `created_at` timestamp NULL DEFAULT NULL,
					  `updated_at` timestamp NULL DEFAULT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB AUTO_INCREMENT=2715 DEFAULT CHARSET=utf8;";
   		foreach ($books as $book){
   			 $book['book_name']=str_replace("'", "\'", $book['book_name']);
   			 $SqlText.='
   			 		INSERT INTO books('.implode(',',$exportColumns).') VALUES(\''.implode('\',\'',$book).'\');';
   		}
   		Storage::put('files/sql/books.sql',$SqlText);
   		return redirect(url('files/sql/books.sql'));
   }
   //浏览书籍图片
   public function viewImages($id){
	   	$data['head_title']=trans('books.head_title');
	   	$data['breadcrumbs']=$this->breadcrumbs;
	   	$data['images']=BookAttach::where(['BookId'=>$id,'type'=>'image'])->get();
	   	foreach ($data['images'] as $v){
	   		$v['src']=url($v['path']);
	   	}
	   	return view("Readingbar/book/backend::viewImages",$data);
   }
   public function changeInBookList(Request $request){
   		$check=Validator::make($request->all(),[
   			'id'=>'required|exists:books,id',
   			'in_book_list'=>'required|in:0,1'
   		]);
   		if($check->passes()){
   			
   			Books::where(['id'=>$request->input('id')])->update(['in_book_list'=>$request->input('in_book_list')]);
   			return redirect()->back();
   		}else{
   			return redirect()->back();
   		}
   }
}

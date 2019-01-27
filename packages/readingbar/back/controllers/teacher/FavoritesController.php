<?php

namespace Readingbar\Back\Controllers\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Readingbar\Back\Models\favorites;
use Readingbar\Back\Models\Books;
use Readingbar\Back\Models\BookAttach;
use Readingbar\Back\Models\BookStorage;
use Validator;
use Auth;
use GuzzleHttp\json_encode;
use Readingbar\Back\Controllers\BackController;
class FavoritesController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'favorites.head_title','url'=>'admin/favorites','active'=>true),
	);
   public function index(){
	   	$data['head_title']=trans('favorites.head_title');
	   	$data['breadcrumbs']=$this->breadcrumbs;
   		$data['columns']=array('id','user_id','book_id','comment','created_at','updated_at');
   		$data['favoritess'] = favorites::select($data['columns'])->paginate(15);
   		$data['success'] = session('success')?session('success'):'';
   		$data['error'] = session('error')?session('error'):'';
   		return $this->view("teacher.favorites_list",$data);
   }
   public function show($type,Request $request){
   		switch ($type){
   			case 'books_search':
   				$data['head_title']=trans('favorites.head_title');
   				$data['breadcrumbs']=$this->breadcrumbs;
   				return view("Readingbar/teacher/backend::books_search",$data);
   			break;
   			case 'books_search_result':$this->books_search_result($request);break;
   			case 'myfavorite':$this->myfavorite($request);break;
   			case 'dofavorite':$this->dofavorite($request);break;
   			case 'dounfavorite':$this->dounfavorite($request);break;
   			case 'docomment':$this->docomment($request);break;
   		}
   		echo json_encode($this->json);
   }
   //书籍查询接口
   public function books_search_result($request){
   		$books=new Books();
   		
   		//条件
   		if($request->input('book_name')!=null){
   			$books=$books->where('book_name','like','%'.$request->input('book_name').'%');
   		}
   		if($request->input('author')!=null){
   			$books=$books->where('author','like','%'.$request->input('author').'%');
   		}
   		if($request->input('ISBN')!=null){
   			$books=$books->where(['ISBN'=>$request->input('ISBN')]);
   		}
   		//条件
   		
   		//页数 及每页显示记录的数量
   		$page=$request->input('page')>1?(int)$request->input('page'):1;
   		$limit=$request->input('limit')>0?(int)$request->input('limit'):10;
   		$start=($page-1)*$limit;
   		$total=$books->count();
   		$totalpages=ceil((float)$total/$limit);
   		$books=$books->skip($start)->take($limit)->get();
   		//页数 及每页显示记录的数量
   		
   		//附件,库存,收藏状态
   		foreach ($books as $k=>$v){
   			$books[$k]['image']=BookAttach::where(['BookID'=>$v['id']])->where(['type'=>'image'])->first();
   			$books[$k]['image']=url('files/'.$books[$k]['image']['path']);
   			$favorite=array(
   					'book_id'=>$v['id'],
   					'user_id'=>Auth::user()->id
   			);
   			$books[$k]['favorite']=Favorites::where($favorite)->count()?true:false;
   			$books[$k]['storage']=BookStorage::where('book_id','=',$v['id'])->count();
   		}
   		//附件及库存
   		$this->json=array('status'=>true,'total'=>$total,'total_pages'=>$totalpages,'current_page'=>$page,'data'=>$books);
   }
   //我的收藏书籍查询接口
   public function myfavorite($request){
   	$books=new Favorites();
   	$books=$books->leftJoin('books', 'favorites.book_id', '=', 'books.id');
   	$books=$books->where(['user_id'=>Auth::user()->id]);
   	//条件
   	if($request->input('book_name')!=null){
   		$books=$books->where('book_name','like','%'.$request->input('book_name').'%');
   	}
   	if($request->input('author')!=null){
   		$books=$books->where('author','like','%'.$request->input('author').'%');
   	}
   	if($request->input('ISBN')!=null){
   		$books=$books->where(['ISBN'=>$request->input('ISBN')]);
   	}
   	//条件
   	 
   	//页数 及每页显示记录的数量
   	$page=$request->input('page')>1?(int)$request->input('page'):1;
   	$limit=$request->input('limit')>0?(int)$request->input('limit'):10;
   	$start=($page-1)*$limit;
   	$total=$books->count();
   	$totalpages=ceil((float)$total/$limit);
   	$books=$books->skip($start)->take($limit)->get();
   	//页数 及每页显示记录的数量
   	 
   	//附件,库存,收藏状态
   	foreach ($books as $k=>$v){
   		$books[$k]['image']=BookAttach::where(['BookID'=>$v['book_id']])->where(['type'=>'image'])->first();
   		$books[$k]['image']=url('files/'.$books[$k]['image']['path']);
   		$favorite=array(
   				'book_id'=>$v['book_id'],
   				'user_id'=>Auth::user()->id
   		);
   		$books[$k]['favorite']=Favorites::where($favorite)->count()?true:false;
   		$books[$k]['storage']=BookStorage::where('book_id','=',$v['book_id'])->count();
   	}
   	//附件及库存
   	$this->json=array('status'=>true,'total'=>$total,'total_pages'=>$totalpages,'current_page'=>$page,'data'=>$books);
   }
   //加入个人书架
   public function dofavorite($request){
   		$check=Validator::make($request->all(),[
   			'book_id'=>'required|exists:books,id'
   		]);
   		if(!$check->fails()){
			$favorite=array(
				'book_id'=>$request->input('book_id'),
				'user_id'=>Auth::user()->id
			);
			if(!Favorites::where($favorite)->count()){
				Favorites::create($favorite);
			}
   			$this->json=array("status"=>true);
   		}else{
   			$this->json=array("status"=>false,'msg'=>'book_id is undefined!');
   		}
   }
   //移出个人书架
   public function dounfavorite($request){
   	$check=Validator::make($request->all(),[
   			'book_id'=>'required|exists:books,id'
   			]);
   	if(!$check->fails()){
   		$favorite=array(
   				'book_id'=>$request->input('book_id'),
   				'user_id'=>Auth::user()->id
   		);
   		Favorites::where($favorite)->delete();
   		$this->json=array("status"=>true);
   	}else{
   		$this->json=array("status"=>false,'msg'=>'book_id is undefined!');
   	}
   }
   //设置收藏备注
   public function docomment($request){
	   	$check=Validator::make($request->all(),[
	   		'book_id'=>'required|exists:favorites,book_id'
	   	]);
	   	if(!$check->fails()){
	   		$favorite=array(
	   				'book_id'=>$request->input('book_id'),
	   				'user_id'=>Auth::user()->id
	   		);
	   		Favorites::where($favorite)->update(['comment'=>$request->input('text')]);
	   		$this->json=array("status"=>true);
	   	}else{
	   		$this->json=array("status"=>false,'msg'=>'book_id is undefined!');
	   	}
   }
}

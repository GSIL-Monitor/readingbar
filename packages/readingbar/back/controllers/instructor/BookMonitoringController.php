<?php
namespace Readingbar\Back\Controllers\Instructor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Readingbar\Back\Controllers\BackController;
use Auth;
use Validator;
use Readingbar\Back\Models\Books;
use Readingbar\Back\Models\BookStorage;
class BookMonitoringController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'BookMonitoring.head_title','url'=>'admin/BookMonitoring','active'=>true),
	);
	//列表界面
	public function viewList(Request $request){
		$data['head_title']=trans('BookMonitoring.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$data['books']=$this->getList($request)->toJson();
		return $this->view('instructor.BookMonitoringList', $data);
	}
	//获取报告列表数据
	public function getList(Request $request){
		$order = $this->getOrder($request);
		$books=Books::where(function($where)use($request){
					if($request->input('book_name')){
						$where->where('books.book_name','like','%'.$request->input('book_name').'%');
					}
					if($request->input('author')){
						$where->where(['books.author'=>$request->input('author')]);
					}
					if($request->input('publisher')){
						$where->where(['books.publisher'=>$request->input('publisher')]);
					}

					if($request->input('ISBN')){
						$where->where(['books.ISBN'=>$request->input('ISBN')]);
					}
					if($request->input('BL')){
						$bls=explode('-',$request->input('BL'));
						if(count($bls)==2){
							$where->whereBetween('books.BL',$bls);
						}else{
							$where->where(['books.BL'=>(int)$request->input('BL')]);
						}
					}
					if($request->input('type')){
						$where->where(['books.type'=>$request->input('type')]);
					}
					if($request->input('IL')){
						$where->where(['books.IL'=>$request->input('IL')]);
					}
					if($request->input('ARQuizType')){
						$ARQuizTypes=explode(';',$request->input('ARQuizType'));
						foreach ($ARQuizTypes as $v){
							$where->where('books.ARQuizType','like','%'.$v.'%');
						}
					}
					if($request->input('ARQuizNo')){
						$where->where(['books.ARQuizNo'=>$request->input('ARQuizNo')]);
					}
					if($request->input('topic')){
						$where->where(['books.topic'=>$request->input('topic')]);
					}
				})
				->orderBy($order['column'],$order['sort'])
				->paginate($request->input('limit')?(int)$request->input('limit'):10);
		foreach ($books as $b){
			$b['image']="http://coverscans.renlearn.com/".$b['ISBN'].".jpg";
			$b['status1']=BookStorage::where(['status'=>1,'book_id'=>$b['id']])->count();
			$b['status23']=BookStorage::where(['book_id'=>$b['id']])->whereIn('status',[2,3])->count();
			$b['status4']=BookStorage::where(['status'=>4,'book_id'=>$b['id']])->count();
		}
		return $books;
	}
	public function getOrder($request) {
		if($request->input('type') || $request->input('BL') || $request->input('book_name')){
			$order=array(
					'column'=>'books.BL',
					'sort'=>'asc'
			);
		}else{
			$order=array(
					'column'=>'books.id',
					'sort'=>'desc'
			);
		}
		return $order;
	}
}
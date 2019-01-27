<?php
namespace Readingbar\Back\Controllers\Books;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use Readingbar\Back\Controllers\BackController;
use Validator;
use DB;
use Readingbar\Back\Models\BookStorageLog;
class BookStorageLogController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'bookStorageLog.head_title','url'=>'admin/gift/cards','active'=>true),
	);
	/*报损界面*/
	public function index(){
		$data['head_title']=trans('bookStorageLog.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		return $this->view('books.bookStorageLog', $data);
	}
	/*获取库存记录*/
	public function getLogs(Request $request){
		$order='bsl.id';
		if(in_array($request->input('order'),['book_id','id','serial','status','memo','created_at'])){
			$order='bsl.'.$request->input('order');
		}
		if(in_array($request->input('order'),['book_name','ISBN'])){
			$order='b.'.$request->input('order');
		}
		$sort=$request->input('sort')=='asc'?$request->input('sort'):'desc';
		
		$return=DB::table('book_storage_log as bsl')
					->crossjoin('books as b','bsl.book_id','=','b.id')
					->leftjoin('users as u','u.id','=','bsl.operate_by')
					->leftjoin('read_plan as rp','rp.id','=','bsl.plan_id')
					->leftjoin('students as s','s.id','=','rp.for')
					->leftjoin('star_account as sa','sa.asign_to','=','s.id')
					//->where(['bsl.status'=>5])
					->where(function($where)use($request){
						if($request->input('type')=='book_id'){
							$where->where(['bsl.book_id'=>$request->input('keyword')]);
						}
						if($request->input('type')=='ISBN'){
							$where->where('b.ISBN','=',$request->input('keyword'));
						}
						if($request->input('type')=='ARQuizNo'){
							$where->where('b.ARQuizNo','=',$request->input('keyword'));
						}
						if($request->input('type')=='memo'){
							$where->where('bsl.memo','like','%'.$request->input('keyword').'%');
						}
						if($request->input('type')=='created_at'){
							$where->where('bsl.created_at','like',$request->input('keyword').'%');
						}
						if($request->input('type')=='book_name'){
							$where->where('b.book_name','like','%'.$request->input('keyword').'%');
						}
						if($request->input('type')=='star_account'){
							$where->where('sa.star_account','=','readingbar'.$request->input('keyword'));
						}
						if(in_array($request->input('status'),[1,2,3,4,5])){
							$where->where(['bsl.status'=>$request->input('status')]);
						}
						if($request->input('serial')>0){
							if($request->input('serial')<10){
								$where->where(['bsl.serial'=>'0'.$request->input('serial')]);
							}else{
								$where->where(['bsl.serial'=>$request->input('serial')]);
							}
						}
					})
					->orderBy($order,$sort)
					->select(['s.nick_name as student','u.name as operator','bsl.id','b.id as book_id','b.isbn as ISBN','b.book_name','sa.star_account','bsl.serial','bsl.status','bsl.memo','bsl.created_at'])
					->paginate(
						$request->input('limit')>0?$request->input('limit'):10
					);
		foreach ($return as $k=>$v){
			$v->status=trans('bookStorageLog.status.'.$v->status);
		}
		return $return;
	}
	/*报损*/
	public function createLog(Request $request){
		$rules=[
				'book_id'=>'required|exsist:books,id',
				'serial'=>'required|exsist:book_storage,serial,book_id,'.$request->input('book_id')
		];
		$messages=trans('bookStorageLog.messages');
		$check=Validator::make($request->all(),$rules,$messages);
		if($check->passes()){
			BookStorageLog::create(
					array(
							'book_id'=>$request->input('book_id'),
							'serial'=>$request->input('serial'),
							'status'=>5,
							'operate_by'=>Auth()->id(),
							'memo'=>'书籍报损'
					)
			);
			$return=array('status'=>true,'success'=>'书籍已报损');
		}else{
			$return=array('status'=>false,'error'=>$check->errors()->first());
		}
		return $return;
	}
	
}
?>
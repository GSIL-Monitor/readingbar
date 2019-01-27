<?php
namespace Readingbar\Back\Controllers\Books;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use Readingbar\Back\Controllers\BackController;
use Storage;
use Validator;
use Excel;
use DB;
use Illuminate\Support\Facades\Cache;
use Readingbar\Back\Models\BooksImport;
use Readingbar\Back\Models\Books;
use Readingbar\Back\Models\BookStorage;
use Schema;
use Hamcrest\ResultMatcher;
class BooksImportController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'booksImport.head_title','url'=>'admin/books/booksImport','active'=>true),
	);
	/**
	 * 上传导入首页
	 */
	public function booksImport(){
		$data['head_title']=trans('booksImport.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		return $this->view('books.booksImport', $data);
	}
	/**
	 * 数据上传
	 */
	public function doImport(Request $request){
		// 校验上传excel
		if ($request->file('file') && in_array($request->file('file')->clientExtension(),['xls','xlsx'])) {
			// 保存文件
			$filePath='files/booksImport/'.time().'.'.$request->file('file')->clientExtension();
			Storage::put($filePath,file_get_contents($request->file('file')->getRealPath()));
			// 获取文件数据
			$books=Excel::load($filePath)->getSheet()->toArray();
			if (count($books)<=1) {
				return response([
						'success'=>false,
						'message'=> '记录不能为空！'
				],400);
			}else{
				$resetBooks = [];
				foreach ($books as $k1=>$v1) {
					if ($k1 != 0) {
						$book=[];
						foreach ($books[0] as $k2=>$v2) {
							if ($v2) {
								$book[strtolower($v2)] = trim(html_entity_decode($v1[$k2]),chr(0xc2).chr(0xa0));
							}
						}
						$resetBooks [] = $book;
					}
				}
				$books = $resetBooks;
			}
			
			// 校验数据字段
			$keys = collect($books[0])->keys()->all();
			$needKeys=['book_name','publisher','author','isbn','language','series','bl','il','arpts','wordcount','arquizno','arquiztype','type','topic','summary','price_usd','price_rmb','amount'];
			foreach ($needKeys as $v){
				if(!in_array($v,$keys)){
					return response([
							'success'=>false,
							'message'=> '您上传的数据缺少了字段'.$v.'请核对后再试!;'
					],400);
				}
			}
			BooksImport::where('id','>',0)->delete();
			// 校验数据/插入数据
			foreach ($books as $k=>$v) {
				$check=validator($v,[
						'book_name'=>'required|max:255',
						'publisher'=>'required|max:255',
						'author'=>'required|max:255',
						'isbn'=>'required|max:30',
						'language'=>'required|max:10',
						'series'=>'required|max:255',
						'bl'=>'required|max:10',
						'il'=>'required|max:10',
						'arpts'=>'required|numeric',
						'wordcount'=>'required|numeric',
						'arquizno'=>'required|max:10',
						'arquiztype'=>'required|max:255',
						'type'=>'required|max:255',
						'topic'=>'required|max:2500',
						'summary'=>'required|max:500',
						'price_usd'=>'required|numeric',
						'price_rmb'=>'required|numeric',
						'amount'=>'required|numeric'
				]);
				if ($check->passes()) {
					BooksImport::insert([
							'book_name'=>$v['book_name'],
							'publisher'=>$v['publisher'],
							'author'=>$v['author'],
							'isbn'=>$v['isbn'],
							'language'=>$v['language'],
							'series'=>$v['series'],
							'bl'=>$v['bl'],
							'il'=>$v['il'],
							'arpts'=>$v['arpts'],
							'wordcount'=>$v['wordcount'],
							'arquizno'=>$v['arquizno'],
							'arquiztype'=>$v['arquiztype'],
							'type'=>$v['type'],
							'topic'=>$v['topic'],
							'summary'=>$v['summary'],
							'price_usd'=>$v['price_usd'],
							'price_rmb'=>$v['price_rmb'],
							'amount'=>$v['amount']
					]);
				}else{
					//return $books;
					Storage::delete($filePath);
					BooksImport::where('id','>',0)->delete();
					return response([
							'success'=>false,
							'message'=> '第'.($k+2).'行:'.$check->errors()->first()
					],400);
				}
			}
			Storage::delete($filePath);
			return response([
					'success'=>true,
					'message'=> '已导入需处理的书籍信息，如若有误，请勿点击任何对书籍的处理,重新上传文件！'
			],200);
		}else {
			return response([
					'success'=>false,
					'message'=> '请上传excel文件！'
			],400);
		}
	}
	/**
	 * 保存文件
	 */
	public function saveFile($file){
		$extension=pathinfo($file->getClientOriginalName())['extension'];
		if($file && in_array($extension,['xls','xlsx'])){
			$dir='files/booksImport/'.time().'.'.$extension;
			Storage::put($dir,file_get_contents($file->getRealPath()));
			return $dir;
		}else{
			return false;
		}
	}
	/**
	 * 获取未处理的书籍
	 * @return boolean[]|boolean[]|string[]
	 */
	public function untreatedBooks(){
		$BooksImport=BooksImport::whereIn('dell_status',[0,2])->first();
		if($BooksImport){
			$books=array(
					'importBooks'=>$BooksImport,
					'existsBooks'=>Books::where(['ISBN'=>$BooksImport['ISBN']])->get()
			);
			return array('status'=>true,'data'=>$books);
		}else{
			return array('status'=>false,'暂无需要处理的书籍！');
		}
	}
	/**
	 * 书籍处理
	 */
	public function dellBooks(){
		$r=DB::select('select f_dellBooks() as result');
		if($r){
			if($r[0]->result){
				$json=array('status'=>true,'success'=>'您还有'.$r[0]->result.'记录需人工处理！');
			}else{
				$json=array('status'=>true,'success'=>'数据处理成功！');
			}
			
		}else{
			$json=array('status'=>false,'error'=>'函数执行失败！');
		}
		return $json;
	}
	/**
	 * 人工处理书籍
	 * @param Request $request
	 */
	public function manualHandling(Request $request){
		$json=array();
		switch ($request->input('dell_type')){
			case 'create':
				$r=DB::select('select f_dellBooks_create("'.$request->input('new_id').'") as result');
				if($r){
					if($r[0]->result){
						$json=array('status'=>true,'success'=>'数据处理成功！');
					}else{
						$json=array('status'=>false,'error'=>'数据处理失败！');
					}
				}else{
					$json=array('status'=>false,'error'=>'函数执行失败！');
				}
				break;
			case 'update':
				$r=DB::select('select f_dellBooks_update("'.$request->input('new_id').'","'.$request->input('old_id').'") as result');
				if($r){
					if($r[0]->result){
						$json=array('status'=>true,'success'=>'数据处理成功！');
					}else{
						$json=array('status'=>false,'error'=>'数据处理失败！');
					}
				}else{
					$json=array('status'=>false,'error'=>'函数执行失败！');
				}
				break;
			case 'delay':
				BooksImport::where(['id'=>$request->input('new_id')])->update(['dell_status'=>1]);
				$json=array('status'=>true,'success'=>'该记录暂不处理成功！');
				break;
			default:$json=array('status'=>false,'error'=>'处理方式不存在！');
		}
		return $json;
	}
}
?>
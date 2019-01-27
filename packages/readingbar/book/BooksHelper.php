<?php 
namespace Readingbar\Book;
use Readingbar\Book\Backend\Models\Books;
use Readingbar\Book\Backend\Models\BookAttach;
use Readingbar\Book\Backend\Models\BookStorage;
use Auth;
use Storage;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Readingbar\Back\Models\BookStorageLog;
class BooksHelper{
	private $book_id;
	public $books;
	public $book_attach;
	public $book_storage;
	public function __construct($book_id){
		$this->book_id=$book_id;
		$this->books=Books::where(['id'=>$this->book_id])->first();
		$this->book_attach=BookAttach::where(['BookID'=>$this->book_id])->get();
		$this->book_storage=BookStorage::where('book_id','=',$this->books['id'])->get();
	}
	//更新
	static function update($request){
		$data=$request->all();
		//books 主体   单条记录 更新
		$book=$data['book'];
		$book_id=$book['id'];
		Books::where(['id'=>$book_id])->update($data['book']);
		//根据book_id 记录book_storage
		$book_storages=isset($data['book_storage'])?$data['book_storage']:array();
		foreach ($book_storages as $key => $book_storage){
			$book_storage['book_id']=$book['id'];
			$book_storage['serial']=self::storage_book_id($key+1);
			$book_storage['operate_by']=Auth::id();
			$damage=isset($book_storage['damage']);
			unset($book_storage['damage']);
			if(isset($book_storage['id'])){
				if(isset($book_storage['status'])){
					unset($book_storage['status']);
				}
				$where=['id'=>$book_storage['id'],'book_id'=>$book['id']];
				BookStorage::where($where)
					->where('storage_full_name','<>',$book_storage['storage_full_name'])
					->orwhere($where)
					->where('serial','<>',$book_storage['serial'])
					->update($book_storage);
				//库存报损处理
				if($damage){
					BookStorageLog::create(
							array(
									'book_id'=>$book_storage['book_id'],
									'serial'=>$book_storage['serial'],
									'status'=>5,
									'operate_by'=>Auth()->id(),
									'memo'=>'书籍报损'
							)
					);
				}
			}else{
				$book_storage['status']=1;
				BookStorage::create($book_storage);
			}
		}
		//根据book_id 记录book_attach
		$attaches=isset($data['attach'])?$data['attach']:array();
		//var_dump($request->allFiles()['attachFiles']);exit;
		if($request->hasFile('attachFiles')){
			foreach ($request->allFiles()['attachFiles'] as $file){
				if (in_array($file->extension(),['jpg','png','jpeg','pdf','xls'])) {
					$r=self::saveAttach($file);
					if($r!==false){
						$attaches[]=$r;
					}
				}
			}
		}
		foreach ($attaches as $attach){
			$attach['BookID']=$book_id;
			if(isset($attach['id'])){
				$where=['id'=>$attach['id'],'BookID'=>$book_id];
				if(isset($attach['delete'])){
					BookAttach::where($where)->delete();
				}else{
					if(isset($attach['file'])){
						BookAttach::where($where)->update(self::saveAttach($attach['file']));
					}else{
						unset($attach['file']);
						BookAttach::where($where)->update($attach);
					}
				}
			}else{
				BookAttach::create($attach);
			}
		}
		Books::where(['id'=>$book_id])->update(['amount'=>BookStorage::where(['book_id'=>$book_id])->count()]);
	}
	//插入记录
	static function create($data){
		//books 主体   单条记录  插入返回book_id
		$book=$data['book'];
		$book_id=Books::create($book)->id;
		//根据book_id 记录book_storage
		$book_storages=isset($data['book_storage'])?$data['book_storage']:array();
		foreach ($book_storages as $key => $book_storage){
			$book_storage['book_id']=$book_id;
			$book_storage['serial']=self::storage_book_id($key+1);
			$book_storage['operate_by']=Auth::id();
			BookStorage::create($book_storage);
		}
		//根据book_id 记录book_attach
		$attaches=isset($data['attach'])?$data['attach']:array();
		foreach ($attaches as $attach){
			$attach['BookID']=$book_id;
			if(isset($attach['id'])){
				BookAttach::where(['id'=>$attach['id'],'BookID'=>$book_id])->update($attach);
			}else{
				BookAttach::create($attach);
			}
		}
		Books::where(['id'=>$book_id])->update(['amount'=>BookStorage::where(['book_id'=>$book_id])->count()]);
	}
	static function delete($seleted){
		if(is_array($seleted)){
			foreach ($seleted as $id){
				Books::where(['id'=>$id])->delete();
				BookAttach::where(['BookID'=>$id])->delete();
				BookStorage::where(['book_id'=>$id])->delete();
			}
		}else{
			Books::where(['id'=>$seleted])->delete();
			BookAttach::where(['BookID'=>$seleted])->delete();
			BookStorage::where(['book_id'=>$seleted])->delete();
		}
	}
	static function storage_book_id($id){
		switch($id){
			case $id<10:return '0'.$id;break;
			case $id<100:return $id;break;
			default:return $id;
		}
	}
	static function saveAttach($file){
		//var_dump($file->getClientOriginalName());exit;
		if($file){
			$filename=uniqid();
			if(in_array($file->extension(),['jpg','png','gif','jpeg'])){
				$type='image';
			}else{
				$type=$file->extension();
			}
			$title=substr($file->getClientOriginalName(),0,strrpos($file->getClientOriginalName(), '.'));
			$dir='files/books/'.$filename.'.'.$file->extension();
			Storage::put(
					$dir,
						file_get_contents($file->getRealPath())
			);
			$return=array(
				'path'=>$dir,
				'title'=>$title,
				'type'=>$type,
				'extension'=>$file->extension()
			);
			return $return;
		}else{
			return false;
		}
	}
}
?>
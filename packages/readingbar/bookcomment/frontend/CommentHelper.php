<?php 
namespace Readingbar\Bookcomment\Frontend;
use Validator;
use Readingbar\Bookcomment\Frontend\Models\book_comment;
class CommentHelper{
	static $status=1;
	static function comment($member,$ISBN,$comment){
		if(self::checkISBN($ISBN)){
			$c=array(
				'commented_by'=>$member,
				'ISBN'=>$ISBN,
				'comment'=>$comment,
				'status'=>self::$status,
			);
			book_comment::create($c);
			return true;
		}else{
			return trans('bookcomment.book_no_exist');
		}
	}
	//判断ISBN的书籍是否存在
	static function checkISBN($ISBN){
		$v=Validator::make([
			'ISBN'=>$ISBN
		],[
			'ISBN'=>'required|exists:books,ISBN'
		]);
		return !$v->fails();
	}
	//根据评论编号编辑评论内容
	static function editComment($id,$member,$comment){
		$v=Validator::make([
			'member'=>$member
		],[
			'member'=>'required|exists:book_comment,member,'.$id.',id'
		]);
		if($v->fails()){
			$c=array(
					'comment'=>$comment,
					'status'=>$status,
			);
			book_comment::where(['id'=>$id])->update($c);
			return true;
		}else{
			return trans('bookcomment.comment_no_exist');
		}
	}
}
?>
<?php

namespace Readingbar\Back\Controllers\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Readingbar\Back\Controllers\BackController;

use Auth;
use Validator;
use Readingbar\Back\Models\StarReportBooklist;

use PhpOffice\PhpWord\TemplateProcessor;
class StarReportBooklistController  extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'starreport.head_title','url'=>'admin/teacher','active'=>true),
	);
  	/**
	 * star报告列表
	 */
	public function index($id){
		$data['head_title']=trans('starreport.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$data['report_id']=$id;
		$this->storeBooklistDocx($id);
		return $this->view('teacher.starReportBookListList', $data);
	}
	public function getBooklist (Request $request) {
		return StarReportBooklist::crossJoin('books','books.id','=','book_id')->where(['report_id'=>$request->input('report_id')])->get([
				'star_report_booklist.id',
				'book_name',
				'author',
				'BL',
				'ARQuizNo',
				'reason'
		]);
	}
	public function store(Request $request){
		$check = validator($request->all(),[
				'report_id'=>'required|exists:star_report,id',
				'book_id'=>'required|exists:books,id',
				//'reason'=>'required|max:255'
		],[],[
				'report_id'=>'star报告',
				'book_id'=>'书籍',
				'reason'=>'推荐理由'
		]);
		if ($check->passes()) {
			if (StarReportBooklist::where(['report_id'=>$request->input('report_id')])->count()<20){
				$exists=StarReportBooklist::where([
						'report_id'=>$request->input('report_id'),
						'book_id'=>$request->input('book_id')
				])->first();
				if ($exists) { // 防止插入重复书籍
					StarReportBooklist::where(['id'=>$exists->id])->update($request->all());
					$result = StarReportBooklist::where(['id'=>$exists->id])->first();
				}else{
					$result = StarReportBooklist::create($request->all());
				}
				$this->storeBooklistDocx($request->input('report_id'));
				return response([
						'data'=>$result,
						'message'=>'数据已保存！'
				]);
			}else{
				return response(['message'=>'书单上限为20本！'],400);
			}
		}else{
			return response(['message'=>$check->errors()->first()],400);
		}
	}
	public function destory(Request $request){
		$check = validator($request->all(),[
				'id'=>'required|exists:star_report_booklist,id'
		],[],[
			'id'=>'书单'
		]);
		if ($check->passes()) {
			$result = StarReportBooklist::where(['id'=>$request->input('id')])->delete();
			return response([
					'message'=>'数据已删除！'
			]);
		}else{
			return response(['message'=>$check->errors()->first()],400);
		}
	}
	public function storeBooklistDocx($rid){
		$data=StarReportBooklist::crossJoin('books','books.id','=','book_id')->where(['report_id'=>$rid])->get([
				'book_name',
				'author',
				'BL',
				'ARQuizNo',
				'reason'
		])->toArray();
		// 获取word模板
		$template = new TemplateProcessor(storage_path('templates/report_booklist_template.docx'));
		
		for($i = 0;$i<20;$i++){ // 模板内参数替换
			$template->setValue('book_name_'.$i, isset($data[$i])?"【".$data[$i]['author']."】".$data[$i]['book_name']:''); 
			//$template->setValue('author_'.$i, isset($data[$i])?$data[$i]['author']:''); 
			$template->setValue('BL_'.$i, isset($data[$i])?$data[$i]['BL']:'');
			$template->setValue('ARQuizNo_'.$i, isset($data[$i])?$data[$i]['ARQuizNo']:'');
			//$template->setValue('reason_'.$i, isset($data[$i])?$data[$i]['reason']:'');
		}
		$dir='files/starReport/booklist/'.$rid.'.docx';
		$template->saveAs($dir);
	}
}

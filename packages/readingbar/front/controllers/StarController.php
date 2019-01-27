<?php

namespace Readingbar\Front\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use Readingbar\Api\Frontend\Models\ReadPlan;
use Readingbar\Api\Frontend\Models\Students;
use Readingbar\Api\Frontend\Models\StarAccountAsign;
use Superadmin\Backend\Models\User;
use Readingbar\Api\Frontend\Models\StarAccount;
use Readingbar\Api\Frontend\Models\StudentGroup;
use Messages;
use DB;
use Readingbar\Api\Frontend\Models\Members;
use Readingbar\Back\Models\StarReport;
use Storage;
use PhpOffice\PhpWord\TemplateProcessor;
use Readingbar\Back\Models\StarReportBooklist;
class StarController extends FrontController
{
	/*我的报告（star评测报告）*/
	public function index(){
		$data['head_title']='测试报告';
		$data['students']=Students::where(['parent_id'=>auth('member')->getId(),'del'=>0])
										->get()
										->each(function($item){
											$item['avatar']=url($item['avatar']);
											return $item;
										})
										->toJson();
		return $this->view('star.list',$data);
	}
	public function Booklist($id){
		$report=StarReport::where(['id'=>$id])->whereIn('student_id',function($query){
			$query->select('id')->from('students')->where(['parent_id'=>auth('member')->getId(),'del'=>0]);
		})->first();
		if($report){
				$data['head_title']='书单详情';
				$data['list']=StarReportBooklist::crossJoin('books','books.id','=','book_id')->where(['report_id'=>$id])->get([
					'book_name',
					'author',
					'BL',
					'ARQuizNo',
					'reason'
				])->toJson();
			return $this->view('star.booklist',$data);
		}else{
			abort(404);
		}
	}
	/**
	 * star报告详情-在线版
	 * 1.在线第一版 2018.10.30
	 * @param unknown $id
	 */
	public function SRD($id){
		$report=StarReport::where(['id'=>$id])->first();
		if ($report) {
			// 校验用户是否有查看的权限
			$member=auth('member')->user();
			$permission = \Readingbar\Back\Models\Students::where(['id'=>$report->student_id,'parent_id'=>$member->id])->count();
			if ($permission) {
				$data = $report->toArray();
				return $this->view('star.srd',$data);
			}else{
				return '您无权查看该报告！';
			}
		}else{
			return '报告不存在！';
		}
	}
}

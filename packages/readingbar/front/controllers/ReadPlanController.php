<?php

namespace Readingbar\Front\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use Readingbar\Api\Frontend\Models\ReadPlan;
use Readingbar\Api\Frontend\Models\Students;
use Readingbar\Api\Frontend\Models\ReadPlanDetail;
use Readingbar\Api\Frontend\Models\StarReport;
use Readingbar\Api\Frontend\Models\ReadPlanGoals;
use Readingbar\Api\Frontend\Models\ReadPlanProposal;
use Readingbar\Api\Frontend\Models\Orders;
use Readingbar\Back\Models\BookAttach;
use Readingbar\Back\Models\KuaidiniaoExpress;
class ReadPlanController extends FrontController
{
	/*孩子的阅读计划*/
	public function index(){
		$data['head_title']='孩子的阅读计划';
		$data['students']=Students::where(['parent_id'=>auth('member')->getId(),'del'=>0])
										->get()
										->each(function($item){
											$id=$item->id;
											$item['avatar']=url($item['avatar']);
											$item['starReportTimes']=StarReport::where(['student_id'=>$id])->count();
											$item['payingCustomers']=Students::hasService($id);
											//判断学生是否付费客户
											if($item['payingCustomers']){
												//获取学生测评次数
												$item['starTestTimes']=StarReport::where(['student_id'=>$id])->count();
												//获取付费用户当前使用的产品-判断用户是否享有阅读计划的服务
												$item['hasReadPlanService']=Students::hasReadPlanService($id);
											}
											return $item;
										})
										->toJson();
		return $this->view('member.childrenReadPlan',$data);
	}
	/*阅读计划详情*/
	public function detail($id){
		$data['head_title']='阅读计划';
		$rid=$id;
		$data['readPlan']=ReadPlan::leftjoin("students","students.id","=","read_plan.for")
					->where(['read_plan.id'=>$rid,'students.parent_id'=>auth('member')->getId()])
					->first(["read_plan.*","students.name as student_name",'students.id as student_id']);
		if($data['readPlan']){
			$data['readPlan']=$data['readPlan']->toArray();
			$data['readPlan']['Mr_pdf']=$data['readPlan']['Mr_pdf']?url($data['readPlan']['Mr_pdf']):null;
			$details=ReadPlanDetail::leftjoin('books','read_plan_detail.book_id','=','books.id')
										->where(['plan_id'=>$data['readPlan']['id']])
										->get(['read_plan_detail.*','books.book_name','books.ISBN','books.ARQuizNo','books.summary','books.BL','books.type'])
										->toArray();
			foreach ($details as $k=>$v){
				$details[$k]['Ar_pdf_rar_en']=$v['Ar_pdf_rar_en']?url($v['Ar_pdf_rar_en']):null;
				$details[$k]['Ar_pdf_rar_zh']=$v['Ar_pdf_rar_zh']?url($v['Ar_pdf_rar_zh']):null;
				$details[$k]['Ar_pdf_vt_en']=$v['Ar_pdf_vt_en']?url($v['Ar_pdf_vt_en']):null;
				$details[$k]['Ar_pdf_vt_zh']=$v['Ar_pdf_vt_zh']?url($v['Ar_pdf_vt_zh']):null;
				$details[$k]['Ar_pdf_rwaar_en']=$v['Ar_pdf_rwaar_en']?url($v['Ar_pdf_rwaar_en']):null;
				$details[$k]['Ar_pdf_rwaar_zh']=$v['Ar_pdf_rwaar_zh']?url($v['Ar_pdf_rwaar_zh']):null;
				$images=BookAttach::where(['BookId'=>$v['book_id']])->get(['path'])->each(function($item,$key){
					 $item['href']=url($item['path']);
					 return $item;
				})->toArray();
				if(count($images)>0){
					$details[$k]['images']=$images;
				}else{
					$details[$k]['images'][]=['href'=>config('readingbar.isbnImage').$v['ISBN'].".jpg"];
				}
			}
			//计划建议信息
			$data['readPlan']['proposal']=ReadPlanProposal::where(['plan_id'=>$rid])->get()->toArray();
			//计划目标信息
			$data['readPlan']['goals']=ReadPlanGoals::where(['plan_id'=>$rid])->get()->toArray();
			$data['readPlan']['details']=$details;
			$data['readPlan']['express_1']=KuaidiniaoExpress::crossjoin('kdniao_express_code','express_code','=','shipper_code')->where(['plan_id'=>$data['readPlan']['id'],'type'=>1])->first();
			$data['readPlan']['express_2']=KuaidiniaoExpress::crossjoin('kdniao_express_code','express_code','=','shipper_code')->where(['plan_id'=>$data['readPlan']['id'],'type'=>2])->first();
			
			// 修改标题
			$data['head_title']=$data['readPlan']['type']==0?$data['head_title']:'我的书单';
			return $this->view('member.childrenReadPlanDetail',$data);
		}else{
			return redirect('/member')->with(['alert'=>'您无权查看该阅读计划！']);
		}
	}
	/*Ar报告*/
	public function arReports($id,$lang){
		$data['head_title']='AR报告';
		$rpd=ReadPlanDetail::where(['id'=>$id])->first();
		if($rpd && in_array($lang,['en','zh'])){
			$a=$rpd['Ar_pdf_rar_'.$lang]!='';
			$b=$rpd['Ar_pdf_vt_'.$lang]!='';
			$c=$rpd['Ar_pdf_rwaar_'.$lang]!='';
			if($a || $b|| $c){
				$data['rpd']['Ar_pdf_rar']=$a?url($rpd['Ar_pdf_rar_'.$lang]):null;
				$data['rpd']['Ar_pdf_vt']=$b?url($rpd['Ar_pdf_vt_'.$lang]):null;
				$data['rpd']['Ar_pdf_rwaar']=$c?url($rpd['Ar_pdf_rwaar_'.$lang]):null;
				return $this->view('member.childrenReadPlanArReports',$data);
			}else{
				return reidrect()->back();
			}
		}else{
			return reidrect()->back();
		}
	}
}

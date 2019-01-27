<?php

namespace Readingbar\Front\Controllers\Ranking;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Readingbar\Front\Controllers\FrontController;
use App\Http\Requests;
use DB;
class RankingController extends FrontController
{
	/*蕊丁吧排行榜*/
	public function index(){
		$data['head_title']='达人排行榜';
		//获取需要的日期
		$ctime=time();
		$cy=(int)date('Y',$ctime);
		$cm=(int)date('m',$ctime);
		$cd=(int)date('d',$ctime);
		if($cd>=10){
			if($cm-1>0){
				$ym=date("Y-m",strtotime($cy.'-'.($cm-1).'-01'));
			}else{
				$ym=date("Y-m",strtotime(($cy-1).'-12-01'));
			}
		}else{
			if($cm-2>0){
				$ym=date("Y-m",strtotime($cy.'-'.($cm-2).'-01'));
			}else{
				$ym=date("Y-m",strtotime(($cy-1).'-'.(12+($cm-2)).'-01'));
			}
		}
		$rds=DB::table('ranking as r')
				->leftjoin('students as s','r.student_id','=','s.id')
				->leftjoin('star_account as sa','sa.asign_to','=','s.id')
				->where(['date'=>$ym])
				->get(['r.type','r.words','r.books','s.avatar','s.nick_name','s.grade','sa.star_account']);
		foreach (['words','books'] as $v){
			$data[$v]=array();
		}
		foreach ($rds as $v){
			$v->avatar=url($v->avatar);
			$v->grade=strtoupper('G'.$v->grade);
			$data[$v->type][]=$v;
		}
		$data['max_books']=collect($data['books'])->max('books');
		$data['max_words']=collect($data['words'])->max('words');
		$data['date']=date('m月',strtotime($ym));
		return $this->view('ranking.index',$data);
	}
}

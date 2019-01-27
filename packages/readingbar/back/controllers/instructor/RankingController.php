<?php
namespace Readingbar\Back\Controllers\Instructor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Readingbar\Back\Controllers\BackController;
use Auth;
use Validator;
use DB;
use Readingbar\Back\Models\Ranking;
use Readingbar\Back\Models\Students;
use Readingbar\Back\Controllers\Spoint\PointController;
class RankingController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'ranking.head_title','url'=>'admin/ranking','active'=>true),
	);
	//列表界面
	public function viewRanking(Request $request){
		$data['head_title']=trans('Ranking.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		return $this->view('instructor.Ranking', $data);
	}
	//获取排行更具日期
	public function getRs(Request $request){
		$check=Validator::make($request->all(),[
				'date'=>'required|date'
		]);
		if($check->passes()){
			$date=$request->input('date');
		}else{
			$date=date('Y-m',time());
		}
		$data['books']=Ranking::crossJoin('students as s','s.id','=','ranking.student_id')->leftjoin('star_account as sa','sa.asign_to','=','s.id')->where(['type'=>'books','date'=>$date])->orderBy('books','desc')
		->get(['*','ranking.id as rid',DB::raw('IF(ranking.award_point,"'.trans('ranking.form.award_point.0').'","'.trans('ranking.form.award_point.1').'") as award_point')]);
		$data['books_improved']=Ranking::crossJoin('students as s','s.id','=','ranking.student_id')->leftjoin('star_account as sa','sa.asign_to','=','s.id')->where(['type'=>'books_improved','date'=>$date])->orderBy('books','desc')
		->get(['*','ranking.id as rid',DB::raw('IF(ranking.award_point,"'.trans('ranking.form.award_point.0').'","'.trans('ranking.form.award_point.1').'") as award_point')]);
		$data['words']=Ranking::crossJoin('students as s','s.id','=','ranking.student_id')->leftjoin('star_account as sa','sa.asign_to','=','s.id')->where(['type'=>'words','date'=>$date])->orderBy('words','desc')
		->get(['*','ranking.id as rid',DB::raw('IF(ranking.award_point,"'.trans('ranking.form.award_point.0').'","'.trans('ranking.form.award_point.1').'") as award_point')]);
		$data['words_improved']=Ranking::crossJoin('students as s','s.id','=','ranking.student_id')->leftjoin('star_account as sa','sa.asign_to','=','s.id')->where(['type'=>'words_improved','date'=>$date])->orderBy('words','desc')
		->get(['*','ranking.id as rid',DB::raw('IF(ranking.award_point,"'.trans('ranking.form.award_point.0').'","'.trans('ranking.form.award_point.1').'") as award_point')]);
		
		$data['arp']=Ranking::crossJoin('students as s','s.id','=','ranking.student_id')->leftjoin('star_account as sa','sa.asign_to','=','s.id')->where(['type'=>'arp','date'=>$date])->orderBy('ARPoints','desc')
		->get(['*','ranking.id as rid',DB::raw('IF(ranking.award_point,"'.trans('ranking.form.award_point.0').'","'.trans('ranking.form.award_point.1').'") as award_point')]);
		return $data;
	}
	//获取学生
	public function getStudents(Request $request){
		$check=Validator::make($request->all(),[
				'star_account'=>'required'
		]);
		if($check->passes()){
			$students=Students::leftjoin('star_account as sa','sa.asign_to','=','students.id')->where('sa.star_account','like',$request->input('star_account').'%')->get(['students.id','students.name']);
		}else{
			$students=Students::get(['id','name']);
		}
		return $students;
	}
	//新增记录
	public function create(Request $request){
		$check=Validator::make($request->all(),[
				'student_id'=>'required|exists:students,id',
				'type'		=>'required|in:arp,words,books,words_improved,books_improved',
				'type_v'		=>'required|integer',
				'date'		=>'required|date'
		],trans('ranking.messages'),trans('ranking.attributes'));
		if($check->passes()){
			$e=Ranking::where([
					'date'		=>$request->input('date'),
					'type'		=>$request->input('type')
			])->count();
			if($e>=10){
				return array('status'=>false,'error'=>'本月记录已满10条！');
			}
			$e=Ranking::where([
					'student_id'=>$request->input('student_id'),
					'date'		=>$request->input('date'),
					'type'		=>$request->input('type')
			])->count();
			if(!$e){
				$create=array(
						'student_id'=>$request->input('student_id'),
						'date'		=>$request->input('date'),
						'type'		=>$request->input('type'),
				);
				switch ($request->input('type')){
					case 'arp':$create['ARPoints']=$request->input('type_v');break;
					case 'books':$create['books']=$request->input('type_v');break;
					case 'words':$create['words']=$request->input('type_v');break;
					case 'books_improved':$create['books_improved']=$request->input('type_v');break;
					case 'words_improved':$create['words_improved']=$request->input('type_v');break;
				}
				Ranking::create($create);
				
				return array('status'=>true,'success'=>'数据已保存');
			}else{
				return array('status'=>false,'error'=>'当前记录该月份已添加！');
			}
		}else{
			return array('status'=>false,'error'=>$check->errors()->first());
		}
	}
	//删除记录
	public function delete(Request $request){
		$check=Validator::make($request->all(),[
				'id'=>'required|exists:ranking,id'
		],trans('ranking.messages'),trans('ranking.attributes'));
		if($check->passes()){
			Ranking::where(['id'=>$request->input('id')])->delete();
			return array('status'=>true,'success'=>'数据已删除');
		}else{
			return array('status'=>false,'error'=>$check->errors()->first());
		}
	}
	//授予积分
	public function awardPoint(Request $request){
		$check=Validator::make([
				'id'=>$request->input('id'),
				'award_point'=>$request->input('id')
		],[
				'id'=>'required|exists:ranking,id',
				'award_point'=>'exists:ranking,id,award_point,0'
		],trans('ranking.messages'),trans('ranking.attributes'));
		if($check->passes()){
			Ranking::where(['id'=>$request->input('id')])->update(['award_point'=>1]);
			$r=Ranking::where(['id'=>$request->input('id')])->first();
			PointController::increaceByRule([
					'rule'=>'in_ranking',
					'student_id'=>$r->student_id,
					'memo'=>trans('ranking.tabs.'.$r->type)
			]);
			return array('status'=>true,'success'=>'积分发放成功！');
		}else{
			return array('status'=>false,'error'=>$check->errors()->first());
		}
	}
}
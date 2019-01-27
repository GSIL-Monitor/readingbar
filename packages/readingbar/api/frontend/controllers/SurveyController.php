<?php

namespace Readingbar\Api\Frontend\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use Readingbar\Api\Frontend\Models\Survey;
use Readingbar\Api\Frontend\Models\SurveyAnswer;
use Validator;
use Readingbar\Api\Frontend\Models\Students;
class SurveyController extends FrontController
{
	private $member=null;
	public function __construct(){
		$this->member=auth('member')->member();
	}
	/*获取调查内容*/
	public function getSurvey(){
		$survey=Survey::orderby('id','asc')->get()->toArray();
		$this->json=array('status'=>true,'success'=>'数据获取成功！','data'=>$survey);
		$this->echoJson();
	}
	/*提交调查内容*/
	public function submitSurvey(Request $request){
		//answer数据格式
// 		$answer=array(
// 				'answer_to_1'=>1,
// 				'answer_to_2'=>2,
// 				'answer_to_3'=>1,
// 				'answer_to_4'=>2,
// 				'answer_to_5'=>2,
// 				'answer_to_6'=>1,
// 				'answer_to_7'=>2,
// 				'answer_to_8'=>1,
// 				'answer_to_9'=>1,
// 				'answer_to_10'=>1,
// 				'answer_to_11'=>1,
// 				'answer_to_12'=>1,
// 				'answer_to_13'=>1,
// 				'answer_to_14'=>[1,2,3],
// 				'answer_to_15'=>'1231232',
// 				'answer_to_16'=>[1,2,3],
// 				'answer_to_17'=>1,
// 				'answer_to_18'=>[1,2,3],
// 				'answer_to_18_text'=>[2=>'培训机构',4=>'设计']
// 		);
		$input=array(
			'student_id'=>$request->input('student_id'),
			'answer'=>$request->input('answer'),
		);
		$rules=array(
			'student_id'=>'required|exists:students,id,survey_status,0,parent_id,'.$this->member->id,
			'answer'=>'required|array',
		);
		$attributes=array(
			'student_id'=>'student_id',
			'answer'=>'answer'
		);
		$check=Validator::make($input,$rules,array(),$attributes);
		if($check->passes()){
			$answer=$request->input('answer');
			$survey=Survey::orderby('id','asc')->get()->toArray();
			$survey_answer=array();
			$nextId=1;
			foreach ($survey as $k=>$v){
				if($nextId==$v['id'] && !$this->json){
					if($v['required']==1 && !isset($answer['answer_to_'.$v['id']])){
						$this->json=array('status'=>false,'error'=>'问题对应回答不存在！');
						break;
					}
					if(isset($answer['answer_to_'.$v['id']])){
						switch($v['answer_type']){
							case "1":
									$option_id=$answer['answer_to_'.$v['id']];
									if(!isset($v['option'.$option_id])){
											$this->json=array('status'=>false,'error'=>'问题对应选项不存在！');
											break;
									}
									$a=array(
											'student_id'=>$input['student_id'],
											'survey_id'=>$v['id'],
											'answer'.$option_id=>$v['option'.$option_id]
									);
									$survey_answer[]=$a;
								
							break;
							case "2":;
									$a=array(
										'student_id'=>$input['student_id'],
										'survey_id'=>$v['id']
									);
									foreach ($answer['answer_to_'.$v['id']] as $option_id){
										if(!isset($v['option'.$option_id])){
											$this->json=array('status'=>false,'error'=>'问题对应选项不存在！');
											break;
										}
										if(strpos($v['option'.$option_id],"[input]")){
											if(isset($answer['answer_to_'.$v['id'].'_text'])){
												$a['answer'.$option_id]=str_replace('[input]',$answer['answer_to_'.$v['id'].'_text'][$option_id],$v['option'.$option_id]);
											}else{
												$this->json=array('status'=>false,'error'=>'复选输入的对应参数不存在！');
											}
										}else{
											$a['answer'.$option_id]=$v['option'.$option_id];
										}
									}
									$survey_answer[]=$a;
							break;
							case "3":
								$a=array(
										'student_id'=>$input['student_id'],
										'survey_id'=>$v['id'],
										'answer1'=>$answer['answer_to_'.$v['id']]
								);
								$survey_answer[]=$a;
						}
					}
					if($v['YesNextID']!=null && $option_id==1){
						$nextId=(int)$v['YesNextID'];
					}else if($v['NoNextID']!=null && $option_id==2){
						$nextId=(int)$v['NoNextID'];
					}elseif($v['NextID']!==null){
						$nextId=(int)$v['NextID'];
					}
				}
			}
			if(!$this->json){
				if($nextId===0){
					foreach ($survey_answer as $a){
						SurveyAnswer::create($a);
					}
					//改变学生调查状态
					Students::where(['id'=>$input['student_id']])->update(['survey_status'=>1]);
					$this->json=array('status'=>true,'success'=>'调查完成！');
				}else{
					$this->json=array('status'=>false,'error'=>'调查失败！(第'.$nextId.'题错误！)');
				}
			}
		}else{
			//var_dump($check->messages());
			$this->json=array('status'=>false,'error'=>'答案提交失败！','inputerrors'=>$check->messages()->toArray());
		}
		$this->echoJson();
	}
}

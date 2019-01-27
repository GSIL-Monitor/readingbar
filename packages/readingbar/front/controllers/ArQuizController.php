<?php

namespace Readingbar\Front\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use Readingbar\Api\Frontend\Models\ReadPlan;
use Readingbar\Api\Frontend\Models\Students;

class ArQuizController extends FrontController
{
	/*AR Quiz解读报告*/
	public function index($id){
		$data['head_title']='AR Quiz解读报告';
		$data['student_id']=$id;
		$data['student']=Students::where(['id'=>$id,'parent_id'=>auth('member')->getId()])->first();
// 		if($data['student']){
// 			return $this->view('arquiz.list',$data);
// 		}else{
// 			return redirect('/');
// 		}
		return $this->view('arquiz.list',$data);
	}
}

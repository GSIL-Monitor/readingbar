<?php

namespace Readingbar\Front\Controllers\Activity;
use Illuminate\Http\Request;
use Readingbar\Front\Controllers\FrontController;
use App\Http\Requests;

class PublicBenefitActivitiesController extends FrontController
{
	/*感恩节活动*/
	public function index(){
		$data['head_title']='公益活动';
		return $this->view('activity.PublicBenefitActivities1',$data);
	}
}

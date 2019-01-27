<?php

namespace Readingbar\Front\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;

class IntroduceController extends FrontController
{
	/*服务介绍*/
	public function service(){
		$data['head_title']='服务介绍界面';
		return $this->view('introduce.service',$data);
	}
	/*用户指南*/
	public function userGuide(){
		$data['head_title']='用户指南';
		return $this->view('introduce.userguide',$data);
	}
	/*加入我们*/
	public function joinus(){
		$data['head_title']='加入我们';
		return $this->view('introduce.joinus',$data);
	}
	/*商务合作*/
	public function cooperation(){
		$data['head_title']='商务合作';
		return $this->view('introduce.cooperation',$data);
	}
	/*蕊丁使者*/
	public function RDMessenger(){
		$data['head_title']='蕊丁使者';
		return $this->view('introduce.RDMessenger',$data);
	}
	/*服务理念*/
	public function service_idea(){
		$data['head_title']='服务理念';
		return $this->view('introduce.service_idea',$data);
	}
	/*服务特色*/
	public function service_characteristic(){
		$data['head_title']='服务特色';
		return $this->view('introduce.service_characteristic',$data);
	}
	/*一书一心*/
	public function oneBookOneHeart(){
		$data['head_title']='一书一心';
		return $this->view('introduce.oneBookOneHeart',$data);
	}
}

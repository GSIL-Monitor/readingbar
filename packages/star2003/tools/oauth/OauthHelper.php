<?php
namespace Tools\Oauth;
use Tools\Oauth\Services\QQ;
class  OauthHelper{
	private $service;
	public function service($service){
		if(!file_exists(__DIR__.'/services/'.$service.".php")){
			echo '<meta charset="UTF8">';
			exit('该'.$service.'服务不存在！');
		}
		$className=__NAMESPACE__."\\Services\\".$service;
		$this->service=new $className;
		return $this;
	}
	public function redirect(){
		return $this->service->redirect();
	}
	public function user(){
		return $this->service->user();
	}
}
?>
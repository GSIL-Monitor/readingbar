<?php 
	Route::get('message',function(){
		Messages::sendMessage('584231366@qq.com',"test","myname is tjj");
	});
?>
<?php 
Route::group(['middleware' => 'web'], function () {
	Route::get('oauth/{service}',function($service){
		return Oauth::service($service)->redirect();
	});
	//修改至第3方信息操作控制器
	Route::get('oauth/{service}/login','Readingbar\Api\Frontend\Controllers\LoginController@loginByOauth');
});
?>
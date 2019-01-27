<?php 
	Route::group(['middleware' => 'pauth','prefix'=>'admin'], function () {
		/* 阿里大鱼消息模板管理 */
		Route::group(['prefix'=>'alidayuTpl'], function () {
			Route::get('/list',['as'=>'admin.alidayuTpl.index','uses'=>'Readingbar\Back\Controllers\Messages\AlidayuTplController@index']);
			Route::post('/update',['as'=>'admin.alidayuTpl.update','uses'=>'Readingbar\Back\Controllers\Messages\AlidayuTplController@update']);
			Route::post('/store',['as'=>'admin.alidayuTpl.store','uses'=>'Readingbar\Back\Controllers\Messages\AlidayuTplController@store']);
			Route::post('/delete',['as'=>'admin.alidayuTpl.destroy','uses'=>'Readingbar\Back\Controllers\Messages\AlidayuTplController@destroy']);
			Route::post('/test',['as'=>'admin.alidayuTpl.sendTest','uses'=>'Readingbar\Back\Controllers\Messages\AlidayuTplController@sendTest']);
		});
		/* 阿里大鱼消息发送设置 */
		Route::group(['prefix'=>'alidayuSendSetting'], function () {
			Route::get('/',['as'=>'admin.alidayuSendSetting.index','uses'=>'Readingbar\Back\Controllers\Messages\AlidayuSendSettingController@index']);
			Route::post('/update',['as'=>'admin.alidayuSendSetting.update','uses'=>'Readingbar\Back\Controllers\Messages\AlidayuSendSettingController@update']);
			Route::post('/store',['as'=>'admin.alidayuSendSetting.store','uses'=>'Readingbar\Back\Controllers\Messages\AlidayuSendSettingController@store']);
			Route::post('/delete',['as'=>'admin.alidayuSendSetting.destroy','uses'=>'Readingbar\Back\Controllers\Messages\AlidayuSendSettingController@destroy']);
		});
	});
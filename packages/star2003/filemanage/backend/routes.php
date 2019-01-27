<?php
	Route::group(['middleware' => 'pauth','prefix'=>'admin'], function () {
		// 在这一行下面
		Route::get('filemanage', ['as'=>'admin.filemanage.index','uses'=>'Filemanage\Backend\Controllers\FilemanageController@index']);
		Route::get('filemanage/operations', ['as'=>'admin.filemanage.operations','uses'=>'Filemanage\Backend\Controllers\FilemanageController@operations']);
		Route::post('filemanage/upload', ['as'=>'admin.filemanage.upload','uses'=>'Filemanage\Backend\Controllers\FilemanageController@file_upload']);

	});
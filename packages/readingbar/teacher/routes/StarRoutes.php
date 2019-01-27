<?php
	Route::group(['middleware' => 'pauth','prefix'=>'admin'], function () {
		Route::get('/staraccount',['as'=>'admin.staraccount.index','uses'=>'Readingbar\Teacher\Backend\Controllers\StarAccountController@index']);
		Route::get('/staraccount/create',['as'=>'admin.staraccount.create','uses'=>'Readingbar\Teacher\Backend\Controllers\StarAccountController@create']);
		Route::get('/staraccount/list',['as'=>'admin.staraccount.list','uses'=>'Readingbar\Teacher\Backend\Controllers\StarAccountController@accountsList']);
		Route::get('/staraccount/changeStatus',['as'=>'admin.staraccount.changeStatus','uses'=>'Readingbar\Teacher\Backend\Controllers\StarAccountController@changeStatus']);
		Route::get('/staraccount/changeGrade',['as'=>'admin.staraccount.changeGrade','uses'=>'Readingbar\Teacher\Backend\Controllers\StarAccountController@changeGrade']);
		Route::get('/staraccount/resetPassword',['as'=>'admin.staraccount.resetPassword','uses'=>'Readingbar\Teacher\Backend\Controllers\StarAccountController@resetPassword']);
		
		
		Route::get('/staraccountasign',['as'=>'admin.staraccountasign.index','uses'=>'Readingbar\Teacher\Backend\Controllers\StarAccountAsignController@index']);
		Route::get('/staraccountasign/appliesList',['as'=>'admin.staraccountasign.appliesList','uses'=>'Readingbar\Teacher\Backend\Controllers\StarAccountAsignController@appliesList']);
		Route::get('/staraccountasign/accounts',['as'=>'admin.staraccountasign.accounts','uses'=>'Readingbar\Teacher\Backend\Controllers\StarAccountAsignController@starAccountsOfTeacher']);
		Route::get('/staraccountasign/asign',['as'=>'admin.staraccountasign.asign','uses'=>'Readingbar\Teacher\Backend\Controllers\StarAccountAsignController@asign']);
		Route::get('/staraccountasign/informParents',['as'=>'admin.staraccountasign.informParents','uses'=>'Readingbar\Teacher\Backend\Controllers\StarAccountAsignController@informParents']);
		
// 		Route::get('/starreport',['as'=>'admin.starreport.index','uses'=>'Readingbar\Teacher\Backend\Controllers\StarReportController@index']);
// 		Route::get('/starreport/getReports',['as'=>'admin.starreport.getReports','uses'=>'Readingbar\Teacher\Backend\Controllers\StarReportController@getReports']);
// 		Route::get('/starreport/getStudents',['as'=>'admin.starreport.getStudents','uses'=>'Readingbar\Teacher\Backend\Controllers\StarReportController@getStudents']);
// 		Route::get('/starreport/createReport',['as'=>'admin.starreport.createReport','uses'=>'Readingbar\Teacher\Backend\Controllers\StarReportController@createReport']);
// 		Route::get('/starreport/editReport',['as'=>'admin.starreport.editReport','uses'=>'Readingbar\Teacher\Backend\Controllers\StarReportController@editReport']);
// 		Route::get('/starreport/deleteReport',['as'=>'admin.starreport.deleteReport','uses'=>'Readingbar\Teacher\Backend\Controllers\StarReportController@deleteReport']);
	});
?> 


<?php
	Route::group(['middleware' => 'pauth','prefix'=>'admin'], function () {
		//Route::resource('/tstudents','Readingbar\Teacher\Backend\Controllers\TstudentsController');
		Route::get('/tstudents',['as'=>'admin.tstudents.index','uses'=>'Readingbar\Teacher\Backend\Controllers\TstudentsController@index']);
		Route::get('/tstudents/readPlansView',['as'=>'admin.tstudents.readPlansView','uses'=>'Readingbar\Teacher\Backend\Controllers\TstudentsController@readPlansView']);
		Route::get('/tstudents/exportStudents',['as'=>'admin.tstudents.exportStudents','uses'=>'Readingbar\Teacher\Backend\Controllers\TstudentsController@exportStudents']);
		Route::get('/tstudents/{type}',['as'=>'admin.tstudents.show','uses'=>'Readingbar\Teacher\Backend\Controllers\TstudentsController@show']);
		Route::post('/tstudents/{type}',['as'=>'admin.tstudents.store','uses'=>'Readingbar\Teacher\Backend\Controllers\TstudentsController@store']);
	});
	
?> 


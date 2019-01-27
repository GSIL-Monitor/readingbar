<?php
// 	Route::group(['middleware' => 'member','prefix'=>'member'], function () {
// 		Route::get('student/{student_id}/survey','Readingbar\Survey\Frontend\Controllers\SurveyController@index');
// 		Route::post('student/survey/{survey_id}','Readingbar\Survey\Frontend\Controllers\SurveyController@answer');
// 	});
	Route::group(['middleware' => 'pauth','prefix'=>'admin'], function () {
		Route::get('survey',['as'=>'admin.survey.memberList','uses'=>'Readingbar\Survey\Backend\Controllers\SurveyController@memberList']);
		Route::get('survey/ajax_studentList',['as'=>'admin.survey.ajax_memberList','uses'=>'Readingbar\Survey\Backend\Controllers\SurveyController@ajax_studentList']);
		Route::get('survey/{student_id}/result',['as'=>'admin.survey.result','uses'=>'Readingbar\Survey\Backend\Controllers\SurveyController@resultSurvey']);
	});
?> 


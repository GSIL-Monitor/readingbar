<?php
	Route::group(['middleware' => 'pauth','prefix'=>'admin'], function () {
		Route::resource('/bookmanager','Readingbar\Bookmanager\Backend\Controllers\BookmanagerController');
	});
	Route::group(['middleware' => 'pauth','prefix'=>'admin'], function () {
		Route::get('/lendBook',['as'=>'admin.lendBook','uses'=>'Readingbar\Bookmanager\Backend\Controllers\BookLendByReadPlanController@index']);
		Route::get('/lendBook/refund',['as'=>'admin.lendBook.dolend','uses'=>'Readingbar\Bookmanager\Backend\Controllers\BookLendByReadPlanController@refund']);
		Route::get('/lendBook/doLend',['as'=>'admin.lendBook.dolend','uses'=>'Readingbar\Bookmanager\Backend\Controllers\BookLendByReadPlanController@lendBooks']);
		Route::get('/lendBook/getReadPlans',['as'=>'admin.lendBook.getReadPlans','uses'=>'Readingbar\Bookmanager\Backend\Controllers\BookLendByReadPlanController@getReadPlans']);
		Route::POST('/lendBook/recordSCN',['as'=>'admin.lendBook.recordSCN','uses'=>'Readingbar\Bookmanager\Backend\Controllers\BookLendByReadPlanController@recordSCN']);
		Route::POST('/lendBook/recordRCN',['as'=>'admin.lendBook.recordRCN','uses'=>'Readingbar\Bookmanager\Backend\Controllers\BookLendByReadPlanController@recordRCN']);
	});
	Route::group(['middleware' => 'pauth','prefix'=>'admin'], function () {
		Route::get('/recoveryBook',['as'=>'admin.recoveryBook','uses'=>'Readingbar\Bookmanager\Backend\Controllers\BookRecoveryByReadPlanController@index']);
		Route::get('/recoveryBook/getReadPlans',['as'=>'admin.recoveryBook.getReadPlans','uses'=>'Readingbar\Bookmanager\Backend\Controllers\BookRecoveryByReadPlanController@getReadPlans']);
		Route::post('/recoveryBook/{id}/recovery',['as'=>'admin.recoveryBook.recovery','uses'=>'Readingbar\Bookmanager\Backend\Controllers\BookRecoveryByReadPlanController@recovery']);
		Route::post('/recoveryBook/{id}/loss',['as'=>'admin.recoveryBook.loss','uses'=>'Readingbar\Bookmanager\Backend\Controllers\BookRecoveryByReadPlanController@loss']);
		Route::post('/recoveryBook/{id}/notReturned',['as'=>'admin.recoveryBook.notReturned','uses'=>'Readingbar\Bookmanager\Backend\Controllers\BookRecoveryByReadPlanController@notReturned']);
	});
?> 


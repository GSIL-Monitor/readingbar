<?php
	Route::group(['middleware' => 'member','prefix'=>'comment'], function () {
		Route::get('/comment','Readingbar\Bookcomment\Frontend\Controllers\CommentController@comment');
		Route::get('/edit','Readingbar\Bookcomment\Frontend\Controllers\CommentController@edit');
	});
	Route::group(['middleware' => 'web','prefix'=>'comment'], function () {
		Route::get('/list','Readingbar\Bookcomment\Frontend\Controllers\CommentController@commentsjson');
		Route::get('/{id}/info','Readingbar\Bookcomment\Frontend\Controllers\CommentController@commentjson');
		Route::get('/demo',function(){return view('Readingbar/bookcomment/frontend::demo');});
	});
?> 


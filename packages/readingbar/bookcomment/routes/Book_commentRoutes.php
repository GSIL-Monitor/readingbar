<?php
	Route::group(['middleware' => 'pauth','prefix'=>'admin'], function () {
		Route::get('/book_comment/ajax_comments',['as'=>'admin.book_comment.ajax_comments','uses'=>'Readingbar\Bookcomment\Backend\Controllers\Book_commentController@ajax_comments']);
		Route::resource('/book_comment','Readingbar\Bookcomment\Backend\Controllers\Book_commentController');
	});
?> 


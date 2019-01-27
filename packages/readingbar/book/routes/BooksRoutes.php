<?php
	Route::group(['middleware' => 'pauth','prefix'=>'admin'], function () {
		Route::get('/books/export',['as'=>'admin.books.exportBooks','uses'=>'Readingbar\Book\Backend\Controllers\BooksController@exportBooks']);
		Route::get('/books/changeInBookList',['as'=>'admin.books.changeInBookList','uses'=>'Readingbar\Book\Backend\Controllers\BooksController@changeInBookList']);
		Route::resource('/books','Readingbar\Book\Backend\Controllers\BooksController');
		
		Route::get('/books/{id}/delete',['as'=>'admin.books.delete','uses'=>'Readingbar\Book\Backend\Controllers\BooksController@delete']);
		Route::get('/books/{id}/viewImages',['as'=>'admin.books.delete','uses'=>'Readingbar\Book\Backend\Controllers\BooksController@viewImages']);
		
	});
	
?> 


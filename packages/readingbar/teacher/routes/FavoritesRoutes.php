<?php
	Route::group(['middleware' => 'pauth','prefix'=>'admin'], function () {
		Route::resource('/favorites','Readingbar\Teacher\Backend\Controllers\FavoritesController');
	});
	
?> 


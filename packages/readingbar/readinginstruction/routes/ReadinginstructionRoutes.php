<?php
	Route::group(['middleware' => 'pauth','prefix'=>'admin'], function () {
		Route::resource('/readinginstruction','Readingbar\Readinginstruction\Backend\Controllers\ReadinginstructionController');
	});
	
?> 


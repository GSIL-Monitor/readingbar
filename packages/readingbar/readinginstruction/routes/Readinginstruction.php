<?php
	Route::group(['middleware' => 'pauth','prefix'=>'admin'], function () {
		Route::resource('/studentdistribution','Readingbar\Readinginstruction\Backend\Controllers\StudentdistributionController');
	});
	
?> 


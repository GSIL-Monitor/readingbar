<?php
	Route::group(['middleware' => 'pauth','prefix'=>'admin'], function () {
		Route::resource('/[model]','[vendor]\[ucfirst_name]\Backend\Controllers\[ucfirst_model]Controller');
	});
	
?> 


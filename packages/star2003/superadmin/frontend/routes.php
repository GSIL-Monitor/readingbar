<?php
	Route::group(['middleware' => 'web'], function () {
		Route::get('/view',function(Illuminate\Http\Request $request){
			$view=str_replace('.blade.php','',$request->input('direct'));
			$view=str_replace('/','.',$view);
			return view("superadmin/frontend::".$view);
		});
	});
?> 


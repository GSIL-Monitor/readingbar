<?php
Route::group(['middleware'=>'web'],function(){
	Route::get('/QrCode','Readingbar\Front\Controllers\Qrcode\QrCodeController@index');
});
<?php
	Route::group(['middleware' => 'web','prefix'=>'admin'], function () {
                Route::get('/reg','Superadmin\Backend\Controllers\PauthController@registerForm');
                Route::any('/register','Superadmin\Backend\Controllers\PauthController@create');
            
		Route::get('/login','Superadmin\Backend\Controllers\PauthController@loginForm');
		Route::post('/login','Superadmin\Backend\Controllers\PauthController@login');
		Route::get('/logout','Superadmin\Backend\Controllers\PauthController@logout');
		Route::get('/lang/{lang}','Superadmin\Backend\Controllers\CommonController@lang');
	});

	Route::group(['middleware' => 'pauth','prefix'=>'admin'], function () {
		Route::resource('/user','Superadmin\Backend\Controllers\UserController');
		Route::get('/user/{id}/delete',['as'=>'admin.user.delete','uses'=>'Superadmin\Backend\Controllers\UserController@delete']);
		Route::resource('/role','Superadmin\Backend\Controllers\RoleController');
		Route::resource('/access','Superadmin\Backend\Controllers\AccessController');
		Route::resource('/menu','Superadmin\Backend\Controllers\MenuController');
		Route::get('/',['as'=>'admin.common.welcome','uses'=>'Superadmin\Backend\Controllers\CommonController@welcome']);
		Route::get('/nopermissions',['as'=>'admin.common.nopermissions','uses'=>'Superadmin\Backend\Controllers\CommonController@no_permissions']);
		Route::resource('/profile','Superadmin\Backend\Controllers\ProfileController');
		Route::get('/pages/operations',['as'=>'admin.pages.operations','uses'=>'Superadmin\Backend\Controllers\PagesController@operations']);
		Route::post('/pages/operations',['as'=>'admin.pages.operations','uses'=>'Superadmin\Backend\Controllers\PagesController@operations']);
		Route::resource('/pages','Superadmin\Backend\Controllers\PagesController');
		
		Route::resource('/superadmin','Superadmin\Backend\Controllers\SuperadminController');
	});
	
?> 


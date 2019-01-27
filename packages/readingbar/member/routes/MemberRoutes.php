<?php
// // 	Route::group(['middleware' => 'member','prefix'=>'members'], function () {
// // 		Route::get('','Readingbar\Member\Frontend\Controllers\MemberController@index');
// // 		Route::get('edit','Readingbar\Member\Frontend\Controllers\MemberController@editView');
// // 		Route::get('edit/{edit_type}','Readingbar\Member\Frontend\Controllers\MemberController@editView');
// // 		Route::post('edit','Readingbar\Member\Frontend\Controllers\MemberController@editAction');
// // 		Route::post('login','Readingbar\Member\Frontend\Controllers\MemberController@loginAction');
		
// // 		Route::get('active','Readingbar\Member\Frontend\Controllers\MemberController@check_active_view');
// // 		Route::get('send_active','Readingbar\Member\Frontend\Controllers\MemberController@send_active');
// // 		Route::post('active','Readingbar\Member\Frontend\Controllers\MemberController@check_active_action');
// // 	});
// 	Route::group(['middleware' => 'pauth','prefix'=>'admin'], function () {
// 		Route::get('members/ajax_memberList',['as'=>'admin.members.ajax_memberList','uses'=>'Readingbar\Member\Backend\Controllers\MembersController@ajax_memberList']);
// 		Route::get('members/{id}/delete',['as'=>'admin.members.delete','uses'=>'Readingbar\Member\Backend\Controllers\MembersController@delete']);
// 		//Route::resource('members','Readingbar\Member\Backend\Controllers\MembersController');
// 	});
?> 


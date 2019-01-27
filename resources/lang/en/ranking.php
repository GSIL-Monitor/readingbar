<?php
    return [
        'menu_title' =>'3维排行管理',
        'head_title'=>'3维排行管理',
        'columns'=>[
        		'index'=>'序号',
        		'student'=>'学生',
        		'grade'=>'年级',
        		'dob'=>'生日',
        		'area'=>'地区',
        		'star_account'=>'star账号',
        		'books'=>'阅读书籍量',
        		'words'=>'阅读单词量',
        		'books_improved'=>'阅读书籍进步量',
        		'words_improved'=>'阅读单词进步量',
        		'arp'=>'AR Points',
        		'award_point'=>'积分授予情况',
        		'operation'=>'操作'
        ],
    	'tabs'=>[
    			'books'=>'阅读书籍量排行',
    			'words'=>'阅读单词量排行',
    			'books_improved'=>'阅读书籍进步量',
    			'words_improved'=>'阅读单词进步量',
 //   			'arp'=>'AR Points排行',
    	],
    	'btns'=>[
    			'btn1'=>'选定年月',
    			'btn2'=>'新增记录',
    			'delete'=>'删除记录',
    			'award'=>'授予积分',
    	],
    	'form'=>[
    		'star_account'=>"star账号筛选学生",	
    		'student'=>"选择学生",
    		'type'=>[
    			'books'=>'阅读书籍量',
        		'words'=>'阅读单词量',
    			'books_improved'=>'阅读书籍进步量',
    			'words_improved'=>'阅读单词进步量',
//        		'arp'=>'AR Points'
    		],
    		'award_point'=>[
    				'0'=>'已授予',
    				'1'=>'未授予'
    		],
    		'type_v'=>"值",
    		'date'=>"记录所属日期",    			
    	],
    	'messages'=>[
    			'student_id.required'=>'学生为必选项!',
    			'id.exists'=>'记录不存在！',
    			'award_point.exists'=>'积分已发放!',
    	],
    	'attributes'=>[
    			'student_id'=>'学生',
				'type'		=>'录入类型',
				'type_v'		=>'录入值',
				'date'		=>'日期',
    			'books'=>'阅读书籍量',
    			'words'=>'阅读单词量',
    			'books_improved'=>'阅读书籍进步量',
    			'words_improved'=>'阅读单词进步量',
    			'arp'=>'AR Points',
    	],
    	'confirm'=>[
    		'award_point'=>'请确认数据是否正确并授予积分？',
    		'delete'=>'数据删除将不可恢复，确认删除数据？',
    	]
	];
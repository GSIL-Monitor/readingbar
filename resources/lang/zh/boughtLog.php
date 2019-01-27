<?php

return [
    'menu_title' => '会员购买记录查询',
	'top_menu_title' => '会员购买记录查询',
    'head_title' => '会员购买记录查询',
    'columns' => [
    		'id' => '订单序号',
    		'order_id' => '订单号',
    		'product_name' => '产品名称',
    		'total' => '订单金额',
    		'refund' => '退款情况',
    		'refund_type'=>[
    				1=>'其他退款',
    				2=>'服务退款'
    		],
    		'nickname' => '家长昵称',
    		'parent' => '家长昵称',
    		'nick_name' => '学生昵称',
    		'student' => '学生昵称',
    		'star_account'=>'star账号',
    		'completed_at' => '购买日期',
    		'email' => '邮箱',
    		'cellphone' => '手机'
    ],
    'search_type'=>[
    		'search_type'=>'请选择检索方式',
    		'nickname' => '家长昵称',
    		'nick_name' => '学生昵称',
    		'email' => '邮箱',
    		'cellphone' => '手机',
    		'star_account'=>'star账号'
	],
    
    'list_title'=>'会员购买记录列表',
    'tip'=>'其他退款:退款但不停止服务; 服务退款:退款并停止服务',
];

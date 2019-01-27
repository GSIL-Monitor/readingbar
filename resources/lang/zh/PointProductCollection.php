<?php
    return [
        'menu_title' =>'积分商品收藏管理',
        'head_title'=>'积分商品收藏管理',
    	'view_list'=>'积分商品收藏列表',
    	'view_form'=>'积分商品收藏表单',
        'columns'=>[
        		'id'=>'序号',
        		'product_name'=>'商品名称',
        		'image'=>'图像',
        		'point'=>'积分',
        		'desc'=>'描述',
        		'quantity'=>'数量',
        		'catagory'=>'商品分类',
        		'status'=>'状态',
        		'type'		=>'商品类型',
        		'type_v'		=>'优惠券',
        		'created_at'=>'创建时间',
        		'updated_at'=>'更新时间',
        		'operation'=>'操作'
        ],
    	'btns'=>[
    			'edit'=>'编辑',
    			'save'=>'保存',
    			'cancel'=>'取消',
    	],
    	'form'=>[
    			'product_name'=>'商品名称',
    			'image'=>'图像',
    			'point'=>'积分',
    			'desc'=>'描述',
    			'quantity'=>'数量',
    			'catagory'=>'商品分类',
    			'type'		=>[
    					'0'=>'实物',
        				'1'=>'优惠券',
    			],
    		'status'=>[
    			'0'=>'停用',
        		'1'=>'启用',
    		]		
    	],
    	'messages'=>[
    			'id.required'=>'收藏ID为必填项！',
    			'id.exists'=>'收藏不存在！',
    			'product_id.required'=>'商品ID为必填项',
    			'product_id.exists'=>'商品不存在或者已下架',
    	],
    	'attributes'=>[
    			'id'=>'序号',
    			'prodcut_id'=>'商品',
        		'product_name'=>'商品名称',
        		'image'=>'图像',
        		'point'=>'积分',
        		'desc'=>'描述',
        		'quantity'=>'数量',
        		'catagory'=>'商品分类',
        		'status'=>'状态',
        		'created_at'=>'创建时间',
        		'updated'=>'更新时间'
    	],
    	'placeholder'=>[
    			'product_name'=>'商品名称',
        		'image'=>'图像',
        		'point'=>'积分',
        		'desc'=>'描述',
        		'quantity'=>'数量',
        		'catagory'=>'商品分类',
        		'status'=>'状态',
    	]
	];
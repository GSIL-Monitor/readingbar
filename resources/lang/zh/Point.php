<?php
    return [
    	'top_menu_title' =>'积分管理',
        'menu_title' =>'积分管理',
        'head_title'=>'积分管理',
    	'view_list'=>'积分列表',
    	'view_form'=>'积分表单',
        'columns'=>[
        		'id'=>'序号',
        		'name'=>'积分名称',
        		'point'=>'积分',
        		'get_rule'=>'获取规则',
        		'get_rule_products'=>'获取规则关联商品',
        		'get_rule_promotions_types'=>"获取规则关联推广员类型",
        		'status'=>'状态',
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
    		'id'=>'序号',
    		'name'=>'积分名称',
    		'point'=>'积分',
    		'get_rules'=>[
					'login_every_day'=>'会员每天登录时,名下孩子获得积分',
    				'in_ranking'		=>'孩子进入排行榜时获得积分',
    				'read_plan_goal'=>'孩子完成阅读目标获得积分',
    				'promote_new_member'=>'关联推广员推广一位新会员,名下孩子获得积分',
    				'buy_product'			=>'孩子购买关联商品获得积分',
    				'create_first_child_tm'=>'会员创建第一个孩子的时候,名下孩子获得积分',
    				'create_first_child_tp'=>'会员创建第一个孩子的时候,关联推广员名下孩子获得积分',
    				'give_by_admin'		=>'管理员授予积分'
    		],
    		'get_rule_products'=>'获取规则关联商品',
    		'status'=>[
    				'0'=>'停用',
    				'1'=>'启用',
    		]
    	],
    	'list'=>[
    		'id'=>'序号',
    		'name'=>'积分名称',
    		'point'=>'积分',
    		'get_rules'=>[
					'login_every_day'=>'会员每天登录时,名下孩子获得积分',
    				'in_ranking'		=>'孩子进入排行榜时获得积分',
    				'read_plan_goal'=>'孩子完成阅读目标获得积分',
    				'promote_new_member'=>'关联推广员推广一位新会员,名下孩子获得积分',
    				'buy_product'			=>'孩子购买关联商品获得积分',
    				'create_first_child_tm'=>'会员创建第一个孩子的时候,名下孩子获得积分',
    				'create_first_child_tp'=>'会员创建第一个孩子的时候,关联推广员名下孩子获得积分',
    				'give_by_admin'		=>'管理员授予积分'
    		],
    		'get_rule_products'=>'获取规则关联商品',
    		'status'=>[
    				'0'=>'停用',
    				'1'=>'启用',
    		]
    	],
    	'messages'=>[
    			'id.required'=>'不存在！'
    	],
    	'attributes'=>[
        		'id'=>'序号',
        		'name'=>'积分名称',
        		'point'=>'积分',
        		'get_rule'=>'获取规则',
        		'get_rule_products'=>'获取规则关联商品',
    			'get_rule_promotions_types'=>"获取规则关联推广员类型",
        		'status'=>'状态',
        		'created_at'=>'创建时间',
        		'updated'=>'更新时间'
    	],
    	'placeholder'=>[
    			'id'=>'序号',
        		'name'=>'积分名称',
        		'point'=>'积分',
        		'get_rule'=>'获取规则',
        		'get_rule_products'=>'获取规则关联商品',
    			'get_rule_promotions_types'=>"获取规则关联推广员类型",
        		'status'=>'状态'
    	]
	];
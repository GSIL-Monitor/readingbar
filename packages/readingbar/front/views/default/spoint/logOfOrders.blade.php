<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')
<link rel="stylesheet" type="text/css" href="{{url('home/pc/css/spoint.css')}}">

<div class="content" id="main">
	<div class="container">
		<div class="spoint-childpage">
			<span>您的位置</span>
			<a href="{{ url('member/spoint/product') }}">商城</a>
			<a href="#" class="link">我的订单</a>
		</div>
	</div>
	<!--/row-->
    <div class="orderlog">
		<div class="orderlog-lsit">
			<ul id="myTab" class="nav orderlog-tabs">
			    <li class="active"> <a href="#log1" data-toggle="tab" v-on:click="getOrdersByStatus('')"> 所有订单</a></li>
			    <li><a href="#log2" data-toggle="tab" v-on:click="getOrdersByStatus(2)">待收货</a></li>
			    <li class="bg0"><a href="#log3" data-toggle="tab" v-on:click="getOrdersByStatus(1)">待发货</a></li>
			    
			</ul>
			<div id="myTabContent" class="tab-content orderlog-content">
				<div v-if="orders==null" class="text-center">
						<ul class='loading-local1'>
									<li class="node1"></li>
									<li class="node2"></li>
									<li class="node3"></li>
						</ul>
						数据加载中
				</div>
			    <div class="tab-pane fade in active" id="log1" v-if="orders!=null">
			    	<div class="loglsit-tittle">
			    		<span class="statusmg47">单价</span>
			       		<span class="statusmg83">数量</span>
			       		<span class="statusmg126">状态</span>
			    	</div>
			        <ul class="loglsit">
			       		<li v-for="o in orders.data">
			       			<div class="top">
			       				<span>[[ o.created_at ]]</span>
			       				<span>订单号：[[ o.order_id ]]</span>
			       				<a href="javascript:void(0)" v-on:click="deleteOrder(o)"><img src="{{url('home/pc/images/spoint/shoppingcart_6.png')}}" alt=""/></a>
			       			</div>
			       			<div class="center" v-for="p in o.products">
			       				<div class="loglsit-cet01">
			       					<div class="img"><img :src="p.image"></div>
			       					<div class="jj">
			       						<h4>[[ p.product_name ]]</h4>
			       						<span>[[ p.desc ]]</span>
			       					</div>
			       				</div>
			       				<!--/loglsit-cet01-->
			       				<div class="loglsit-cet02">
			       					<div class="Price">[[ p.point ]]</div>
			       				</div>
			       				<!--/loglsit-cet02-->
			       				<div class="loglsit-cet03">
			       					<span>[[ p.quantity ]]</span>
			       				</div>
			       				<!--/loglsit-cet03-->
			       				<div class="loglsit-cet04" v-if="$index==0">
			       					<span class="status-01" v-if="o.status==3">[[ o.status_text ]]</span>
			       					<span class="status-02" v-if="o.status==2">[[ o.status_text ]]</span>
			       					<span class="status-03" v-if="o.status==1">[[ o.status_text ]]</span>
			       					<a :href="o.detail_url" class="">订单详情</a>
			       				</div>
			       				<!--/loglsit-cet04-->
			       			</div>
			       			<!--/center-->
			       		</li>
			       </ul>
			       <!--/-->
			       	<ul class="spoint-page" v-if="orders.last_page>1">
				    	<li v-if="orders.current_page>1" v-on:click="doChangePage(1)"><a>«</a></li>
			    		<template v-for="p in orders.last_page" v-if="Math.abs(orders.current_page-(p+1))<=3">
			    			<li v-if="orders.current_page==p+1" class="active" v-on:click="doChangePage(p+1)"><span>[[ p+1 ]]</span></li>
			    			<li v-else v-on:click="doChangePage(p+1)"><a>[[ p+1 ]]</a></li>
			    		</template>
				     	<li v-if="products.current_page < products.last_page" v-on:click="doChangePage(products.last_page)"><a>»</a></li>
			     	</ul>
			     	 <!--/-->
			    </div>
			    <!--/orderlog-lsit-->
			    <div class="tab-pane fade" id="log2" v-if="orders!=null">
			        <div class="loglsit-tittle">
			    		<span class="statusmg47">单价</span>
			       		<span class="statusmg83">数量</span>
			       		<span class="statusmg126">状态</span>
			    	</div>
			    	 <ul class="loglsit">
			       	<li v-for="o in orders.data">
			       			<div class="top">
			       				<span>[[ o.created_at ]]</span>
			       				<span>订单号：[[ o.order_id ]]</span>
			       				<a href="javascript:void(0)" v-on:click="deleteOrder(o)"><img src="{{url('home/pc/images/spoint/shoppingcart_6.png')}}" alt=""/></a>
			       			</div>
			       			<div class="center" v-for="p in o.products">
			       				<div class="loglsit-cet01">
			       					<div class="img"><img :src="p.image"></div>
			       					<div class="jj">
			       						<h4>[[ p.product_name ]]</h4>
			       						<span>[[ p.desc ]]</span>
			       					</div>
			       				</div>
			       				<!--/loglsit-cet01-->
			       				<div class="loglsit-cet02">
			       					<div class="Price">[[ p.point ]]</div>
			       				</div>
			       				<!--/loglsit-cet02-->
			       				<div class="loglsit-cet03">
			       					<span>[[ p.quantity ]]</span>
			       				</div>
			       				<!--/loglsit-cet03-->
			       				<div class="loglsit-cet04" v-if="$index==0">
			       					<span class="status-01" v-if="o.status==3">[[ o.status_text ]]</span>
			       					<span class="status-02" v-if="o.status==2">[[ o.status_text ]]</span>
			       					<span class="status-03" v-if="o.status==1">[[ o.status_text ]]</span>
			       					<a :href="o.detail_url" class="">订单详情</a>
			       				</div>
			       				<!--/loglsit-cet04-->
			       			</div>
			       			<!--/center-->
			       		</li>
			       		
			       </ul>
			       <!--/-->
			       	<ul class="spoint-page" v-if="products.last_page">
				    	<li v-if="products.current_page>1" v-on:click="doChangePage(1)"><a>«</a></li>
			    		<template v-for="p in products.last_page" v-if="Math.abs(products.current_page-(p+1))<=3">
			    			<li v-if="products.current_page==p+1" class="active" v-on:click="doChangePage(p+1)"><span>[[ p+1 ]]</span></li>
			    			<li v-else v-on:click="doChangePage(p+1)"><a>[[ p+1 ]]</a></li>
			    		</template>
				     	<li v-if="products.current_page < products.last_page" v-on:click="doChangePage(products.last_page)"><a>»</a></li>
			     	</ul>
			     	 <!--/-->
			    </div>
			    <!--/orderlog-lsit-->
			    <div class="tab-pane fade" id="log3" v-if="orders!=null">
			        <div class="loglsit-tittle">
			    		<span class="statusmg47">单价</span>
			       		<span class="statusmg83">数量</span>
			       		<span class="statusmg126">状态</span>
			    	</div>
			    	 <ul class="loglsit">
			       		<li v-for="o in orders.data">
			       			<div class="top">
			       				<span>[[ o.created_at ]]</span>
			       				<span>订单号：[[ o.order_id ]]</span>
			       				<a href="javascript:void(0)" v-on:click="deleteOrder(o)"><img src="{{url('home/pc/images/spoint/shoppingcart_6.png')}}" alt="" /></a>
			       			</div>
			       			<div class="center" v-for="p in o.products">
			       				<div class="loglsit-cet01">
			       					<div class="img"><img :src="p.image"></div>
			       					<div class="jj">
			       						<h4>[[ p.product_name ]]</h4>
			       						<span>[[ p.desc ]]</span>
			       					</div>
			       				</div>
			       				<!--/loglsit-cet01-->
			       				<div class="loglsit-cet02">
			       					<div class="Price">[[ p.point ]]</div>
			       				</div>
			       				<!--/loglsit-cet02-->
			       				<div class="loglsit-cet03">
			       					<span>[[ p.quantity ]]</span>
			       				</div>
			       				<!--/loglsit-cet03-->
			       				<div class="loglsit-cet04" v-if="$index==0">
			       					<span class="status-01" v-if="o.status==3">[[ o.status_text ]]</span>
			       					<span class="status-02" v-if="o.status==2">[[ o.status_text ]]</span>
			       					<span class="status-03" v-if="o.status==1">[[ o.status_text ]]</span>
			       					<a :href="o.detail_url" class="">订单详情</a>
			       				</div>
			       				<!--/loglsit-cet04-->
			       			</div>
			       			<!--/center-->
			       		</li>
			       </ul>
			       <!--/-->
			       	<ul class="spoint-page" v-if="products.last_page">
				    	<li v-if="products.current_page>1" v-on:click="doChangePage(1)"><a>«</a></li>
			    		<template v-for="p in products.last_page" v-if="Math.abs(products.current_page-(p+1))<=3">
			    			<li v-if="products.current_page==p+1" class="active" v-on:click="doChangePage(p+1)"><span>[[ p+1 ]]</span></li>
			    			<li v-else v-on:click="doChangePage(p+1)"><a>[[ p+1 ]]</a></li>
			    		</template>
				     	<li v-if="products.current_page < products.last_page" v-on:click="doChangePage(products.last_page)"><a>»</a></li>
			     	</ul>
			     	 <!--/-->
			    </div>
			    <!--/orderlog-lsit-->
			</div>
		</div> 		 
     	<!--/orderlog-lsit-->
	 
    </div>
    <!--/orderlog-->
</div>
<!--/content-->
<script type="text/javascript">
	new Vue({
		el:"#main",
		data:{
			orders:null,
			limit:5,
			page:1,
			order:'id',
			sort:'desc',
			status:''
		},
		created:function(){
			this.getOrders();
		},
		methods:{
			//获取订单数据
			getOrders:function(){
				var _this=this;
				_this.orders=null;
				$.ajax({
					url:"{{ url('member/spoint/order/getList') }}",
					data:{
						page:_this.page,
						limit:_this.limit,
						order:_this.order,
						sort:_this.sort,
						status:_this.status
					},
					dataType:"json",
					success:function(json){
						_this.orders=json;
					}
				});
			},
			//根据状态获取订单
			getOrdersByStatus:function(status){
				this.status=status;
				this.page=1;
				this.getOrders();
			},
			//翻页
			doChangePage:function(page){
				this.page=page;
				this.getOrders();
			},
			//删除订单
			deleteOrder:function(o){
				var _this=this;
				appConfirm({
					title:"删除确认",
					msg:"请确认是否要删除该订单？",
					ok:{
						callback:function(){
							$.ajax({
								url:"{{ url('member/spoint/order/delete') }}",
								data:{
									oid:o.id,
								},
								dataType:"json",
								success:function(json){
									if(json.status){
										_this.orders.data.$remove(o);
									}else{
										alert(json.error);
									}
								}
							});
						}
					}
				});
				
			}
		}
	});
</script>
@endsection
<!-- //继承整体布局 -->

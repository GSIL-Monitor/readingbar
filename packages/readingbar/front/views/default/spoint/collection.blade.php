<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')
<link rel="stylesheet" type="text/css" href="{{url('home/pc/css/spoint.css')}}">
<div class="content" id="main">
	<div class="container">
		<div class="tjj-spoint-childpage">
			<span>您的位置</span>
			<a href="{{ url('member/spoint/product') }}">商城</a>
			<a href="#" class="active">我的收藏</a>
		</div>
	</div>
	<div class="lycontent">
		<div class="lycontent-titile">我的收藏</div>
		<div class="spoint-collection">
			<ul class="spointconter">
				<li v-for="p in products.data">
						<a href="javascript:void(0)" class="delete_collection" v-on:click="remove(p)"  ><img alt=""  width="20px" src="{{ asset('files/icons/btn-delete.png') }}" ></a>
     						
     					<div class="mon1">
     						<div class="img fl"><img alt=""  :src="p.image" width="20px"></div>
	     					<div class="textlsit fl">
	     						<div class="number">
	     							<span class="fl">NO：<b>[[ p.serial ]]</b></span>
		     						<div class=" fr">
		     							<!-- 已加入购物车 -->
		     							<a href="javasctript:void(0)"  v-if="p.shoppingcart_status"><img src="{{url('files/icons/btn-unable-shoppingcart.png')}}" alt=""/></a>
		     							<!-- 未加入购物车 -->
		     							<a v-on:click="add(p)" href="javasctript:void(0)" v-else><img src="{{url('files/icons/btn-able-shoppingcart.png')}}" alt=""/></a>
		     						</div>
	     						</div>
	     						<h3>[[ p.product_name ]]</h3>
		     					<p>[[ p.desc ]]</p>
	     					</div>
	     					<!--/textlsit-->
	     					
     					</div>
     					<!--/mon1-->
     					<div class="mon2">
     						<div class="Price fl">[[ p.point ]]</div>
     						<div class="buy fr">
     							<div class="number">
     								<span class="stock-quantity">库存：[[ p.stock_quantity ]]</span>
     								<button class="minus"><img src="{{url('home/pc/images/spoint/shoppingcart_7.png')}}" alt="" v-on:click="changeQuantity(p,-1)"/></button>
     								<input v-model="p.quantity">
     								<button class="add"><img src="{{url('home/pc/images/spoint/shoppingcart_8.png')}}" alt=""  v-on:click="changeQuantity(p,1)"/></button>
     							</div>
     							<a  v-on:click="buy(p)" class="dhlink"  href="javascript:void(0)">立即兑换</a>
     						</div>
     					</div>
     					<!--/mon2-->
     				</li>
			</ul>
			<ul class="spoint-page" v-if="products.last_page>1">
			    	<li v-if="products.current_page>1" v-on:click="doChangePage(1)"><a>«</a></li>
		    		<template v-for="p in products.last_page" v-if="Math.abs(products.current_page-(p+1))<=3">
		    			<li v-if="products.current_page==p+1" class="active" v-on:click="doChangePage(p+1)"><span>[[ p+1 ]]</span></li>
		    			<li v-else v-on:click="doChangePage(p+1)"><a>[[ p+1 ]]</a></li>
		    		</template>
			     	<li v-if="products.current_page < products.last_page" v-on:click="doChangePage(products.last_page)"><a>»</a></li>
		     	</ul>
		</div>
		<!--/spoint-collection-->
	</div>	
</div>
<script type="text/javascript">
 	new Vue({
		el:"#main",
		data:{
			products:null,
			page:1,
			limit:5,
		},
		created:function(){
			this.getCollection();
		},
		methods:{
			//获取收藏的产品
			getCollection:function(){
				var _this=this;
				$.ajax({
					url:"{{ url('member/spoint/collection/getList') }}",
					data:{
							page:_this.page,
							limit:_this.limit,
					},
					dataType:"json",
					success:function(json){
						_this.products=json;
					}
				});
			},
			//立即兑换
			buy:function(p){
				window.location.href="{{ url('member/spoint/order/confirmProduct') }}"+"?quantity="+p.quantity+"&product_id="+p.product_id;
			},
			//改变产品数量
			changeQuantity:function(p,num){
				p.quantity=p.quantity+num;
				if(p.stock_quantity>=p.quantity){
					if(p.quantity<0){
						p.quantity=0;
					}
				}else{
					p.quantity=p.stock_quantity;
				}
			},
			//加入购物车
			add:function(p){
				var _this=this;
				$.ajax({
					url:"{{ url('member/spoint/cart/add') }}",
					data:{
						'quantity':p.quantity,
						'product_id':p.product_id,
					},
					dataType:"json",
					success:function(json){
						if(json.status){
							p.shoppingcart_status=true;
						}else{
							alert(json.error);
						}
					}
				});
			},
			remove:function(p){
				var _this=this;
				if(p.remove){
					return;
				}else{
					p.remove=true;
					$.ajax({
						url:"{{ url('member/spoint/collection/remove') }}",
						data:{
							'id':p.id,
						},
						dataType:"json",
						success:function(json){
							if(json.status){
								_this.products.data.$remove(p);
							}else{
								p.remove=false;
								alert(json.error);
							}
						}
					});
				}
			},
			//翻页
			doChangePage:function(page){
				this.page=page;
				this.getCollection();
			},
		}
	 });
</script>
@endsection
<!-- //继承整体布局 -->

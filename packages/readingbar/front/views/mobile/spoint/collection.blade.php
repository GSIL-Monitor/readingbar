<!-- 继承整体布局 -->
@extends('front::mobile.common.mainSpoint')

@section('content')
<link rel="stylesheet" href="{{url('home/wap/css/spoint.css')}}">

<section id="main">
	<div class="collection">
		<ul  class="am-g am-g-fixed collectionlist">
			<li v-for="p in products.data">
				<div class="am-u-sm-12" style="z-index:50">
					 <a href="javascript:void(0)" class="delete_collection" v-on:click="remove(p)"  ><img alt=""  width="20px" src="{{ asset('files/icons/btn-delete.png') }}" ></a>
				</div>
			   <div class="am-u-sm-1"> <input type="checkbox" value="option2"></div>
				<div class="am-u-sm-11">
					
					<div class="am-u-sm-4">
			  			<img alt=""  :src="p.image" >
				  	</div>
				  	<div class="am-u-sm-8">
				  		<span>NO：<b>[[ p.serial ]]</b></span>
				  		<span>[[ p.product_name ]]</span>
				  		<span>[[ p.desc ]]</span>
				  		<div>
				  			<em><img src="{{url('home/wap/images/sp/sp3_2.png')}}" alt=""/>[[ p.point ]]</em>
				  			<!-- 已加入购物车 -->
			     			<a href="javasctript:void(0)"  v-if="p.shoppingcart_status"><img src="{{url('files/icons/btn-unable-shoppingcart.png')}}" alt=""/></a>
			     			<!-- 未加入购物车 -->
			     			<a v-on:click="add(p)" href="javasctript:void(0)" v-else><img src="{{url('files/icons/btn-able-shoppingcart.png')}}" alt=""/></a>
				  		</div>
				  	</div>
				</div>
			</li>
		</ul>
		<!--更多在底部-->
     	<div calss="am-u-md-12" style="text-align: center ">
					<template v-if="loadStatus">
							<ul class='loading-local1'>
								<li class="node1"></li>
								<li class="node2"></li>
								<li class="node3"></li>
							</ul>
							<span class="color333333">数据加载中</span>
					</template>
					<template v-else>
							<span class="color333333" v-if="page>=products.last_page">已经加载到底了</span>
							<span class="color333333" v-else>下拉加载数据</span>
					</template>
		</div>
		<br>
			    <!--更多在底部-->
	</div>
</section>


<!-- /扩展内容 -->
<script type="text/javascript">
 	new Vue({
		el:"#main",
		data:{
			products:null,
			page:1,
			limit:5,
			loadStatus:false
		},
		created:function(){
			this.getCollection();
			this.scrollLoad();
		},
		methods:{
			//获取收藏的产品
			getCollection:function(){
				var _this=this;
				if(_this.loadStatus){
					return;
				}else{
					_this.loadStatus=true;
				}
				$.ajax({
					url:"{{ url('member/spoint/collection/getList') }}",
					data:{
							page:_this.page,
							limit:_this.limit,
					},
					dataType:"json",
					success:function(json){
						if(_this.products){
							for(i in json.data){
								_this.products.data.push(json.data[i]);
							}
						}else{
							_this.products=json;
						}
						_this.loadStatus=false;
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
			/*滚动至底部加载数据*/
			scrollLoad:function(){
				var _this=this;
				$(document).scroll(function(){  
					if((document.body.scrollHeight-(document.body.clientHeight+document.body.scrollTop))<10){
						if(!_this.loadStatus && _this.products.last_page>_this.page){
							_this.page++;
							_this.getCollection();
						}
					}
				});  
			}
		}
	 });
</script>
@endsection
<!-- //继承整体布局 -->

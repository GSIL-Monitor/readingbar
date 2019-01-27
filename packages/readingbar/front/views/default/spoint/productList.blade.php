<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')
<link rel="stylesheet" type="text/css" href="{{url('home/pc/css/spoint.css')}}">

<div class="content" id="main">
	<div class="container">
		<div class="spoint-childpage">
			<span>您的位置</span>
			<a href="{{ url('member/spoint/product') }}" class="link">商城</a>
		</div>
	</div>
	<!--/row-->
    <div class="container spoint-home">
    	<style>
    		.spoint-homesidebar1 ul li{
    			text-align:left;
    			padding-left:80px;
    			background-position: center left 55px;
    			background-repeat:no-repeat;
    		}
    	</style>
     	<div class="spoint-homesidebar1">
     		<h4>礼 物 分 类</h4>
     		<ul>
     			<!-- 循环体 -->
     			<template  v-for="c in catagory" >
	      			<li :style="c.icon_pc_style" class="active" v-on:click="doSearchByCatagory(c.id)"  v-if="search.catagory_id==c.id">[[ c.catagory_name ]]</li>
	      			<li  :style="c.icon_pc_style" v-on:click="doSearchByCatagory(c.id)"  v-else>[[ c.catagory_name ]]</li>
      			</template>
      			<!-- 循环体 -->
     		</ul>
     	</div>
     	<!--/homesidebar1-->
     	<div class="spoint-homecenter">
     		<div class="titile">
     			<ul>
      				<li  v-on:click="doChangeOrder('id','desc')" class="Newest">最新</li>
      				<li  v-on:click="doChangeOrder('point','desc')" class="ico1">价格</li>
      				<li  v-on:click="doChangeOrder('point','asc')" class="ico2">价格</li>
      			</ul>
     		</div>
     		<div>
     			<ul class="spointconter" v-of="products!=null">
     				<li v-for="p in products.data">
     					<div class="mon1">
     						<div class="img fl"><img alt=""  :src="p.image" width="20px"></div>
	     					<div class="textlsit fl">
	     						<div class="number">
	     							<span class="fl">NO：<b>[[ p.serial  ]]</b></span>
		     						<div class=" fr">
		     							<!-- 已收藏 -->
		     							<a href="javascript:void(0)"  v-if="p.collection_status"><img src="{{url('files/icons/btn-unable-collect.png')}}" alt=""/></a>
		     							<!-- 未收藏 -->
		     							<a v-on:click="addCollection(p)" href="javascript:void(0)" v-else><img src="{{url('files/icons/btn-able-collect.png')}}" alt=""/></a>
		     							
		     							<!-- 已加入购物车 -->
		     							<a href="javascript:void(0)"  v-if="p.shoppingcart_status"><img src="{{url('files/icons/btn-unable-shoppingcart.png')}}" alt=""/></a>
		     							<!-- 未加入购物车 -->
		     							<a v-on:click="add(p)" href="javascript:void(0)" v-else><img src="{{url('files/icons/btn-able-shoppingcart.png')}}" alt=""/></a>
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
     							<a  v-on:click="buy(p)" class="dhlink" href="javascript:void(0)">立即兑换</a>
     						</div>
     					</div>
     					<!--/mon2-->
     				</li>
     			</ul>
     			<div v-if="products==null" class="text-center">
						<ul class='loading-local1'>
									<li class="node1"></li>
									<li class="node2"></li>
									<li class="node3"></li>
						</ul>
						数据加载中
				</div>
     			<ul class="spoint-page" v-if="products.last_page>1">
			    	<li v-if="products.current_page>1" v-on:click="doChangePage(1)"><a>«</a></li>
		    		<template v-for="p in products.last_page" v-if="Math.abs(products.current_page-(p+1))<=3">
		    			<li v-if="products.current_page==p+1" class="active" v-on:click="doChangePage(p+1)"><span>[[ p+1 ]]</span></li>
		    			<li v-else v-on:click="doChangePage(p+1)"><a>[[ p+1 ]]</a></li>
		    		</template>
			     	<li v-if="products.current_page < products.last_page" v-on:click="doChangePage(products.last_page)"><a>»</a></li>
		     	</ul>
     		</div>
     	</div>
     	<!--/homecenter--> 
     	@if(auth('member')->check())
		<div class="spoint-homesidebar2">
			<div class="homesidebar2-01">
				<h4>我的账户</h4>
				<div class="user-dl">
					<img src="{{ auth('member')->avatar() }}" alt=""/>
				</div>
				<ul class="tjj-spoint-right-menu">
					<li><a href="{{ url('member/spoint/collection')}}">我的收藏</a></li>
					<li><a href="{{ url('member/spoint/order/log')}}">我的订单</a></li>
					<li><a href="{{ url('member/spoint/cart')}}"><img alt="" src="{{ url('files/icons/shoppingCart.png') }}"> 购物车</a></li>
				</ul>
			</div>
			<a href="javascript:void(0)"  onclick="$('#spointRuleModal').modal('show');" class="homesidebar2-link"><img src="{{url('home/pc/images/spoint/rssc_40.png')}}" alt=""/></a>
		</div>
		@else
		<div class="spoint-homesidebar2">
			<div class="homesidebar2-01">
				<h4>我的账户</h4>
				<div class="user-dl">
					<img src="{{url('home/pc/images/spoint/rssc_11.png')}}" alt=""/>
					<b>尚未登录账户</b>
					<b>登录可查看账户信息</b>
					<button onclick="window.location.href='{{ url('login')}}'">登录</button>
					<a href="{{ url('register')}}">尚未注册>></a>
				</div>
			</div>
			<a href="javascript:void(0)"  onclick="$('#spointRuleModal').modal('show');" class="homesidebar2-link"><img src="{{url('home/pc/images/spoint/rssc_40.png')}}" alt=""/></a>
		</div>
		@endif
		<!--/homesidebar2--> 
    </div>
</div>
<!--/content-->
   <!-- 获取规则弹出 -->
   	<div class="modal fade" id="spointRuleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header text-center">
        	<h3 class="col-md-12" style="color:#4bd2bf">如何获取？</h3>
        </div>
        <div class="modal-body">
            <div class="row">
            	<div class="col-md-12" style="color: #333333;font-size: 14px;">
            		<p>蕊丁币的获得方式：</p>
						<p>*会员每天登陆官网，就可获得10个蕊丁币。（和登录次数无关，对所有注册会员有效）</p>
						<p>*凡进入每月更新的小达人排行榜，都可以获得100个蕊丁币。</p>
						<p>*定制会员，每完成阅读计划中的任务目标，就可以获得100个蕊丁币。</p>
						<p>*所有蕊丁使者，成功推广一名注册会员，即可获得20蕊丁币。</p>
						<p>*购买蕊丁吧产品，即可获得相同数量的蕊丁币。</p>
						<p>*参与蕊丁吧“Reading Camp”，完成任务可获得奖励蕊丁币。</p>	
            		</p>
            	</div>
            </div>
        </div>
        <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
		</div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
   <!-- 获取规则弹出 -->
<script type="text/javascript">
	new Vue({
		el:"#main",
		data:{
			catagory:{!! $catagory !!},
			products:null,
			search:{
				page:1,
				limit:5,
				order:'id',
				sort:'desc',
				catagory_id:''
			}
		},
		created:function(){
			this.getPorudcts();
		},
		methods:{
			//获取积分商品
			getPorudcts:function(){
				var _this=this;
				_this.products=null;
				$.ajax({
					url:"{{ url('member/spoint/product/getProducts') }}",
					data:_this.search,
					dataType:"json",
					success:function(json){
						_this.products=json;
					}
				});
			},
			//分类查询
			doSearchByCatagory:function(id){
				this.search.page=1;
				this.search.catagory_id=id;
				this.getPorudcts();
			},
			//排序
			doChangeOrder:function(order,sort){
				this.search.page=1;
				this.search.order=order;
				this.search.sort=sort;
				this.getPorudcts();
			},
			//翻页
			doChangePage:function(page){
				this.search.page=page;
				this.getPorudcts();
			},
			//立即兑换
			buy:function(p){
				window.location.href="{{ url('member/spoint/order/confirmProduct') }}"+"?quantity="+p.quantity+"&product_id="+p.id;
			},
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
						'product_id':p.id,
					},
					dataType:"json",
					success:function(json){
						if(json.status){
							p.shoppingcart_status=true;
						}else{
							alert(json.error);
							_this.redirectLogin(json.error);
						}
					}
				});
			},
			//加入收藏
			addCollection:function(p){
				var _this=this;
				$.ajax({
					url:"{{ url('member/spoint/collection/add') }}",
					data:{
						'product_id':p.id,
					},
					dataType:"json",
					success:function(json){
						if(json.status){
							p.collection_status=true;
						}else{
							alert(json.error);
							_this.redirectLogin(json.error);
						}
					}
				});
			 },
			 //重定向只登陆界面
			 redirectLogin:function(msg){
				if(msg=='您尚未登录'){
					window.location.href="{{ url('login?intended='.Request::getRequestUri()) }}";
				}
			 }
		}
	});
</script>
@endsection
<!-- //继承整体布局 -->

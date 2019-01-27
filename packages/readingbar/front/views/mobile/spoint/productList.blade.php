<!-- 继承整体布局 -->
@extends('front::mobile.common.mainSpoint')

@section('content')
<link rel="stylesheet" href="{{url('home/wap/css/spoint.css')}}">
<section id="main">
	<div class="am-g spoprojb">
		<ul class="spopro-classify ">
			<!-- 循环体 -->
			<template v-for="c in catagory">
				<li class="active" v-if="c.id==search.catagory_id" >
	     			<img  :src="c.icon_wap">
	     			<span>[[ c.catagory_name ]]</span>
	     		</li>
	     		<li v-else>
	     			<img  :src="c.icon_wap" v-on:click="doSearchByCatagory(c.id)">
	     			<span>[[ c.catagory_name ]]</span>
	     		</li>
			</template>
			
	      	<!-- 循环体 -->
      	</ul>
	</div>
	<!--/am-g spoprojb-->
	<div class="am-g">
		<div class="spointlist">
			<ul class="am-g titile">
				<li  v-on:click="doChangeOrder('id','desc')"  class="Newest am-u-sm-4"  v-if="search.order=='id' && search.sort=='desc' ">最新</li>
				<li  v-on:click="doChangeOrder('id','desc')"  class="am-u-sm-4"  v-else>最新</li>
      			<li  v-on:click="doChangeOrder('point','desc')"  class="Newest am-u-sm-4"  v-if="search.order=='point' && search.sort=='desc' ">价格<img src="{{url('home/wap/images/sp/ico12.jpg')}}"></li>
      			<li  v-on:click="doChangeOrder('point','desc')"  class="am-u-sm-4"  v-else>价格<img src="{{url('home/wap/images/sp/ico12.jpg')}}"></li>
      			<li  v-on:click="doChangeOrder('point','asc')"  class="Newest am-u-sm-4"  v-if="search.order=='point' && search.sort=='asc' ">价格<img src="{{url('home/wap/images/sp/ico13.jpg')}}"></li>
      			<li  v-on:click="doChangeOrder('point','asc')"  class="am-u-sm-4"  v-else>价格<img src="{{url('home/wap/images/sp/ico13.jpg')}}"></li>
      		</ul>
			<div>
				<ul class="spointconter am-g">
     				<li v-for="p in products.data">
     					<div class="am-u-sm-5 spointlist-pic">
     						<a :href="p.detail"><img alt=""  :src="p.image" width="20px"></a>
						</div>	
     					<!--/am-u-sm-6-->
     					<div class="am-u-sm-7 spointlist-nr">
     						<div class="spointlist-nr-01">
     							<span>NO：<b>[[ p.serial  ]]</b></span>	
     							<a :href="p.detail"><h4>[[ p.product_name ]]</h4></a>
     							<p>[[ p.desc ]]  </p>
     						</div>
     						<div class="spointlist-nr-02">
     							<span class="fl"><img src="{{url('home/wap/images/sp/sp3_2.png')}}" alt=""/>[[ p.point ]]</span>
     							<span class="fr">
     									<!-- 已收藏 -->
		     							<a href="javascript:void(0)"  v-if="p.collection_status"><img src="{{url('files/icons/btn-unable-collect.png')}}" alt=""/></a>
		     							<!-- 未收藏 -->
		     							<a v-on:click="addCollection(p)" href="javascript:void(0)" v-else><img src="{{url('files/icons/btn-able-collect.png')}}" alt=""/></a>
     									
     									<!-- 已加入购物车 -->
		     							<a href="javascript:void(0)"  v-if="p.shoppingcart_status"><img src="{{url('files/icons/btn-unable-shoppingcart.png')}}" alt=""/></a>
		     							<!-- 未加入购物车 -->
		     							<a v-on:click="add(p)" href="javascript:void(0)" v-else><img src="{{url('files/icons/btn-able-shoppingcart.png')}}" alt=""/></a>
     							</span>
     						</div>
						</div>	
     					<!--/am-u-sm-7-->
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
							<span class="color333333" v-if="search.page>products.last_page">已经加载到底了</span>
							<span class="color333333" v-else>下拉加载数据</span>
					</template>
				</div>
			    <!--更多在底部-->
			</div>
		</div>
		<!--/-->
	</div>
	<!--/am-g-->
</section>

<!-- /扩展内容 -->
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
			},
			loadStatus:false
		},
		created:function(){
			this.getPorudcts();
			this.scrollLoad();
		},
		methods:{
			//获取积分商品
			getPorudcts:function(){
				var _this=this;
				//判断是否已经在获取数据了
				if(_this.loadStatus){
					return;
				}else{
					_this.loadStatus=true;
				}
				//判断数据是否已经到底了
				if(_this.products && _this.products.last_page==_this.products.current_page){
					_this.loadStatus=false;
					return;
				}
				$.ajax({
					url:"{{ url('member/spoint/product/getProducts') }}",
					data:_this.search,
					dataType:"json",
					success:function(json){
						//_this.products=json;
						if(_this.products){
							for(i in json.data){
								_this.products.last_page=json.last_page;
								_this.products.current_page=json.current_page;
								_this.products.data.push(json.data[i]);
							}
						}else{
							_this.products=json;
						}
						_this.loadStatus=false;
					}
				});
			},
			//分类查询
			doSearchByCatagory:function(id){
				this.products=null;
				this.search.page=1;
				this.search.catagory_id=id;
				this.getPorudcts();
			},
			//排序
			doChangeOrder:function(order,sort){
				this.products=null;
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
			/*滚动至底部加载数据*/
			scrollLoad:function(){
				var _this=this;
				$(document).scroll(function(){  
					if((document.body.scrollHeight-(document.body.clientHeight+document.body.scrollTop))<20){
						if(!_this.loadStatus){
							_this.search.page++;
							_this.getPorudcts();
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

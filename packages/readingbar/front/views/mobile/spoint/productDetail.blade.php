<!-- 继承整体布局 -->
@extends('front::mobile.common.mainSpoint')

@section('content')
<link rel="stylesheet" href="{{url('home/wap/css/spoint.css')}}">

<section id="main">
	
	<div class="am-g prdetail01">
	  <div class="am-u-sm-9 am-u-sm-centered">
	  	<img  class="am-img-responsive"  :src="product.image">
	  </div>
	</div>
	<!--/prdetail01-->
	<div class="prdetail01">
		<span><b>NO：</b>[[ product.serial ]]</span>
		<h4>产品名称：[[ product.product_name ]]</h4>
		<p>[[ product.desc ]]</p>
		<div class="prdetail-jj">
			<em class="fl">
				<span class="fl"><img src="{{url('home/wap/images/sp/sp3_2.png')}}" alt="" width="24px"/>[[ product.point ]]</span>
				<b>库存[[ product.stock_quantity ]]</b>
			</em>
			<em class="fr">
										<!-- 已收藏 -->
		     							<a href="javascript:void(0)"  v-if="product.collection_status"><img src="{{url('files/icons/btn-unable-collect.png')}}" alt=""/></a>
		     							<!-- 未收藏 -->
		     							<a v-on:click="addCollection(product)" href="javascript:void(0)" v-else><img src="{{url('files/icons/btn-able-collect.png')}}" alt=""/></a>
     									
     									<!-- 已加入购物车 -->
		     							<a href="javascript:void(0)"  v-if="product.shoppingcart_status"><img src="{{url('files/icons/btn-unable-shoppingcart.png')}}" alt=""/></a>
		     							<!-- 未加入购物车 -->
		     							<a v-on:click="add(product)" href="javascript:void(0)" v-else><img src="{{url('files/icons/btn-able-shoppingcart.png')}}" alt=""/></a>
			</em>
		</div>
	</div>
	<!--/prdetail01-->
	<a class="tjj-btn-carbutton" href="javascript:void(0)" v-on:click="buy(product)">立即兑换</a>
</section>
<script type="text/javascript">
new Vue({
	el:"#main",
	data:{
		product:{!! $product !!}
	},
	methods:{
		//立即兑换
		buy:function(p){
			window.location.href="{{ url('member/spoint/order/confirmProduct') }}"+"?quantity="+p.quantity+"&product_id="+p.id;
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
<!-- /扩展内容 -->

@endsection
<!-- //继承整体布局 -->

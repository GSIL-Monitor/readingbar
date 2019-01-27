
<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')
<!-- 包含会员菜单 -->
<div class="container" id="orders">
	<div class="row padt9">
	  <div class="col-md-2 home-column-fl">
	  	@include('front::default.member.memberMenu')
	  </div>
	  <!--/ home-column-fl end-->
	  <div class="col-md-10 home-column-fr100">
	  		<ul class="nav nav-tabs">
				<li role="presentation" class="active"><a href="#">我的订单</a></li>
			</ul>
			<div style="clear:both"></div>
			<div class="content">
		        <ul id="myTab" class="nav my-order-nav">
		        	<li class="active"><a href="#already" data-toggle="tab">已付款</a></li>
				    <li> <a href="#obligation" data-toggle="tab">待付款</a></li>
	  			</ul>
				<div  class="tab-content my-order-content">
				   <div class="tab-pane fade in active" id="already">
						<!--/-->
						<template  v-for="o in orders1.data" v-if="o.status==1">
						 <div class="order" style="margin-bottom: 32px;">
					       <ul class="row order-content-title margintop30">
					       		<li>
					       			<div class="col-md-4 fl">
									  <span class="color000000">订单号：[[o.order_id]] </span>
									</div>
					       		</li>
								<li>
									<div class="col-md-3 fl">
									 <span class="color000000">产品名称&nbsp;&nbsp;&nbsp;&nbsp;</span>
									</div>
									<div class="col-md-3 fl"> 使用人 </div>
									<div class="col-md-3 fl">支付日期</div>
									<div class="col-md-1 fl">价格</div>
									<div class="col-md-1 fl">押金</div>
									<div class="col-md-1 fl">总计</div>
								</li>
							</ul>
							<ul class="row order-content-list2">
								<li >
									<div class="col-md-3">[[o.product_name]] </div>
									<div class="col-md-3 fl"> [[o.student_name]] </div>
									<div class="col-md-3 fl">[[o.completed_at]]</div>
									<div class="col-md-1 fl">[[o.price]]</div>
									<div class="col-md-1 fl">[[o.deposit]]</div>
									<div class="col-md-1 fl">[[o.total]]</div>
								</li>
							</ul>
						</div>
							  <div class="row Settlement-title  Settlement-buttom" style="margin-bottom: 32px;" v-if="o.deposit && (o.product_id == 14 || o.product_id== 15)">
								<a href="javascript:void(0)" v-on:click="applyRefundDeposit($event,o)" class="fr button-01" v-if="!o.applyRefundDeposit">退押金申请</a>
								<template v-else>
								 	<a href="javascript:void(0)" class="fr button-01" v-if="o.applyRefundDeposit.status == 1" style="background: grey">押金已退还</a>
								 	<a href="javascript:void(0)" class="fr button-01" style="background: grey" v-else>退押金已申请</a>
							 	</template>
							</div>
						</template>
						<!--翻页-->
							<ul class="pagination fr" v-if="orders1.last_page>1">
							    <li><a v-if="1!=orders1.current_page" v-on:click="doChangePage(1,1)">&laquo;</a></li>
							    <template  v-for="p in orders1.last_page" v-if="Math.abs(p+1-orders1.current_page,1)<4">
							    	<li v-if="orders1.current_page==p+1" class="active"><a href="javascript:void(0)" v-on:click="doChangePage(p+1,1)">[[ p+1 ]]</a></li>
							    	<li v-else><a href="javascript:void(0)" v-on:click="doChangePage(p+1,1)">[[ p+1 ]]</a></li>
							    </template>
							    <li><a v-if="orders1.last_page!=orders1.current_page" v-on:click="doChangePage(orders1.last_page,1)">&raquo;</a></li>
							</ul>
						<!--/翻页-->
						<!--/-->
				   </div>
				   
				   <div class="tab-pane fade in" id="obligation">
				      <span class="error">注:如果优惠的订单未付款，点击取消订单，将退回优惠券。</span><br><br>
				       <!--/-->
				      <template v-for="o in orders0.data" v-if="o.status==0">
				    	<div class="order">
				    		
					       <ul class="row order-content-title margintop30" >
					       		<li>
					       			<div class="col-md-12 fl">
									  <span class="color000000">订单号：[[o.order_id]] </span>
									  <span class="error" v-if="o.discount_price">(优惠券金额[[ o.discount_price ]])</span>
									</div>
					       		</li>
								<li>
									<div class="col-md-3 fl">
									  <span class="color000000">产品名称&nbsp;&nbsp;&nbsp;&nbsp;</span>
									</div>
									<div class="col-md-2 fl"> 使用人 </div>
									<div class="col-md-3 fl">提交时间</div>
									<div class="col-md-3 fl">价格</div>
									<div class="col-md-1 fl">押金</div>
								</li>
							</ul>
							<ul class="row order-content-list">
								<li>
									<div class="col-md-3">[[o.product_name]]  </div>
									<div class="col-md-2 fl">[[o.student_name]]</div>
									<div class="col-md-3 fl">[[o.created_at]]</div>
									<div class="col-md-3 fl">[[o.price]]</div>
									<div class="col-md-1 fl">[[o.deposit]]</div>
								</li>
							</ul>
						</div>
						 <div class="row Settlement-title Settlement-hj ">总计：<span>[[ parseFloat(o.total) ]]</span></div>
						 <div class="row Settlement-title  Settlement-buttom" style="margin-bottom: 32px;">
							
							<a href="javascript:void(0)" v-on:click="showDiscountModal(o)" class="fr button-01">确认支付</a>
							<a href="javascript:void(0)" v-on:click="doDeleteOrder(o.order_id)" class="fr  button-02 margrt10">取消支付</a>
						</div>
						
						</template>
						<!--翻页-->
							<ul class="pagination fr" v-if="orders0.last_page>1">
							    <li><a v-if="1!=orders0.current_page" v-on:click="doChangePage(1,0)">&laquo;</a></li>
							    <template  v-for="p in orders0.last_page" v-if="Math.abs(p+1-orders0.current_page,0)<4">
							    	<li v-if="orders0.current_page==p+1" class="active"><a href="javascript:void(0)" v-on:click="doChangePage(p+1,0)">[[ p+1 ]]</a></li>
							    	<li v-else><a href="javascript:void(0)" v-on:click="doChangePage(p+1,0)">[[ p+1 ]]</a></li>
							    </template>
							    <li><a v-if="orders0.last_page!=orders0.current_page" v-on:click="doChangePage(orders0.last_page,0)">&raquo;</a></li>
							</ul>
						<!--/翻页-->
						<!--/-->
				   </div>
				   <!--/-->
				</div>
			</div>
			<!--/content-->
		</div>
		<!--/col-md-10-->
	</div>
	<!--支付表单-->
		<form id="payForm" style="display:none" method="post" :action="ajaxUrls.payOrdersUrl">
			<input value="{{ csrf_token() }}" name="_token">
			<input :value="pay.order_id" name="order_id">
			<input :value="pay.pay_type" name="pay_type">
	    </form>
	<!--/支付表单-->
	<!-- 支付方式选择弹出层 -->
	<div class="modal fade" id="payModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-dialog">
	        <div class="modal-content">
	        <div class="modal-body">
	            <div class="row">
	            	<h3 class="col-md-12" style="color:#4bd2bf">选择支付方式:</h3>
	            </div>
	            <br><br>
	            <div class="row">
	            	<div class="col-md-6">
	            		<input type="radio" v-model="pay.pay_type" value="wxpay"  name="pay_type"><img alt="微信" src="{{url('home/pc/images/pay/wxpay.png')}}" style="height:50px;margin-left:20px">
	            	</div>
	            	<div  class="col-md-6">
	            		<input type="radio" v-model="pay.pay_type" value="alipay" name="pay_type"><img alt="支付宝" src="{{url('home/pc/images/pay/alipay.png')}}" style="height:50px;margin-left:20px">
	            	</div>
	            </div>
	            <br><div class="error">*蕊丁吧会员服务有效期从购买之日起生效，定制阅读单次体验不可退不可冻结。</div><br>
	            <div class="row">
	            	<div class="col-md-12">
		            	 <a href="javascript:void(0)" v-on:click="doPayOrder()" class="fr button-01 margft10">确认支付</a>
						 <a href="javascript:history.back()" class="fr button-02" data-dismiss="modal">取消支付</a>
					</div>
	            </div>
	        </div>
	        </div><!-- /.modal-content -->
	    </div><!-- /.modal -->
	</div>
	<!-- //支付方式选择弹出层 -->
	<!-- 微信支付二维码弹出层 -->
	<div class="modal fade" id="CodeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-dialog">
		    <div class="modal-content">
		        <div class="modal-body">
		        	<div class="row">
		            	<h3 class="col-md-12" style="color:#4bd2bf">微信支付二维码:</h3>
		            </div>
			        <div class="row">
			        	<div class="col-md-12 text-center">
			        		<img alt="微信支付二维码" :src="wxQRCode.url" width="50%">
			        	</div>
			        </div>
		        </div>
	        </div>
	    </div><!-- /.modal -->
	</div>	
	<!-- 选择使用折扣券弹出层 -->
		<div class="modal fade" id="DiscountModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		    <div class="modal-dialog">
			    <div class="modal-content">
			        <div class="modal-body">
			        	<div class="row">
			            	<h3 class="col-md-12" style="color:#4bd2bf">选择使用优惠券:</h3>
			            </div>
			            <br>
				        <div class="row">
				        	<div class="col-md-12" v-for="d in discounts">
				        		<input type="checkbox" v-model="pay.discounts" :value="d.id" class="col-md-1">
				        		<lable class="form-lable col-md-11 text-left">
					        		<h3 class="col-md-3" style="color:#4bd2bf;">￥[[ d.price ]]</h3>
					        		<h5 class="col-md-9">[[ d.name ]]</h5>
					        	</lable>
					        	<br><br>
				        	</div>
				        </div>
				        <br>
				        <div class="row">
				        	<div class="col-md-12">
				            	 <a href="javascript:void(0)" v-on:click="showPTS()" class="fr button-01 margft10">确认</a>
								 <a href="javascript:history.back()" class="fr button-02" data-dismiss="modal">取消支付</a>
							</div>
						</div>
			        </div>
		        </div>   
		    </div><!-- /.modal -->
		</div>
		<!-- //选择使用折扣券弹出层  -->			
</div>
<script type="text/javascript">
var orders=new Vue({
	el:"#orders",
	data:{
		ajaxUrls:{
			//获取订单
			getOrdersUrl:"{{url('api/member/order/all')}}",
			//支付未付款订单
			payOrdersUrl:"{{url('api/member/order/pay')}}",
			//删除未付款订单
			deleteOrdersUrl:"{{url('api/member/order/delete')}}",
		},
		//未付款订单
		orders0:null,
		search0:{
			page:1,
			limit:5,
			status:0
		},
		//已付款订单
		orders1:null,
		search1:{
			page:1,
			limit:5,
			status:1
		},
		//支付
		pay:{
			order_id:null,
			discounts:[],
			pay_type:'alipay'
		},
		discounts:null,
		wxQRCode:null,
		setInterval:null
	},
	created:function(){
		this.doGetOrders0();
		this.doGetOrders1();
		this.doGetDiscounts();
	},
	methods:{
		//获取未付款订单
		doGetOrders0:function(){
			var _this=this;
			$.ajax({
				url:_this.ajaxUrls.getOrdersUrl,
				dataType:"json",
				data:_this.search0,
				success:function(json){
					_this.orders0=json;
				}
			});
		},
		//获取已付款订单
		doGetOrders1:function(){
			var _this=this;
			$.ajax({
				url:_this.ajaxUrls.getOrdersUrl,
				dataType:"json",
				data:_this.search1,
				success:function(json){
					_this.orders1=json;
				}
			});
		},
		//删除未付款订单
		doDeleteOrder:function(oid){
			if(!confirm('是否确认删除订单'+oid)){
				return;
			}
			var _this=this;
			$.ajax({
				url:_this.ajaxUrls.deleteOrdersUrl,
				dataType:"json",
				type:"POST",
				data:{order_id:oid},
				success:function(json){
					if(json.status){
						alert(json.success);
						_this.doGetOrders0();
					}else{
						alert(json.error);
					}
				}
			});
		},
		//订单翻页
		doChangePage:function(page,status){
			switch(status){
				case 0:
					this.search0.page=page;
					this.doGetOrders0();
					break
				case 1:
					this.search1.page=page;
					this.doGetOrders1();
					break
			}
		},

		//显示支付选择弹出层
		showPTS:function(){
			$("#DiscountModal").modal('hide');
			$("#payModal").modal({backdrop: 'static', keyboard: false});
		},
		//确认支付
		doPayOrder:function(){
			var _this=this;
			switch(_this.pay.pay_type){
				case 'alipay':$('#payForm').submit();break;
				case 'wxpay':
					$.ajax({
						url:"{{url('api/member/order/pay')}}",
						data:_this.pay,
						type:"POST",
						dataType:"json",
						success:function(json){
							if(json.status){
								_this.wxQRCode=json;
								$("#payModal").modal('hide');
								_this.showQRCode();
							}else{
								alert(json.error);
							}
						},
						error:function(){
							alert('链接失败！');
						}
					});
				break;
			}
		},
		//微信支付二维码显示
		showQRCode:function(){
			$("#CodeModal").modal('show');
			this.requestOrderStatus();
		},
		//微信支付定时请求支付状态
		requestOrderStatus:function(){
			 var _this=this;
			 if(_this.setInterval){
				 clearInterval(_this.setInterval);
			 }
			 _this.setInterval=setInterval(function(){
				 var _setInterval=this;
				 $.ajax({
						url:"{{url('api/member/order/getStatusByOID')}}",
						data:{order_id:_this.wxQRCode.order_id},
						dataType:"json",
						success:function(json){
							if(json.status){
								alert('支付成功！');
								window.location.reload();
							}
						}
				 });
			 },3000);
		},
		//获取用户折扣券
		doGetDiscounts:function(){
			var _this=this;
			$.ajax({
				url:"{{url('api/member/discount/getDiscounts')}}",
				dataType:"json",
				success:function(json){
					_this.discounts=json;
				},
				errors:function(){
					
				}
		 	});
		},
		//显示折扣券使用弹出层
		showDiscountModal:function(o){
			this.pay.order_id=o.order_id;
			this.showPTS();return;
			if(this.discounts && this.discounts.length){
				$("#DiscountModal").modal({backdrop: 'static', keyboard: false});
			}else{
				this.showPTS();
			}
		},
		// 退押金申请
		applyRefundDeposit:function (e,o) {
			appConfirm({
				msg: '是否申请退押金？如若不退款，则下次购买产品无需支付押金！',
				ok: {
					text: '确认申请',
					callback:function () {
						$.ajax({
							url: "{{ url('member/accountCenter/orders/applyRefund') }}",
							dataType:"json",
							type:"POST",
							data:{id:o.id},
							breforeSEend: function () {
								$(e.target).html('<i class="fa fa-spin fa-refresh"></i>');
							},
							success:function(json){
								appAlert({
									msg: json.message
								});
							},
							error: function (e){
								appAlert({
									msg: e.responseJSON.message
								});
							},
							complete: function () {
								$(e.target).html('申请退押金');
							}
						});
					}
				}
			});
		}
	}
});
</script>
<script>
//接收消息提示
@if(session('buy_success'))
	switch ({{ session('product_id') }}) {
		case 16: 
			appConfirm({
				title: '支付成功',
				msg: "您一定是特别重视孩子英文阅读的家长！<br/>相信您对我们的《书籍测试服务》也会感兴趣，现在购买直减99元哦~~",
				ok: {
					text: '我要去看看',
					callback: function () {
						window.location.href = "{{ url('product/list') }}"
					}
				},
				no: {
					text: '算了，下次吧'
				}
			});
			break;
		case 17: 
			appConfirm({
				title: '支付成功',
				msg: "您一定是特别重视孩子英文阅读的家长！<br/>难道您不想通过《STAR阅读能力测评》了解孩子的英文阅读能力水平吗？现在购买直减99元哦~~",
				ok: {
					text: '想了解',
					callback: function () {
						window.location.href = "{{ url('product/list') }}"
					}
				},
				no: {
					text: '算了，下次吧'
				}
			});
			break;
		case 18: 
			appConfirm({
				title: '支付成功',
				msg: "您一定是特别重视孩子英文阅读的家长！<br/>我们还为您提供美国进口AR原版书籍借阅服务，快去商城兑换《借阅优惠券》吧~~",
				ok: {
					text: '去商城',
					callback: function () {
						window.location.href = "{{ url('member/spoint/product') }}"
					}
				},
				no: {
					text: '算了，下次吧'
				}
			});
			break;
	}
@endif
</script>
<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

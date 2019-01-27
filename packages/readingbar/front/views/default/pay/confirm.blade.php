<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')
<!-- 扩展内容-->
<div class="bgf6f6f6 padding30">
	<div class="container">
		<div class="container cont-about6 bgffff padding-30-30">
			<div class="Settlement-list">
			    <h1 class="Settlement-h1">确认订单中心</h1>
				<ul class="row Settlement-title padding-30 margintop30">
					<li>
						<div class="col-md-2 fl">
						 <span>产品名称</span>
						</div>
						<div class="col-md-2 fl">孩子</div>
						<div class="col-md-2 fl">费用</div>
						<div class="col-md-2 fl">续费优惠费用</div>
						<div class="col-md-2 fl">押金</div>
						<div class="col-md-2 fl">有效期（单位：天）</div>
					</li>
				</ul>
				<ul class="row Settlement Settlement-title padding-30">
					<li>
						<div class="col-md-2">{{$product['product_name']}}</div>
						<div class="col-md-2">{{$student['name']}}</div>
						<div class="col-md-2">{{$product['price']}}</div>
						<div class="col-md-2">{{$product['renew_discount_price']}}</div>
						<div class="col-md-2">{{$product['deposit']}}</div>
						<div class="col-md-2">{{$product['days']}}天</div>
					</li>
				</ul>
				<div class="row padding-30 Settlement col-md-12">
					<div class="col-md-12">
						优惠券(<font color="#ff6421">注：不可抵扣押金</font>):
						<span v-if="discounts===null">加载优惠券信息...</span>
						<span v-if="discounts.length===0">无</span>
					</div>
					<label  class="col-md-3" v-for="d in discounts" style="color:#4bd2bf;">
							<input type="checkbox" v-on:change="newPayPrice()" v-model="orderForm.discounts" :value="d.id">￥[[ d.price ]]([[ d.name ]])
					</label>
				</div>
				<div class="row Settlement-title padding-30 Settlement-hj ">
					总计：<span>￥{{$product['price']+$product['deposit']}}</span>
					实付：<span>￥[[ total ]]</span>
				</div>
				
				<div class="row Settlement-title padding-30 Settlement-buttom">
				    <a href="javascript:void(0)" v-on:click="showPTS()" class="fr button-01 margft10">确认支付</a>
					<a href="javascript:history.back()" class="fr button-02">取消支付</a>
				</div>
				<form id="payForm" style="display:none" method="post" action="{{ $action }}">
					<input value="{{ csrf_token() }}" name="_token">
					<input :value="orderForm.product_id" name="product_id">
					<input :value="orderForm.service_id" name="service_id">
					<input :value="orderForm.student_id" name="student_id">
					<input type="checkbox" v-for="d in orderForm.discounts" :value="orderForm.discounts[$index]" checked name="discounts[]">
					<input :value="orderForm.pay_type" name="pay_type">
				</form>
			</div>
			<!--/Settlement-list-->
		</div>
	</div>
</div>
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
            		<input type="radio" v-model="orderForm.pay_type" value="wxpay"  name="pay_type"><img alt="微信" src="{{url('home/pc/images/pay/wxpay.png')}}" style="height:50px;margin-left:20px">
            	</div>
            	<div  class="col-md-6">
            		<input type="radio" v-model="orderForm.pay_type" value="alipay" name="pay_type"><img alt="支付宝" src="{{url('home/pc/images/pay/alipay.png')}}" style="height:50px;margin-left:20px">
            	</div>
            </div>
            <br>
            <div class="error">*蕊丁吧会员服务从购买之日起生效，测试系统服务和借阅服务不可退不可冻结。</div>
            <br>
            <div class="row">
            	<div class="col-md-12">
	            	 <a href="javascript:void(0)" v-on:click="payOrder()" class="fr button-01 margft10">确认支付</a>
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
<!-- //微信支付二维码弹出层 -->
<script type="text/javascript">
var pts=new Vue({
	el:"body",
	data:{
		orderForm:{
			product_id:"{{ $product['id'] }}",
			student_id:"{{ $student['id'] }}",
			service_id:"{{ $service_id or '' }}",
			discounts:[],
			pay_type:'alipay',
		},
		total:0,
		wxQRCode:null,
		discounts:null,
	},
	created:function(){
		this.newPayPrice();
		this.doGetDiscounts();
	},
	methods:{
		//显示支付选择弹出层
		showPTS:function(){
			$("#DiscountModal").modal('hide');
			$("#payModal").modal({backdrop: 'static', keyboard: false});
		},
		//确认支付
		payOrder:function(){
			var _this=this;
			switch(_this.orderForm.pay_type){
				case 'alipay':$('#payForm').submit();break;
				case 'wxpay':
					if(!_this.wxQRCode){
						$.ajax({
							url:"{{ $action }}",
							data:_this.orderForm,
							type:"POST",
							dataType:"json",
							success:function(json){
								if(json.status){
									if(json.redirect){
										alert(json.success);
										window.location.href=json.redirect;
										return;
									}
									_this.wxQRCode=json;
									$("#payModal").modal('hide');
									_this.showQRCode();
									_this.doGetDiscounts();
								}else{
									alert(json.error);
								}
							},
							error:function(){
								alert('链接失败！');
							}
						});
					}else{
						$("#payModal").modal('hide');
						_this.showQRCode();
					}
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
			 var stop = false;
			 setInterval(function(){
				 var _setInterval=this;
				 $.ajax({
						url:"{{url('api/member/order/getStatusByOID')}}",
						data:{order_id:_this.wxQRCode.order_id},
						dataType:"json",
						success:function(json){
							if(json.status && !stop){
								$("#CodeModal").modal('hide');
								switch ({{ $product['id'] }}) {
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
												text: '算了，下次吧',
												callback: function () {
													window.location.href = "{{ url('member/accountCenter/orders') }}"
												}
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
												text: '算了，下次吧',
												callback: function () {
													window.location.href = "{{ url('member/accountCenter/orders') }}"
												}
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
												text: '算了，下次吧',
												callback: function () {
													window.location.href = "{{ url('member/accountCenter/orders') }}"
												}
											}
										});
										break;
								}
								stop = true;
								window.clearInterval(_setInterval);
							}
						}
				 });
			 },1000);
		},
		//获取用户折扣券
		doGetDiscounts:function(){
			var _this=this;
			$.ajax({
				url:"{{url('api/member/discount/getDiscounts')}}",
				dataType:"json",
				data:_this.orderForm,
				success:function(json){
					_this.discounts=json;
				},
				errors:function(){
					_this.doGetDiscounts();
				}
		 	});
		},
		//统计实付价格
		newPayPrice:function(){
			var price={{ $product['price'] }};
			var deposit={{ $product['deposit'] }};
			var renewDiscountPrice = {{ $product['renew_discount_price'] }};
			var discounts =this.orderForm.discounts;
			var discountPrice=0;
			for(i in discounts){
				for(j in this.discounts){
					if(discounts[i]==this.discounts[j].id){
						discountPrice+=this.discounts[j].price;
					}
				}
			}
			price=price-discountPrice>0?price-discountPrice:0;
			price=price-renewDiscountPrice>0?price-renewDiscountPrice:0;
			this.total=price+deposit;
		}
	}
});
</script>
<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

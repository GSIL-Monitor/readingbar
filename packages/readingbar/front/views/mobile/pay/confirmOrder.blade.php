<!-- 继承整体布局 -->
@extends('front::mobile.common.main2l')

@section('content')
<!-- 扩展内容-->
<section>
		<script type="text/javascript">
		function callpay()
		{
			if (typeof WeixinJSBridge == "undefined"){
			    if( document.addEventListener ){
			        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
			    }else if (document.attachEvent){
			        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
			        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
			    }
			}else{
				
			    jsApiCall();
			}
		}
		//调用微信JS api 支付
		function jsApiCall()
		{
			WeixinJSBridge.invoke(
				'getBrandWCPayRequest',
				{!! $JsApiPay['jsApiParameters'] !!},
				function(res){
					if(res.err_msg=='ok'){
						//alert('支付成功');
						switch ({{ $order['product_id'] }}) {
							case 16: 
								amazeConfirm({
									title: '支付成功',
									msg: "您一定是特别重视孩子英文阅读的家长！相信您对我们的《书籍测试服务》也会感兴趣，现在购买直减99元哦~~",
									confirm: '我要去看看',
									onConfirm: function () {
										window.location.href = "{{ url('product/list') }}"
									},
									cancel: '算了，下次吧',
									onCancel: function () {
										window.history.back();
									}
								});
								break;
							case 17: 
								appConfirm({
									title: '支付成功',
									msg: "您一定是特别重视孩子英文阅读的家长！难道您不想通过《STAR阅读能力测评》了解孩子的英文阅读能力水平吗？现在购买直减99元哦~~",
									confirm: '想了解',
									onConfirm: function () {
										window.location.href = "{{ url('product/list') }}"
									},
									cancel: '算了，下次吧',
									onCancel: function () {
										window.history.back();
									}
								});
								break;
							case 18: 
								appConfirm({
									title: '支付成功',
									msg: "您一定是特别重视孩子英文阅读的家长！我们还为您提供美国进口AR原版书籍借阅服务，快去商城兑换《借阅优惠券》吧~~",
									confirm: '去商城',
									onConfirm: function () {
										window.location.href = "{{ url('member/spoint/product') }}"
									},
									cancel: '算了，下次吧',
									onCancel: function () {
										window.history.back();
									}
								});
								break;
						}
					}
					// window.history.back();
				}
			);
		}
		window.onload=function(){
			callpay();
		}
		
		</script>
       <div class="am-tab-panel am-active  padding0">
		        <ul>
		            <div class="box-10"></div>
		        	<li class="margintop10 orders-list">
		        	   <div class="am-g margintop5"><span>产品名称:{{ $order['product_name'] }}</span></div><!--/am-g-->
				       <div class="am-g margintop5">
		                    <div class="am-u-sm-3 fl orders-list-bottom">
		                        <span>孩子:</span>
		                        <span>{{ $order['name'] }}</span>
		                    </div>
		                    <div class="am-u-sm-3 fl orders-list-bottom">
		                        <span>年费:</span>
		                        <span>{{ $order['price'] }}</span>
		                        </div>
		                    <div class="am-u-sm-3 fr orders-list-bottom">
		                    	<span>押金:</span>
		                    	<span>{{ $order['deposit'] }}</span>
		                    </div>
		                    <div class="am-u-sm-3 fr orders-list-bottom">
		                    	<span>使用期限:</span>
		                    	<span>{{ $order['days'] }}</span>
		                    </div>
				        </div>
				        <!--/am-g -->
				        <div class="am-g marginbottom5"><span class=" fr">总计：<b class="ds-bjd">{{ $order['price']+$order['deposit'] }}</b></span></div> <!--/am-g-->
		        	</li>
		        </ul>
                <!--page end-->
		    </div>
</section>

<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

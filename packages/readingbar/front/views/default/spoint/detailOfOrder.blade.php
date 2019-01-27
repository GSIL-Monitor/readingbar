<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')
<link rel="stylesheet" type="text/css" href="{{url('home/pc/css/spoint.css')}}">

<div class="content" id="main">
	<div class="container">
		<div class="spoint-childpage">
			<span>您的位置</span>
			<a href="{{ url('member/spoint/product') }}">商城</a>
			<a href="{{ url('member/spoint/order/log') }}">我的订单</a>
			<a href="#" class="link">订单详情</a>
		</div>
	</div>
	<!--/row-->
    <div class="orderlog">
		<div class="orderlog-lsit">
			<div class="orderlog-state">
				<span>当前订单状态：{{ $order->status_text }}</span>
				<p>交易已成功，如果你还未收到产品，或者收到的产品无法正常使用，请及时联系客服。</p>
			</div>
			<!--/orderlog-state-->
			<div class="orderlog-kj">
				<div class="orderlog-xx dese">订单信息</div>
				<div class="orderlog-time dese">
					<span>订单编号：{{ $order->order_id }}</span>
					<span>成交时间：{{ $order->created_at }}</span>
				</div>
				@if($order->LogisticStatus)
				<div class="orderlog-wl dese">物流信息</div>
				<div class="orderlog-xq dese">
					<p>地址:{{ $order->address }}</p>
					<p>收件:{{ $order->reciver }}</p>
					<p>联系方式:{{ $order->tel }}</p>
					<p>物流公司:{{ $order->express_name }}</p>
					<p>运单号:{{ $order->LogisticCode }}</p>
					@if($order->Traces)
					<p>物流跟踪:<br>
							{{ $order->Traces->AcceptTime }}:{{ $order->Traces->AcceptStation }}
					</p>
					@endif
				</div>
				@endif
				<div class="orderlog-cpxx">产品信息</div>
				<ul class="cpxxsit">
					 　
			       		<li>
			       			<div class="top">
			       				<span class="cpxxanme01" style="width:475px !important">产品</span>
			       				<span class="cpxxanme03">价格</span>
			       				<span class="cpxxanme04">数量</span>
			       			</div>
			       			@foreach ($order->products as $p)
							
			       			<div class="center">
			       				<div class="loglsit-cet01" style="width:475px !important">
			       					<div class="img"><img src="{{ $p->image}}"></div>
			       					<div class="jj" >
			       						<h4>{{ $p->product_name }}</h4>
			       						<span>{{ $p->desc }}</span>
			       					</div>
			       				</div>
			       				<!--/loglsit-cet04-->
			       				<div class="loglsit-cet02">
			       					<div class="Price">{{ $p->point }}</div>
			       				</div>
			       				<!--/loglsit-cet02-->
			       				<!--/loglsit-cet03-->
			       				<div class="loglsit-cet04">
			       					<span>{{ $p->quantity }}</span>
			       				</div>
			       				<!--/loglsit-cet04-->
			       			</div>
			       			@endforeach
			       			<!--/center-->
			       		</li>
			     </ul>
			    <!--/-->
			    <div class="logtotal">
			    	<span>实付积分：</span>
			    	<div class="Price">{{ $order->total_points }}</div>
			    </div>
			</div>
			<!--/orderlog-state-->
		</div> 		 
     	<!--/orderlog-lsit-->
	 
    </div>
    <!--/orderlog-->
</div>
<!--/content-->

@endsection
<!-- //继承整体布局 -->

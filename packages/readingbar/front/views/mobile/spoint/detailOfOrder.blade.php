<!-- 继承整体布局 -->
@extends('front::mobile.common.mainSpoint')

@section('content')
<link rel="stylesheet" href="{{url('home/wap/css/spoint.css')}}">

<section id="main">
<div class="pab15_15">
	<div class="am-g am-g-fixed">
	 	<h4 class="order-detail-zt">订单状态</h4>
	</div>
	<!--/am-g-->
	<div class="am-g am-g-fixed order-detail1">
	 	<span class="order-detail-tiitle">当前订单状态：{{ $order->status_text }}</span>
	 	<p class="order-detail-bz">交易已成功，如果你还未收到产品，或者收到的产品无法正常使用，请及时联系客服。</p>
	</div>
	<!--/am-g-->
	@if($order->LogisticStatus)
	<div class="am-g am-g-fixed order-detail1">
	 	<span class="order-detail-tiitle am-u-sm-12">地址:<br>{{ $order->address }}</span>
	 	<div class="am-u-sm-6">
	 		<p>收件:{{ $order->reciver }}</p>
	 		<p>物流公司:{{ $order->express_name }}</p>
	 	</div>
	 	
		
	 	<!--/am-g-->
  		<div class="am-u-sm-6">
  			<p>联系方式:{{ $order->tel }}</p>
	 		<p>运单号:{{ $order->LogisticCode }}</p>
	 		<p></p>
  		</div>
  		<!--/am-g-->
  		<br>
	 	@if($order->Traces)
				<span class="am-u-sm-12">物流跟踪:<br>
							{{ $order->Traces->AcceptTime }}:{{ $order->Traces->AcceptStation }}
				</span>
		@endif
	</div>
	@endif
	<!--/am-g-->
</div>
<div class="pab15_15">
	<div class="am-g am-g-fixed">
	 	<h4 class="order-detail-zt">订单信息</h4>
	</div>
</div>
<ul class="am-g pab15_15 order-detail3">

	<li class="order-detail-lsit">
		<div class="am-g">
			<span class="ord-delsit01">成交时间：{{ $order->created_at }}</span>
			<span class="ord-delsit01">订单编号：{{ $order->order_id }}</span>
		</div>
		@foreach ($order->products as $p)
		<div class="am-g ord-delsit02">
			<div class="am-u-sm-4"><img src="{{ $p->image}}"></div>
			<div class="am-u-sm-8">
				<h4>{{ $p->product_name }}</h4>
				<span>{{ $p->desc }}</span>
				<p>
					<span class="Price fl"><img src="{{url('home/wap/images/sp/sp3_2.png')}}" alt=""/>{{ $p->point }}</span>
					<span class="nume fr">{{ $p->quantity }}</span>
				</p>
			</div>
		</div>
		@endforeach
	</li>
</ul>















</section>

@endsection
<!-- //继承整体布局 -->

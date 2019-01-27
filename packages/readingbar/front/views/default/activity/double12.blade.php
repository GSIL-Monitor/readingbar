<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')
<!-- 扩展内容-->
<link rel="stylesheet" type="text/css" href="{{url('home/pc/css/twelve.css')}}">
<div class="banner">
	<img src="{{url('home/pc/images/twelve/sse_02.jpg')}}" alt=""/>
</div>
<div class="mon twelve_01">
	<div class="main">
		<p id="twelve-01-txt01">赠送价值<span class="colorff1b06">99元</span>的蕊丁吧文件包一个！</p>
		<p id="twelve-01-txt02">赠送价值<span class="colorff1b06">188元</span>美国正品Story Time Dice 一个！</p>
	</div>
</div>
<!-- /mon-->  
<div class="mon twelve_02">
	<div class="main">
		<p id="twelve-01-txt01">赠送价值<span class="colorff1b06">399元</span>的蕊丁吧双肩背包一个！</p>
		<p id="twelve-01-txt02">赠送价值<span class="colorff1b06">288元</span>的美国Boogie Board 电子手写板一个！</p>
	</div>
</div>
<!-- /mon-->
<div class="mon twelve_03">
	<div class="main">
		<div id="twelve-03-txt01">请进入官网（www.readingbar.net），登录完善信息后，选择<a href="{{ url('/product/list') }}" class="colored2c2d">产品</a>进行购买，未注册用户请先注册。</div>
		<div id="twelve-03-txt02">
			<p>*在手机浏览器进入官网（www.readingbar.net），登录完善信息后，点击左上角菜单，选择<a href="{{ url('/product/list') }}" class="colored2c2d">产品</a>进行购买，未</p>
			<p>注册用户请先注册。</p>
			<p>*在官方微信（蕊丁英文阅读家），点击菜单《蕊丁官网》，登录完善信息后，点击左上角菜单选择<a href="{{ url('/product/list') }}" class="colored2c2d">产品</a>进行购买,</p>
			<p>未注册用户请先注册。</p>
		</div>
	</div>
</div>
<!-- /mon-->
<div class="mon twelve_04">
	<div class="main">
		<div id="twelve-04-txt01">请扫描关注蕊丁吧官方微信，在公众号回复以下信息，即可获取相应服务内容。</div>
		<div id="twelve-04-txt02">
			<p>回复“蕊丁吧”，了解我们是谁</p>
			<p>回复“测评”，了解美国STAR测评是什么</p>
			<p>回复“测试”，了解美国AR英语阅读分级体系是什么</p>
			<p>回复“购买”，了解如何根据ZPD购买英语分级读物</p>
			<p>回复“会员”，了解定制阅读、自主阅读服务内容</p>
			<p>全国客服电话：400-625-9800</p>
		</div>
	</div>
</div>
<!-- /mon-->
<div class="mon bgffcc00" style="height: 100px;"></div>

<!-- //扩展内容-->
@endsection
<!-- //继承整体布局 -->

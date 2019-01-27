<!-- 继承整体布局 -->
@extends('front::default.common.main') 
@section('content')
<link rel="stylesheet" type="text/css" href="{{url('home/pc/css/singleReading.css')}}">
<div class="banner">
	<img src="{{url('home/pc/images/singleReading/singleReading_02.jpg')}}" alt=""/>
</div>
<div class="mon singleReading_01">
	<div class="main">
		<div id="singleReading_01_txt1">
			<p>“定制阅读单次体验”仅需<em>688</em>元</p>
			<p>赠价值<em>688</em>元蕊丁吧双肩背包一个!</p>
			<p><a href="{{ url('/product/list') }}"><img src="{{url('home/pc/images/singleReading/ioc_03.png')}}"></a>了解详情</p>
		</div>
		<div id="singleReading_01_txt2">
			<p>“定制阅读单次体验”用户，在体验结束之前购买“定制阅读”服务:</p>
			<p>* 只需续费5700元，不再收取“图书借阅押金”;</p>
			<p>* 服务有效期从“定制阅读单次体验”购买日期起一年。</p>
		</div>
	</div>
</div>
<!--/singleReading_01-->
<div class="mon singleReading_02">
	<div class="main">
		<h4 class="singleReading_02_titile">活动参与方式</h4>
		<div id="singleReading_02_txt1">
			<h4>PC端：</h4>
			<p>请进入官网（www.readingbar.net），登录完善信息后，选择   <a href="{{ url('/product/list') }}" class="colored2c2d">产品</a> 进行购买，未注册用户请先注册。</p>
		</div>
		<div id="singleReading_02_txt2">
			<h4>手机端：</h4>
			<p>*在手机浏览器进入官网（www.readingbar.net），登录完善信息后，点击左上角菜单，选择   <a href="{{ url('/product/list') }}" class="colored2c2d">产品</a> 进行购买，
			未注册用户请先注册。</p>
			<p>*在官方微信（蕊丁英文阅读家），点击菜单《蕊丁官网》，登录完善信息后，点击左上角菜单选择  <a href="{{ url('/product/list') }}" class="colored2c2d">产品</a>  进行购买，未
			注册用户请先注册。</p>
		</div>
		<!--/-->
	</div>
</div>
<!--/singleReading_02-->
<div class="mon singleReading_03">
	<div class="main">
	    <div id="singleReading_03_txt1">请扫描关注蕊丁吧官方微信，在公众号回复以下信息，即可获取相应服务内容。</div>
		<div id="singleReading_03_txt2">
			<p>回复“蕊丁吧”，了解我们是谁</p>
			<p>回复“测评”，了解美国STAR测评是什么</p>
			<p>回复“测试”，了解美国AR英语阅读分级体系是什么</p>
			<p>回复“购买”，了解如何根据ZPD购买英语分级读物</p>
			<p>回复“会员”，了解定制阅读、自主阅读服务内容</p>
			<p>全国客服电话：400-625-9800</p>
		</div>
	</div>
</div>
<!--/singleReading_01=3-->

<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

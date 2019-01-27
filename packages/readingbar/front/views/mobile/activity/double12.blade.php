<!-- 继承整体布局 -->
@extends('front::mobile.common.main')

@section('content')
<!-- 扩展内容-->
<style type="text/css">
	.twelve-txt{ padding: 15px 10px; overflow: hidden;}
	#twelve-03-txt01{margin-bottom: 9px;}
	.twelve-txt h4{color: #000000;
    font-size: 1.4rem;}
	.twelve-txt p{    font-size: 1.3rem;}
	.twelve-txt p a{color: #ed2c2d;
    font-size: 1.6rem;}
</style>
<!-- 扩展内容-->
<article>
	<div class="container">
		<img src="{{url('home/wap/images/twelve/twelve_02.jpg')}}" class="am-img-responsive"  alt=""/>
	</div>
	<div style=" padding-bottom: 20px;    background: #ffcc00;">
    	<div class="am-figure am-figure-default" data-am-widget="figure"  data-am-figure="{  pureview: 'true' }">
    	<img src="{{url('home/wap/images/twelve/twelve_03.jpg')}}" class="am-img-responsive"  alt=""/ style="padding:0;margin:0;">
    	</div>
    	<div class="twelve-txt">
    		<div id="twelve-03-txt01">
    		   <h4>PC端：</h4>
    		   <p>请进入官网（www.readingbar.net），登录完善信息后，选择<a href="{{ url('/product/list') }}" class="colored2c2d">产品</a>进行购买，未注册用户请先注册。</div>
			<div id="twelve-03-txt02">
		        <h4>手机端：</h4>
				<p>*在手机浏览器进入官网（www.readingbar.net），登录完善信息后，点击左上角菜单，选择<a href="{{ url('/product/list') }}" class="colored2c2d">产品</a>进行购买，未</p>
				<p>注册用户请先注册。</p>
				<p>*在官方微信（蕊丁英文阅读家），点击菜单《蕊丁官网》，登录完善信息后，点击左上角菜单选择<a href="{{ url('/product/list') }}" class="colored2c2d">产品</a>进行购买,</p>
				<p>未注册用户请先注册。</p>
			</div>
    	</div>
    	<div class="am-figure am-figure-default" data-am-widget="figure"  data-am-figure="{  pureview: 'true' }"><img src="{{url('home/wap/images/twelve/twelve_04.jpg')}}" class="am-img-responsive"  alt=""/ style="padding:0;margin:0;"></div>
    	<div class="am-figure am-figure-default" data-am-widget="figure"  data-am-figure="{  pureview: 'true' }"><img src="{{url('home/wap/images/twelve/twelve_05.jpg')}}" class="am-img-responsive"  alt=""/ style="padding:0;margin:0;"></div>
	</div>
</article>
<!-- //扩展内容-->
@endsection
<!-- //继承整体布局 -->

<!-- 继承整体布局 -->
@extends('front::mobile.common.main2l') @section('content')
<!-- 扩展内容-->
<style type="text/css">
	.twelve-txt{ padding: 15px 10px; overflow: hidden;}
	#twelve-03-txt01{margin-bottom: 9px;}
	.twelve-txt h4{color: #5b0603;
    font-size: 1.4rem; font-weight: bold;}
	.twelve-txt p{    font-size: 1.3rem; color: #5b0603; font-weight: bold;}
	.twelve-txt p a{color: #ed2c2d;
    font-size: 1.6rem;}
    .singleReading-link{ position: relative;width: 100%;}
    #singleReading_01_txt1{ position: absolute; top:0; left: 10px;}
    #singleReading_01_txt1 p{font-size: 1.3rem; color: #5b0603; font-weight: bold;}
    #singleReading_01_txt1 em{color: #ff0900;
    font-style: normal;
    font-size: 1.8rem;}
    #singleReading_01_txt1 a{width: 50px; }
    #singleReading_01_txt1 a img{}
</style>
<article>
	<div class="container">
	  <div style=" padding-bottom: 20px;    background: #ffcc00;">	
	   
		<img src="{{url('home/wap/images/singleReading/singleReading_02.jpg')}}" class="am-img-responsive" style="padding:0;margin:0;" alt=""/>
		<img src="{{url('home/wap/images/singleReading/singleReading_03.jpg')}}" class="am-img-responsive" style="padding:0;margin:0;" alt=""/>
		<div class="singleReading-link">
		<img src="{{url('home/wap/images/singleReading/singleReading_04.jpg')}}" class="am-img-responsive" style="padding:0;margin:0;" alt=""/>
	        <div id="singleReading_01_txt1">
				<p>“定制阅读单次体验”仅需<em>688</em>元</p>
				<p>赠价值<em>688</em>元蕊丁吧双肩背包一个!</p>
				<p><a href="{{ url('/product/list') }}"><img src="{{url('home/wap/images/singleReading/ioc01.png')}}"></a>了解详情</p>
			</div>
        </div>
		<img src="{{url('home/wap/images/singleReading/singleReading_05.jpg')}}" class="am-img-responsive"  alt=""/>
		  <div class="twelve-txt">
    		<div id="twelve-03-txt01">
    		   <h4>PC端：</h4>
    		   <p>请进入官网（www.readingbar.net），登录完善信息后，选择<a href="{{ url('/product/list') }}" class="colored2c2d">产品</a>进行购买，未注册用户请先注册。</div>
			<div id="twelve-03-txt02">
		        <h4>手机端：</h4>
				<p>*在手机浏览器进入官网（www.readingbar.net），登录完善信息后，点击左上角菜单，选择<a href="{{ url('/product/list') }}" class="colored2c2d">产品</a>进行购买，未
				注册用户请先注册。</p>
				<p>*在官方微信（蕊丁英文阅读家），点击菜单《蕊丁官网》，登录完善信息后，点击左上角菜单选择<a href="{{ url('/product/list') }}" class="colored2c2d">产品</a>进行购买,
				未注册用户请先注册。</p>
			</div>
    	</div>
		<div class="am-figure am-figure-default" data-am-widget="figure"  data-am-figure="{  pureview: 'true' }">
		<img src="{{url('home/wap/images/singleReading/singleReading_07.jpg')}}" class="am-img-responsive" style="padding:0;margin:0;" alt=""/>
		</div>
	  </div>
	</div>
@endsection
<!-- //继承整体布局 -->

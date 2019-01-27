<!-- 继承整体布局 -->
@extends('front::mobile.common.main')

@section('content')
<link rel="stylesheet" type="text/css" href="{{url('home/pc/css/thanksgiving.css')}}">
<!-- 扩展内容-->
<article>
	<div class="container">
		<img src="{{url('home/wap/images/thanksgiving/gej_02.jpg')}}" class="am-img-responsive"  alt=""/>
	</div>
	<div class="am-figure am-figure-default" data-am-widget="figure"  data-am-figure="{  pureview: 'true' }" style="padding: 0 15px;margin-bottom: 20px;">
    	<img src="{{url('home/wap/images/thanksgiving/gej_05.jpg')}}" class="am-img-responsive"  alt=""/>
    	<img src="{{url('home/wap/images/thanksgiving/gej_08.jpg')}}" class="am-img-responsive"  alt=""/>
    	<img src="{{url('home/wap/images/thanksgiving/gej_11.jpg')}}" class="am-img-responsive"  alt=""/>
	</div>
</article>


<!-- //扩展内容-->
@endsection
<!-- //继承整体布局 -->

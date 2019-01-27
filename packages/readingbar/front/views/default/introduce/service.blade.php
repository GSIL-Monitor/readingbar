<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')
<!-- 扩展内容-->
	@include('front::default.common.banner')
    <!--/banner-->
    <div class="content bgf5f5f5">
      	<div class="container cont-about">
		    <img src="{{url('home/pc/images/Service.jpg')}}" class="mautoimg"></ins>
	     	<!--/-->
        </div>
    </div>
<!-- /content end -->
<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

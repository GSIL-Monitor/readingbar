<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')
<!-- 扩展内容-->
	<div class="banner">
       <img src="{{url('home/pc/images/banner/about_banner.png')}}">
    </div>
    <!--/banner-->
    <div class="content bgf5f5f5">
      	<div class="container cont-about">
		    <div class="content-titile">
		     	<h4>招聘信息</h4>
		     	<span>Recruitment Information</span>
		    </div>
	     	<!--/content-about-titile-->
	     	<h6 class="about-titile">职位需求:</h6>
       		<p class="about-xs"></p>
        </div>
    </div>
<!-- /content end -->
<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

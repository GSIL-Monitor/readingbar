
<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')

	
<!-- 包含会员菜单 -->
<!-- 扩展内容-->

<div class="container">
	<div class="row padt9">
	  <div class="col-md-2 home-column-fl">
	  	@include('front::default.member.memberMenu')
	  </div>
	  <!--/ home-column-fl end-->
	  <div class="col-md-10 hhome-column-fr100">
	             <ul class="nav nav-tabs">
						  <li role="presentation" class="active"><a href="#">完善信息</a></li>
					</ul>
					<div style="clear:both"></div>
					<div class="content mgl-40">
						<a href="{{url('member/messages/messagesBox')}}">收件箱</a>
<br>
<a href="{{url('member/messages/leaveMessage')}}">我要留言</a>
					</div>
				  </div>	
				</div>
				<!--/row end-->
			</div>
<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

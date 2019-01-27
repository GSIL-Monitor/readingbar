<!-- 继承整体布局 -->
@extends('front::mobile.common.main2l') @section('content')

<!-- 扩展内容-->

<section>

	<ul class="wap-user-sett">
		<li><a href="{{url('member/promotions/RDMessenger')}}">推广链接</a></li>
		<li><a href="javascript:alert('请用电脑查看！')">推广查询</a></li>
		<li><a href="{{ url('introduce/RDMessenger') }}">奖励计划</a></li>
	</ul>
</section>
<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

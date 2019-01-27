<!-- 继承整体布局 -->
@extends('front::mobile.common.main2l') @section('content')

<!-- 扩展内容-->

<section>

	<ul class="wap-user-sett">
		<li><a href="{{ url('member/baseinfoForm') }}">完善信息</a></li>
		<li><a href="{{ url('/member/password') }}">修改密码</a></li>
		<li><a href="{{ url('member/children/create') }}">添加孩子</a></li>
	</ul>
	<a href="{{ url('api/logout') }}" class="an102">退出登录</a>
</section>
<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

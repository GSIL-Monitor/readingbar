<header data-am-widget="header" class="am-header am-header-default">
    <div class="am-header-left am-header-nav">
	    <a href="/" class="header-nav-fl2">
	    	<i class="am-header-icon am-icon-angle-left am-icon-sm"></i>
	    </a>
	</div>
    <h1 class="am-header-title">我的</h1>
	<div class="am-header-right header-nav3 am-header-nav">
        
	        <!--!修改密码 个人资料修改-->
	        <a href="{{ url('/member/setting') }}" class="" style="    margin-top: 14px;"><i class="am-header-icon am-icon-gear"></i></a
	</div>
</header>   
<div class="container bg4bd3bf pab15">
    <img class="am-circle marg0_auto member-hread100" src="{{ auth('member')->member->avatar?url(auth('member')->member->avatar):url('files/avatar/guest.png') }}" width="140" height="140"/>
    <span class="nickname">{{auth('member')->member->nickname}}</span>
</div>

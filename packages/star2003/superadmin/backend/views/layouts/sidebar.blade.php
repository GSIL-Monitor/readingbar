<nav class="navbar-default navbar-static-side" role="navigation">
	<div class="sidebar-collapse">
		<ul class="nav metismenu" id="side-menu">
			<li class="nav-header">
				<div class="dropdown profile-element">
					<span> <img alt="image" class="img-circle" width="48px"
						height="48px"
						src="{{Auth::user()->avatar?url(Auth::user()->avatar):url('files/avatar/guest.png')}}" />
					</span> <a data-toggle="dropdown" class="dropdown-toggle" href="#">
						<span class="clear"> <span class="block m-t-xs"> <strong
								class="font-bold">{{$user['name']}}</strong>
						</span> <span class="text-muted text-xs block">{{ $role }}<b
								class="caret"></b></span>
					</span>
					</a>
					<ul class="dropdown-menu animated fadeInDown m-t-xs">
						<li><a href="{{url('admin/profile')}}">{{
								trans('common.text_profile') }}</a></li>
						<li class="divider"></li>
						<li><a href="{{url('admin/logout')}}">{{
								trans('common.text_logout') }}</a></li>
					</ul>
				</div>
				<div class="logo-element">SA+</div>
			</li> @foreach($sidebar as $key=>$m1)
			<li @if($key==0) class="active" @endif><a
				href="{{ $m1['url']!=''?url($m1['url']):'javascript:void(0);'}}"><i
					class="fa {{$m1['icon']}}"></i> <span class="nav-label">{{
						trans($m1['name'].'.top_menu_title') }}</span> <span
					class="fa arrow"></span></a> @if(count($m1['submenus']))
				<ul class="nav nav-second-level">
					@foreach($m1['submenus'] as $m2)
					<li><a
						href="{{ $m2['url']!=''?url($m2['url']):'javascript:void(0);'}}">{{
							trans($m2['name'].'.menu_title') }}</a>
						@if(count($m2['submenus']))
						<ul class="nav nav-third-level">
							@foreach($m2['submenus'] as $m3)
							<li><a
								href="{{ $m3['url']!=''?url($m3['url']):'javascript:void(0);'}}">{{
									trans($m3['name'].'.menu_title') }}</a></li> @endforeach
						</ul> @endif</li> @endforeach
				</ul> @endif</li> @endforeach
		</ul>
	</div>
</nav>
<script>
	$("#side-menu a").each(function(){
		if(window.location.href.indexOf($(this).attr('href'))==0){
			$(this).parents("li").addClass("active");
		};
	});
</script>
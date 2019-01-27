<header >
	<div class='header-main'>
		<div class='container '>
				<a href="{{ url('/') }}"><img class='header-logo' alt="logo" src="{{ asset('home/pc/images/header-logo.png') }}"></a>
					<ul class="nav nav-pills header-nav font-16">
  						<li role="presentation"><a href="{{ url('/')}}">首页</a></li>
  						<li role="presentation"><a href="{{ url('/#ARZ')}}">RAZ系统</a></li>
  						<li role="presentation" ><a  href="{{ url('/#AR')}}">AR系统</a></li>
  						<li role="presentation" ><a href="{{ url('/#US')}}" >联系我们</a></li>
						@if(auth('member')->isLoged())
		               	<div class="fr header-tx99">
		               		<div class="header-yhtx">
		               			<a href="{{ url('member') }}">
		               				<img src="{{ auth('member')->avatar() }}">
		               				<em ></em>
		               			</a>
		               		</div>
		               		<ul class="header-yhtx-nav">
		               			<li><a href="{{ url('member/children/create') }}">添加孩子</a></li>
		               			<li><a href="{{ url('member/baseinfo') }}">完善信息</a></li>
		               			<li><a href="{{ url('member/password') }}">修改密码</a></li>
		               			<li><a href="{{ url('member') }}">续费</a></li>
		               			<li><a href="{{ url('api/logout') }}">退出</a></li>
		               		</ul>
						</div>
						@else
						<li role="presentation" ><a href="{{ url('/member')}}" >个人中心</a></li>
		                @endif
					</ul>
					
					<script type="text/javascript">

					    $(".header-tx99").hover(function(){
					            $(".header-yhtx-nav").show();
					        },function(){
					            $(".header-yhtx-nav").hide();
					    });



						$(".dropdown-toggle").on("mouseover", function() {
						    if ($(this).parent().is(".open")) {
						        return
						    }
						    $(this).dropdown("toggle")
						}) 
						//
						
					</script>

					<script type="text/javascript">
							//设置当前头部菜单激活状态
							/**
							$(window).ready(function(){
								switch("{{ Request::getRequestUri() }}"){
									case "/":
										$(".header-nav  li").eq(0).addClass('current');break;
									case "/introduce/service_idea":
										$(".header-nav  li").eq(1).addClass('current');break;
									case "/product/detail/1":
									case "/product/detail/2":
									case "/product/detail/3":
									case "/product/detail/4":
										$(".header-nav  li").eq(2).addClass('current');break;
									case "/":
										$(".header-nav  li").eq(3).addClass('current');break;
								}
							});
							*/
		              </script>
		        </div>
	</div>
</header>
<div style='clear:both'></div>
    <!--/header-->
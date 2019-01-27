<header data-am-widget="header"  class="am-header am-header-local1">
      <div class="am-g tjj-header">
		  <div class="am-u-sm-5 ">
		  	<a href="{{ url('/') }}"><i class="tjj-header-line tjj-header-logo"></i></a>
		  </div>
		  <div class="am-u-sm-7 am-text-right">
		  	<div class="menu-box"><a href="{{ url('/') }}"><img alt="" src="{{url(asset('home/wap/images/home/icon/icon-home.png'))}}"/></a></div>
		  	<div class="menu-box">
		  		 @if(auth('member')->check())
			  	 	<a href="{{ url('/member') }}" ><img style="width: 30px;height:30px;border-radius:15px;" alt="" src="{{ auth('member')->member()->avatar?url(auth('member')->member()->avatar):asset('files/avatar/guest.png') }}"/></a>
			  	 @else
			  	 	<a href="{{ url('/login') }}" ><img alt="" src="{{url(asset('home/wap/images/home/icon/icon-user.png'))}}"/></a>
			  	 @endif
		  	</div>
		  	<div class="menu-box">
		  		<a href="javascript:void(0)"  v-on:click.stop="showMenu=!showMenu"><img alt="" src="{{url(asset('home/wap/images/home/icon/icon-menu.png'))}}"/></a>
		  		<div :class="showMenu?'open':'close'" >
		  	 		<div><a href="{{ url('/#raz') }}" >RAZ系统</a></div>
		  	 		<div><a href="{{ url('/#ra') }}" >AR系统</a></div>
		  	 		<div><a href="{{ url('/#us') }}" >联系我们</a></div>
		  	 	</div>
		  	</div>
		  </div>
	  </div>
</header>
  <script type="text/javascript">
		new Vue({
			el: 'header',
			data () {
				return {
					showMenu: false
				}
			},
			created: function () {
				this.clickCloseMenu()
			},
			methods: {
				// 监听点击事件-关闭头部菜单
				clickCloseMenu: function () {
					var _this = this
					 $(document).click(function(){
						 _this.showMenu = false
					 });
				}
			}
		})
  </script>
  <div style="clear:both"></div>
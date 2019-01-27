<!-- 整体布局 -->
<html>
	<head>
		<meta charset="utf-8">
  		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>{{ $head_title or '蕊丁吧'}}</title>
		<meta name="description" content="{{ $setting['description'] or '蕊丁吧'}}">
		<meta name="keywords" Content="{{ $setting['keywords'] or '蕊丁吧'}}">
		<meta name="viewport"content="width=device-width, initial-scale=1">
		<meta name="renderer" content="webkit"> 
		<meta http-equiv="Cache-Control" content="no-siteapp"/>
		<!--css-->
		<link rel="stylesheet" href="{{url('home/wap/css/amazeui.min.css')}}">
		<link rel="stylesheet" href="{{url('home/wap/css/app.css')}}">
		<link rel="stylesheet" href="{{url('home/wap/css/magic-input.css')}}">
		<!--js-->
		<script src="{{url('home/wap/js/jquery-2.1.1.js')}}"></script>
		<script type="text/javascript">
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': "{{ csrf_token() }}"
		    }
		});
		</script>
		<script src="{{url('home/wap/js/amazeui.js')}}"></script>
		<!--vuejs-->
		<script src="{{url('home/wap/js/vue/vue.min.js')}}"></script>
		<script type="text/javascript">
			//vuejs边界符修改
			Vue.config.delimiters = ['[[', ']]']; 
		</script>
		<script type="text/javascript">
		    //判断手机还是移动界面
			function browserRedirect() {
				var sUserAgent = navigator.userAgent.toLowerCase();
				var bIsIpad = sUserAgent.match(/ipad/i) == "ipad";
				var bIsIphoneOs = sUserAgent.match(/iphone os/i) == "iphone os";
				var bIsMidp = sUserAgent.match(/midp/i) == "midp";
				var bIsUc7 = sUserAgent.match(/rv:1.2.3.4/i) == "rv:1.2.3.4"; 
				var bIsUc = sUserAgent.match(/ucweb/i) == "ucweb";
				var bIsAndroid = sUserAgent.match(/android/i) == "android";
				var bIsCE = sUserAgent.match(/windows ce/i) == "windows ce"; 
				var bIsWM = sUserAgent.match(/windows mobile/i) == "windows mobile";
				if ((bIsIpad || bIsIphoneOs || bIsMidp || bIsUc7 || bIsUc || bIsAndroid || bIsCE || bIsWM) )
				{                      
					//window.location.href="{{url('/?theme=mobile')}}";
				}else{
					//window.location.href="{{ url('/?theme=default') }}";
				}             
			}             
			browserRedirect();
		</script>
		<!--/vuejs-->
	</head>
	<body>
		@include('front::mobile.common.amazeModal')
		<!-- 整体布局包含header -->
		@include('front::mobile.common.header2l')
		<!-- /整体布局包含header -->
		
		<!-- 整体布局被扩展 -->
		@yield('content') 
		<!-- /整体布局被扩展 -->
		
		<!-- 整体布局包含footer -->
	
		<!-- /整体布局包含footer -->
		@if(session('freeStarStuddent'))
			<!-- 免费评测孩子信息 -->
			@include('front::mobile.star.freeStarSelectChildModal')
		@endif
		<script type="text/javascript">
			@if(session('alert'))
				//接收消息提示
				amazeAlert({
					msg: "{{ session('alert') }}"
				});
			@endif
		</script>
	</body>
</html>
<!-- /整体布局 -->
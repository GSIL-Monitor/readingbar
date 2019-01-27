<!-- 整体布局 -->
<html>
	<head>
	    <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>{{ $head_title or '蕊丁吧'}}</title>
		<meta name="description" content="{{ $setting['description'] or '蕊丁吧'}}">
		<meta name="keywords" Content="{{ $setting['keywords'] or '蕊丁吧'}}">
        <meta name="author" content="">
        <!-- 百度站长验证  -->
        <meta name="baidu-site-verification" content="3i5fyO10zI" />
         <link rel="icon" href="{{ asset('logo.png')}}"  type="image/x-icon"/>
        <link rel="shortcut icon" href="">
        <link rel="stylesheet" type="text/css" href="{{url('home/pc/css/bootstrap.min.css')}}">
       
	    <script src="{{url('home/pc/js/jquery-2.1.1.js')}}"> </script>
		<script src="{{asset('assets/fromcdn/jquery-cookie/jquery.cookie.js')}}"></script>
	    <script type="text/javascript">
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': "{{ csrf_token() }}"
		    }
		});
		</script>
	    <script src="{{url('home/pc/js/bootstrap.js')}}"></script>
	    <!--vuejs-->
	    <script src="{{url('home/pc/js/vue/vue.min.js')}}"></script>
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
					window.location.href="{{url('/?theme=mobile')}}";
				}else{
					//window.location.href={{url('/?theme=default')}};
				}             
			}             
			browserRedirect();
		</script>
		<script src="{{asset('assets/fromcdn/jquery_lazyload/jquery.lazyload.min.js')}}"></script>
	    <!--/vuejs-->
	    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	      <script src="{{asset('assets/fromcdn/html5shiv/html5shiv.min.js')}}"></script>
	      <script src="{{asset('assets/fromcdn/respond/respond.min.js')}}"></script>
	    <![endif]-->
	    <!--my--> 
	    <script type="text/javascript">
		    $(function () {
		    	$('.propoer_hover_html').popover({
						trigger:'hover', //触发方式
						html: true, // 为true的话，data-content里就能放html代码了
			    });
		    	$('.propoer_hover_string').popover({
					trigger:'hover', //触发方式
					html: false, // 为true的话，data-content里就能放html代码了
		   		 });
		    	$('.propoer_click_html').popover({
					trigger:'click', //触发方式
					html: true, // 为true的话，data-content里就能放html代码了
		    	});
		    	$('.propoer_click_string').popover({
					trigger:'click', //触发方式
					html: false, // 为true的话，data-content里就能放html代码了
		   		 });
			});		
		</script>
	    <link rel="stylesheet" type="text/css" href="{{url('home/t-btns/btn.css')}}">
	    <link rel="stylesheet" type="text/css" href="{{url('home/pc/css/style.css')}}">
	    <script src="{{asset('assets/fromcdn/outdated-browser/outdatedbrowser.js')}}"></script>
		<link href="{{asset('assets/fromcdn/outdated-browser/outdatedbrowser.css')}}" rel="stylesheet">
	</head>
	
	<body>
		@include('front::default.common.jsConfirm')
		<!-- 整体布局包含header -->
		@include('front::default.common.header')
		<!-- /整体布局包含header -->
		
		<!-- 整体布局被扩展 -->
		@yield('content') 
		<!-- /整体布局被扩展 -->
		
		<!-- 整体布局包含footer -->	
		@include('front::default.common.footer')
		@include('front::default.common.fixed_message')
		<!-- /整体布局包含footer -->
		<script>
			//event listener: DOM ready
		function addLoadEvent(func) {
		    var oldonload = window.onload;
		    if (typeof window.onload != 'function') {
		        window.onload = func;
		    } else {
		        window.onload = function() {
		            if (oldonload) {
		                oldonload();
		            }
		            func();
		        }
		    }
		}
		//call plugin function after DOM ready
		addLoadEvent(function(){
		    outdatedBrowser({
		        bgColor: '#f25648',
		        color: '#ffffff',
		        lowerThan: 'borderImage'
		    })
		});
		</script>
	</body>
</html>
<!-- /整体布局 -->
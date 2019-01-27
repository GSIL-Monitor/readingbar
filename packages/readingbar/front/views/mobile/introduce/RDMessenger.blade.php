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
		<link rel="stylesheet" type="text/css" href="{{url('home/pc/css/Recommend.css')}}">
		<!--js-->
		<script src="{{url('home/wap/js/jquery-2.1.1.js')}}"></script>
		<script type="text/javascript" src="{{url('home/wap/js/jquery.SuperSlide.2.1.1.js')}}"></script>
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
					window.location.href="{{ url('/?theme=default') }}";
				}             
			}             
			browserRedirect();
		</script>
		<!--/vuejs-->
	</head>
	<body>
		<div class="am-g ht32 bg4bd2bf"></div>
		<!--<div class="am-g sztg-h4">“蕊丁使者”推广奖励计划</div>-->
		<div class="am-g" style="padding: 10px;">
			<img src="{{url('home/wap/images/2017/rdsz_03.jpg')}}" class="am-img-responsive" alt=""/>
		</div>
			@if(!auth('member')->checkRDMessenger())
			 	<a href="{{ url('member/promotions/becomPromoter')}}" class="rdAnge-link2">我要成为“蕊丁使者”</a>
			 	@else
			 	 <a href="{{ url('member')}}" class="rdAnge-link2">返回</a>
			 @endif
			
		</div>
	</body>
</html>
<!-- /整体布局 -->
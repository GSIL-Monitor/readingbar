<html>
	<head>
		<meta charset="utf-8">
  		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>礼品充值卡步骤</title>
		<meta name="description" content="{{ $setting['description'] or '蕊丁吧'}}">
		<meta name="keywords" Content="{{ $setting['keywords'] or '蕊丁吧'}}">
		<meta name="viewport"content="width=device-width, initial-scale=1">
		<meta name="renderer" content="webkit"> 
		<meta http-equiv="Cache-Control" content="no-siteapp"/>
		<link rel="stylesheet" href="{{url('home/wap/css/amazeui.min.css')}}">
		<script src="{{url('home/wap/js/jquery-2.1.1.js')}}"></script>
		<script src="{{url('home/wap/js/amazeui.js')}}"></script>
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
					//window.location.href="{{ url('giftCardProcess?theme=mobile') }}";
				}else{
					window.location.href="{{ url('giftCardProcess?theme=default') }}";
				}             
			}             
			browserRedirect();
		</script>
</head>


<body>
	<div class="giftCardProcess">
		<img src="{{url('home/wap/images/jhzc/jhzc_01.jpg')}}" class="am-img-responsive">
		<img src="{{url('home/wap/images/jhzc/jhzc_02.jpg')}}" class="am-img-responsive">
		<img src="{{url('home/wap/images/jhzc/jhzc_04.jpg')}}" class="am-img-responsive">
		<img src="{{url('home/wap/images/jhzc/jhzc_05.jpg')}}" class="am-img-responsive">
		<img src="{{url('home/wap/images/jhzc/jhzc_06.jpg')}}" class="am-img-responsive">
		<img src="{{url('home/wap/images/jhzc/jhzc_07.jpg')}}" class="am-img-responsive">
		<img src="{{url('home/wap/images/jhzc/jhzc_08.jpg')}}" class="am-img-responsive">
		<img src="{{url('home/wap/images/jhzc/jhzc_09.jpg')}}" class="am-img-responsive">
	</div>
</body>
</html>


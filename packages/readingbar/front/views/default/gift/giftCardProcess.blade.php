<html>
	<head>
	    <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>礼品充值卡步骤</title>
		<meta name="description" content="{{ $setting['description'] or '蕊丁吧'}}">
		<meta name="keywords" Content="{{ $setting['keywords'] or '蕊丁吧'}}">
        <meta name="author" content="">
        <link rel="stylesheet" type="text/css" href="{{url('home/pc/css/bootstrap.min.css')}}">
		<style type="text/css">
		img { border:none; }
		.giftCardProcess{width: 630px;margin: 0 auto; overflow: hidden;}
		</style>
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
					window.location.href="{{url('giftCardProcess?theme=mobile')}}";
				}else{
					//window.location.href="{{url('giftCardProcess?theme=default')}}";
				}             
			}             
			browserRedirect();
		</script>
	</head>


	<body>
		<div class="giftCardProcess">
			<img src="{{url('home/pc/images/jhzc/zc1_02.jpg')}}">
			<img src="{{url('home/pc/images/jhzc/zc1_04.jpg')}}">
			<img src="{{url('home/pc/images/jhzc/zc1_05.jpg')}}">
			<img src="{{url('home/pc/images/jhzc/zc1_06.jpg')}}">
			<img src="{{url('home/pc/images/jhzc/zc1_07.jpg')}}">
			<img src="{{url('home/pc/images/jhzc/zc1_08.jpg')}}">
		</div>
	</body>
</html>




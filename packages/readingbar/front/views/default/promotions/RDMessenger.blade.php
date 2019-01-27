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
        <link rel="shortcut icon" href="">
        <link rel="stylesheet" type="text/css" href="{{url('home/pc/css/bootstrap.min.css')}}">
	    <script src="{{url('home/pc/js/jquery-2.1.1.js')}}"> </script>
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
					window.location.href="{{url('member/promotions/RDMessenger?theme=mobile')}}";
				}else{
					//window.location.href={{url('/?theme=default')}};
				}             
			}             
			browserRedirect();
		</script>
	    <!--/vuejs-->
	    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
	    <![endif]-->
	    <!--my--> 
	    <link rel="stylesheet" type="text/css" href="{{url('home/pc/css/style.css')}}">
	    <link rel="stylesheet" type="text/css" href="{{url('home/pc/css/Recommend.css')}}">
	</head>
	
	<body style="background: #f5f5f5;">
		<div class="mon ht53 bg4bd2bf mesz">
			<span class="xlioc5">欢迎您成为“蕊丁使者”请保存好您的推广链接</span>
		</div>
		<div class="mon ht287 metittle">
			<img src="{{ url('home/pc/images/Recommend/Recommend_03.jpg') }}">
		</div>
		<div class="moninfo">
			<div class="moninfo-heard">
				<img src="{{ $member['avatar'] }}">
				<em></em>
			</div>
			<em class="moninfo-name">{{ $member['nickname'] }}</em>
			<p>全国首家K12英文分级阅读在线定制服务机构</p>
			<p>面向家庭提供完整的个性化英文阅读解决方案</p>
			<div class="moninfo-ew">
				<img src="{{ $member['promote_qrcode'] }}" id='qrcode'>
				<span><a href="{{ url('member/promotions/downloadqrcode') }}">二维码下载</a></span>
				
			    <script src="https://cdn.bootcss.com/clipboard.js/1.6.1/clipboard.js"></script>
				<script type="text/javascript">
					var clipboard = new Clipboard('.Clipboard', {
						    text: function(trigger) {
						        return "{{ $member['promote_url'] }}";
						    }
						});
						clipboard.on('success', function(e) {
						    alert('链接已复制！');
						});
						clipboard.on('error', function(e) {
						    alert('您的浏览器版本过低，不支持该功能！');
						});
				</script>
				<span><a href="javascript:void(0)"  class='Clipboard' >复制推广链接</a></span>
				<span>扫描二维码 加入我们</span>
				<a href="{{ url('member')}}" class="rdAnge-link2" style="width: 130px;">返回</a>
			</div> 
		</div>


	</body>
</html>

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
					window.location.href="{{url('/?theme=mobile')}}";
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
	
	<body>
		<div class="mon ht53 bg4bd2bf"></div>
		<div class="container">
			<h4 class="rdAnge-tittle">“蕊丁使者”推广奖励计划</h4>
			<div class="container cont-about4 bgffff" style="margin-top: 0;    margin-bottom: 25px;">
				<h1 class="rdAnge-h1 xlioc1">所有注册会员都可自愿成为“蕊丁使者”。</h1>
				
				<!--/product end-->
			</div>
            <!--/container-->
            <div class="container cont-about4 bgffff" style="margin-top: 0;    margin-bottom: 25px;">
				<h1 class="rdAnge-h1 xlioc2">
					每位“蕊丁使者”拥有独立的推广链接，可在【个人中心】查看推广数据。
				</h1>
			</div>
            <!--/container-->
            <div class="container cont-about4 bgffff" style="margin-top: 0;    margin-bottom: 25px;">
				<h1 class="rdAnge-h1 xlioc3">
					“蕊丁使者”成功推广会员后，将获赠不同价值的【推广奖励金】：
				</h1>
				<div class="product row">
					<div class="col-md-2 rdAnge-ioc2 fl"></div>
					<div class="col-md-9 product-cont fl">
						<p>推广一名定制服务会员，获得200元；（可购买定制服务、综合系统服务）
						<p>推广一名综合系统服务会员，获得35元；（可购买定制服务、综合系统服务）
						<p>推广一名书籍测试服务会员，获得25元；（可购买定制服务、综合系统服务、书籍测试服务）
						<p>推广一名阅读能力测评服务会员，获得10元；（可购买定制服务、综合系统服务、书籍测试服务、阅读能力测评服务）
						<p>【推广奖励金】有效期为365日。
						<p>注：借阅服务产品没有推广奖励金。</p>
						<b>此内容有效期：长期。</b>
					</div>
				</div>
				<!--/product end-->
			</div>
            <!--/container-->
            <div class="container cont-about4 bgffff" style="margin-top: 0;    margin-bottom: 25px;">
				<h1 class="rdAnge-h1 xlioc4">
					推广奖励金
				</h1>
				<div class="product row">
					<div class="col-md-2 rdAnge-ioc3 fl"></div>
					<div class="col-md-9 product-cont fl">
						<p>1、不兑换现金，不找零，不开发票。</p>
						<p>2、可转让给其下新会员使用，转让成功后不可撤销。</p>
						<p>3、给每一名新会员最多转让一张。</p>
						<p>4、仅限购买指定会员服务，可在有效期内累加使用。</p>
						<p>5、新会员购买定制服务后退费时，“蕊丁使者”获得的对应奖励金将作废。</p>
						<p>6、不可与团购以及其他渠道优惠同享。</p>
						<p>7、有效期为获得之日起1年。</p>

					</div>
				</div>
				<!--/product end-->
			</div>
            <!--/container-->
            @if(!auth('member')->checkRDMessenger())
            	<a href="{{ url('member/promotions/becomPromoter')}}" class="rdAnge-link">我要成为“蕊丁使者”</a>
			@else
				<a href="{{ url('member')}}" class="rdAnge-link">返回</a>
            @endif
		</div>

	</body>
</html>

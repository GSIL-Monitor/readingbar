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
					window.location.href="{{url('/?theme=default')}}";
				}             
			}             
			browserRedirect();
		</script>
		<!--/vuejs-->
	</head>
	<body  style="background: #f5f5f5;">
		<div class="am-g ht32 bg4bd2bf mesz">
			<span class="xlioc5-5">欢迎您成为“蕊丁使者”请保存好您的推广链接</span>
		</div>
		<div class="mon ht287 metittle">
			<img src="{{ url('home/pc/images/Recommend/Recommend_03-3_03.jpg') }}">
		</div>
		<div class="moninfo2">
			<div class="moninfo-heard2">
				<img src="{{ $member['avatar'] }}">
				
			</div>
			<em class="moninfo-name2">{{ $member['nickname'] }}</em>
			<p>全国首家K12英文分级阅读在线定制服务机构</p>
			<p>面向家庭提供完整的个性化英文阅读解决方案</p>
			<div class="moninfo-ew2">
				<img src="{{ $member['promote_qrcode'] }}">
				<span><a href="javascript:void(0)">长按二维码识别和保存为图片</a></span>
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
				</script>
				<span><a href="javascript:void(0)"  class='Clipboard' >复制推广链接</a></span>
				<span>扫描二维码 加入我们</span>
				<a href="{{ url('member')}}" class="rdAnge-link2" style="width: 130px;">返回</a>
			</div> 
		</div>
		<script>
//复制剪贴版函数
function copyToClipboard(maintext){
	  	if (window.clipboardData){
	    	window.clipboardData.setData("Text", maintext);
	    }else if (window.netscape){
		  	try{
		        netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
		    }catch(e){
		        alert("该浏览器不支持一键复制！请手工复制文本框链接地址～");
		        return;
		    }
		    var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
		    if (!clip) return;
		    var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
		    if (!trans) return;
		    trans.addDataFlavor('text/unicode');
		    var str = new Object();
		    var len = new Object();
		    var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
		    var copytext=maintext;
		    str.data=copytext;
		    trans.setTransferData("text/unicode",str,copytext.length*2);
		    var clipid=Components.interfaces.nsIClipboard;
		    if (!clip) return false;
		    clip.setData(trans,null,clipid.kGlobalClipboard);
	  }
	  alert("以下内容已经复制到剪贴板" + maintext);
}
</script>
<script type="text/javascript"> 
function savepic(href) { 
	if (document.all.a1 == null) { 
		objIframe = document.createElement("IFRAME"); 
		document.body.insertBefore(objIframe); 
		objIframe.outerHTML = "<iframe name=a1 style='width:400px;hieght:300px' src=" + "{{ $member['promote_qrcode'] }}" + "></iframe>"; 
		re = setTimeout("savepic()", 1) 
	} 
	else { 
	clearTimeout(re) 
		pic = window.open("{{ $member['promote_qrcode'] }}", "a1") 
		pic.document.execCommand("SaveAs") 
		document.all.a1.removeNode(true) 
	} 
} 
</script> 
	</body>
</html>
<!-- /整体布局 -->
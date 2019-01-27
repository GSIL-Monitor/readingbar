@if ($bought_times)
    亲爱的家长，<br>
    感谢您继续选择我们的服务，让我们继续相亲相爱吧！<br>
	下面是您的账号信息：<br>
	孩子：<font style="color:blue">{{$student}}</font> 账号：<font style="color:blue">{{$star_account}}</font> 密码： <font style="color:blue">{{$star_password}}</font><br>
	<strong>（*若此账号与您之前使用的账号一致，请忽略此密码，继续延用之前的密码！）</strong><br>
	此账号将于<font style="color:blue">{{$expirated}}</font>失效，请您在有效期前完成测评。<br>
	使用测试系统前，请您仔细阅读蕊丁吧《官网首页》或《微信公众号菜单》中的【测评系统使用指南】。<br>
	完成STAR测试后，一个工作日将提供中英文报告和推荐书单，届时会有手机短信提醒，请注意查收。<br>
	蕊丁吧将和您一起见证孩子的成长，感谢您的使用！ <br>
	<br>
	 蕊丁吧<br>
	官网：<a href='https://www.readingbar.net'>www.readingbar.net</a><br>
	客服热线：400 625 9800<br>
	  扫描二维码，添加官微<br>
	<img src='{{ url("files/index_qrcode.jpg") }}' style="width:150px">
@else
    亲爱的家长，<br>
    您好！<br>
	感谢您使用蕊丁吧提供的专业英文分级阅读测试系统服务。<br>
	下面是您的账号信息：<br>
	孩子：<font style="color:blue">{{$student}}</font> 账号：<font style="color:blue">{{$star_account}}</font> 密码： <font style="color:blue">{{$star_password}}</font><br>
	此账号将于<font style="color:blue">{{$expirated}}</font>失效，请您在有效期前完成测评。<br>
	使用测试系统前，请您仔细阅读蕊丁吧《官网首页》或《微信公众号菜单》中的【测评系统使用指南】。<br>
	完成STAR测试后，一个工作日将提供中英文报告和推荐书单，届时会有手机短信提醒，请注意查收。<br>
	蕊丁吧将和您一起见证孩子的成长，感谢您的使用！ <br>
	<br>
	 蕊丁吧<br>
	官网：<a href='https://www.readingbar.net'>www.readingbar.net</a><br>
	客服热线：400 625 9800<br>
	  扫描二维码，添加官微<br>
	<img src='{{ url("files/index_qrcode.jpg") }}' style="width:150px">
@endif



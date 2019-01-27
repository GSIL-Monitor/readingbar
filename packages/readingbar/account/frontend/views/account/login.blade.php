<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
@if(isset($member))
	{{ $member }}
	<a href="{{ url('account/logout') }}">logout</a>
	<a href="{{ url('member') }}">member</a>
@else
账号密码登录
<form class="form-horizontal" method="POST" action="{{ url('account/login') }}">
    {!! csrf_field() !!}
	{{ method_field('POST') }}
	<input type="text" name="account">
	<input type="password" name="password">
	@if ($errors->has('login'))
			<span class="help-block m-b-none">
				<strong>{{ $errors->first('login') }}</strong>
			</span>
	@endif
	<button>一般登录</button>
</form>
消息验证登录
<form class="form-horizontal" method="POST" action="{{ url('account/login') }}">
    {!! csrf_field() !!}
	{{ method_field('POST') }}
	<input type="text" name="account">
	<input type="text" name="logincode">
	@if ($errors->has('login'))
		<span class="help-block m-b-none">
			<strong>{{ $errors->first('login') }}</strong>
		</span>
	@endif
	<a id="btnSendMessage">发送消息</a>
	<button>消息验证登录</button>
</form>
<a href="{{ url('account/forgoten') }}">forgoten</a>
<a href="{{ url('account/register') }}">register</a>
<script>
	$("#btnSendMessage").click(function(){
		$.ajax({
			url:"/account/sendLoginMessage",
			data:$(this).parent('form').serialize(),
			type:"POST",
			dataType:'json',
			success:function(json){
				alert(json.msg);
			}
		});
	});
</script>
@endif
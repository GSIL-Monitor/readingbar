
	<form class="form-horizontal" method="POST" action="{{ url('account/register') }}">
	    {!! csrf_field() !!}
		{{ method_field('POST') }}
		昵称<input type="text" name="nickname">
		@if ($errors->has('nickname'))
			<span class="help-block m-b-none">
				<strong>{{ $errors->first('nickname') }}</strong>
			</span>
		@endif
		<br>
		密码<input type="text" name="password">
		@if ($errors->has('password'))
			<span class="help-block m-b-none">
				<strong>{{ $errors->first('password') }}</strong>
			</span>
		@endif
		<br>
		重复密码<input type="text" name="password_confirmation">
		<br>
		<input type="text" name="step" value="{{$step}}">
		<br>
		<button>提交</button>
	</form>

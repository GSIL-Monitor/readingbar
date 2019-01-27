
	<form class="form-horizontal" method="POST" action="{{ url('account/register') }}">
	    {!! csrf_field() !!}
		{{ method_field('POST') }}
		验证码<input type="text" name="code">
		<input type="text" name="step" value="{{$step}}">
		@if ($errors->has('code'))
			<span class="help-block m-b-none">
				<strong>{{ $errors->first('code') }}</strong>
			</span>
		@endif
		<button>提交</button>
	</form>

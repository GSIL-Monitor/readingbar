
	<form class="form-horizontal" method="POST" action="{{ url('account/register') }}">
	    {!! csrf_field() !!}
		{{ method_field('POST') }}
		用户名<input type="text" name="account">
		@if ($errors->has('account'))
			<span class="help-block m-b-none">
				<strong>{{ $errors->first('account') }}</strong>
			</span>
		@endif
		<input type="text" name="step" value="{{$step}}">
		<button>提交</button>
	</form>
	
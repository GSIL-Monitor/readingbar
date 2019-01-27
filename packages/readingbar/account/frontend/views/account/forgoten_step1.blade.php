<form class="form-horizontal" method="POST" action="{{ url('account/forgoten') }}">
    {!! csrf_field() !!}
	{{ method_field('POST') }}
	<input type="text" name="account">
	@if ($errors->has('account') || $errors->has('cellphone') || $errors->has('email'))
			<span class="help-block m-b-none">
				<strong>
				@if ($errors->has('account'))
					{{ $errors->first('account') }}
				@endif
				@if ($errors->has('cellphone'))
					{{ $errors->first('cellphone') }}
				@endif
				@if ($errors->has('email'))
					{{ $errors->first('email') }}
				@endif
				</strong>
			</span>
	@endif
	<input type="radio" name="find_way" checked="cheched" value="message">消息找回<input type="radio" name="find_way" value="qa">问题找回
	<input type="text" name="step" value="{{$step}}">
	<button>提交</button>
</form>
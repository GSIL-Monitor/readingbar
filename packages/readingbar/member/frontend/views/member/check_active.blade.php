	<form class="form-horizontal" method="POST" action="{{ url('member/active') }}">
	    {!! csrf_field() !!}
		{{ method_field('POST') }}
		激活码<input type="text" name="active_code">
		@if ($errors->has('active_code'))
			<span class="help-block m-b-none">
				<strong>{{ $errors->first('active_code') }}</strong>
			</span>
		@endif
		<button>提交</button>
	</form>
	<a href="{{ url('member/send_active') }}">重新发送激活码</a>
	
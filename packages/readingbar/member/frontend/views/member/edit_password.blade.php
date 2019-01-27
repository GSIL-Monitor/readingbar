	<form class="form-horizontal" method="POST" action="{{ url('member/edit') }}">
	    {!! csrf_field() !!}
		{{ method_field('POST') }}
		密码<input type="text" name="password" value="">
		@if ($errors->has('password'))
			<span class="help-block m-b-none">
				<strong>{{ $errors->first('password') }}</strong>
			</span>
		@endif
		重复密码<input type="text" name="password_confirmation" value="">
		
		<input type="text" name="edit_type" value="{{$edit_type}}">
		<button>提交</button>
	</form>
	
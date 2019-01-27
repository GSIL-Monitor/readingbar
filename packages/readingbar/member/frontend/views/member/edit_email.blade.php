	<form class="form-horizontal" method="POST" action="{{ url('member/edit') }}">
	    {!! csrf_field() !!}
		{{ method_field('POST') }}
		email<input type="text" name="email" value="{{ $member->email }}">
		@if ($errors->has('email'))
			<span class="help-block m-b-none">
				<strong>{{ $errors->first('email') }}</strong>
			</span>
		@endif
		<input type="text" name="edit_type" value="{{$edit_type}}">
		<button>提交</button>
	</form>
	
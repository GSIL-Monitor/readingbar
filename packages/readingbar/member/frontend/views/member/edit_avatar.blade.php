	<form class="form-horizontal" method="POST" action="{{ url('member/edit') }}">
	    {!! csrf_field() !!}
		{{ method_field('POST') }}
		头像<input type="text" name="avatar" value="{{ $member->avatar }}">
		@if ($errors->has('avatar'))
			<span class="help-block m-b-none">
				<strong>{{ $errors->first('avatar') }}</strong>
			</span>
		@endif
		<input type="text" name="edit_type" value="{{$edit_type}}">
		<button>提交</button>
	</form>
	
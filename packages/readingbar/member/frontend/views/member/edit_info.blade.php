	<form class="form-horizontal" method="POST" action="{{ url('member/edit') }}">
	    {!! csrf_field() !!}
		{{ method_field('POST') }}
		昵称<input type="text" name="nickname" value="{{ $member->nickname }}">
		@if ($errors->has('nickname'))
			<span class="help-block m-b-none">
				<strong>{{ $errors->first('nickname') }}</strong>
			</span>
		@endif
		<input type="text" name="edit_type" value="{{$edit_type}}">
		<button>提交</button>
	</form>
	
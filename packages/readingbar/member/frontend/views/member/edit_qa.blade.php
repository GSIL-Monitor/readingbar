	<form class="form-horizontal" method="POST" action="{{ url('member/edit') }}">
	    {!! csrf_field() !!}
		{{ method_field('POST') }}
		问题<input type="text" name="question" value="{{$member->question}}">
		@if ($errors->has('question'))
			<span class="help-block m-b-none">
				<strong>{{ $errors->first('question') }}</strong>
			</span>
		@endif
		答案<input type="text" name="answer" value="{{$member->answer}}">
		@if ($errors->has('answer'))
			<span class="help-block m-b-none">
				<strong>{{ $errors->first('answer') }}</strong>
			</span>
		@endif
		<input type="text" name="edit_type" value="{{$edit_type}}">
		<button>提交</button>
	</form>
	
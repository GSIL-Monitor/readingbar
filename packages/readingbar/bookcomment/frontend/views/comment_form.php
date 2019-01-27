<form class="form-horizontal" method="POST" action="{{ url('member/edit') }}">
    {!! csrf_field() !!}
	{{ method_field('POST') }}
	comment<textarea type="text" name="comment" value="{{ $comment->comment }}">
	@if ($errors->has('email'))
		<span class="help-block m-b-none">
			<strong>{{ $errors->first('email') }}</strong>
		</span>
	@endif
	<button>提交</button>
</form>
	
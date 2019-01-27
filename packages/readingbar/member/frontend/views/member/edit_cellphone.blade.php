	<form class="form-horizontal" method="POST" action="{{ url('member/edit') }}">
	    {!! csrf_field() !!}
		{{ method_field('POST') }}
		电话号码<input type="text" name="cellphone" value="{{ $member->cellphone }}">
		@if ($errors->has('cellphone'))
			<span class="help-block m-b-none">
				<strong>{{ $errors->first('cellphone') }}</strong>
			</span>
		@endif
		<input type="text" name="edit_type" value="{{$edit_type}}">
		<button>提交</button>
	</form>
	
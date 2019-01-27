@if ($find_way=='message')
	<form class="form-horizontal" method="POST" action="{{ url('account/forgoten') }}">
	    {!! csrf_field() !!}
		{{ method_field('POST') }}
		验证码<input type="text" name="code">
		@if ($errors->has('code'))
			<span class="help-block m-b-none">
				<strong>{{ $errors->first('code') }}</strong>
			</span>
		@endif
		<input type="text" name="step" value="{{$step}}">
		<button>提交</button>
	</form>
@elseif($find_way=='qa')
	<form class="form-horizontal" method="POST" action="{{ url('account/forgoten') }}">
	    {!! csrf_field() !!}
		{{ method_field('POST') }}
		问题:<p>{{$question}}</p>
		答案:<input type="text" name="answer">
		@if ($errors->has('answer'))
			<span class="help-block m-b-none">
				<strong>{{ $errors->first('answer') }}</strong>
			</span>
		@endif
		<input type="text" name="step" value="{{$step}}">
		<button>提交</button>
	</form>
@endif	
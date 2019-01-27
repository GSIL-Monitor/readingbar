	<form class="form-horizontal" method="POST" action="{{ url('member/student/survey').'/'.$survey->survey_id }}">
	    {!! csrf_field() !!}
		{{ method_field('POST') }}
		question:{{$survey->question}}<br>
		@if ($errors->has('answer'))
			<span class="help-block m-b-none">
				<strong>{{ $errors->first('answer') }}</strong>
			</span>
			<br>
		@endif
		@if($survey->answer_type==1)
			@for($i=1;$i<=10;$i++)
				@if($survey['option'.$i]!='')
					<input type="radio" value="{{$i}}" name="option">{{ $survey['option'.$i] }}<br>
				@endif
			@endfor
		@elseif($survey->answer_type==2)
			@for($i=1;$i<=10;$i++)
				@if($survey['option'.$i]!='')
					<input type="checkbox" value="{{$i}}" name="option[]">{!! str_replace('[input]','<input type="text" style="border:0;border-bottom:1px solid black" name="answer'.$i.'">',$survey['option'.$i]) !!}<br>
				@endif
			@endfor
		@elseif($survey->answer_type==3)
			<input type="text" name="answer">
		@endif
		<button>提交</button>
	</form>
	
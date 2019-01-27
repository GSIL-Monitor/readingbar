
	<form class="form-horizontal" method="POST" action="{{ url('account/register') }}">
	    {!! csrf_field() !!}
		{{ method_field('POST') }}
		许可协议<input type="checkbox" name="license">
		<input type="text" name="step" value="{{$step}}">
		<button>提交</button>
	</form>

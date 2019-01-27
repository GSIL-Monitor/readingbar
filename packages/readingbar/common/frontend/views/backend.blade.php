<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="_token" content="{{ csrf_token() }}"/>
    <title>{{$head_title or trans('common.backend')}}</title>
    <link href="{{ asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <script src="{{ asset('assets/js/jquery-2.1.1.js')}}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript">
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
	</script>
    <script src="{{ asset('assets/js/plugins/vue/vue.min.js')}}"></script>
    <script type="text/javascript">
		Vue.config.delimiters = ['[[', ']]']; 
	</script>
</head>
<body>
	@include('Readingbar/common/frontend::header')
    <div id="wrapper">
        @yield('content')
    </div>
    @include('Readingbar/common/frontend::footer')
</body>
</html>

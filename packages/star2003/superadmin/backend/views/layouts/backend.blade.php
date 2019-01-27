<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="_token" content="{{ csrf_token() }}"/>
    <title>{{$head_title or trans('common.backend')}}</title>

    <link href="{{ asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/css/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/css/animate.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/css/plugins/summernote/summernote.css')}}" rel="stylesheet">
	<link href="{{ asset('assets/css/style.css')}}" rel="stylesheet">
	<link href="{{ asset('assets/css/reset.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/css/plugins/jsTree/style.min.css')}}" rel="stylesheet">
	<link href="{{ asset('assets/css/animate.css')}}" rel="stylesheet">
	<link href="{{ asset('assets/css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">
	<link href="{{ asset('assets/css/plugins/daterangepicker/daterangepicker-bs3.css')}}" rel="stylesheet">
    <!-- Mainly scripts -->
    
    <script type="text/javascript" src="{{ asset('assets/js/jquery-2.1.1.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/plugins/daterangepicker/daterangepicker.js')}}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/plugins/jqForm/jQuery.form.js') }}"></script>
	
	<script type="text/javascript" >
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': "{{ csrf_token() }}"
		    }
		});
	</script>
    <!-- Custom and plugin javascript -->
    <script type="text/javascript" src="{{ asset('assets/js/inspinia.js')}}"></script>
    <!-- iCheck -->
    <script type="text/javascript" src="{{ asset('assets/js/plugins/iCheck/icheck.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>
   

    <script type="text/javascript" src="{{ asset('assets/js/plugins/vue/vue.min.js')}}"></script>
    <script type="text/javascript">
		Vue.config.delimiters = ['[[', ']]']; 
		
	</script>
</head>

<body>
	@include('superadmin/backend::common.modal')
    <div id="wrapper">
        @include('superadmin/backend::layouts.sidebar')

        <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
        @include('superadmin/backend::layouts.header')
        </div>
        @yield('content')        
		@include('superadmin/backend::layouts.footer')
        </div>
         <!-- 
        @include('superadmin/backend::layouts.smallchat')
         -->
         
        @include('superadmin/backend::layouts.rightsidebar')
    </div>
    @include('filemanage/backend::footer_filemanage')
</body>
</html>

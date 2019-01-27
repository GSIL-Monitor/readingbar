@extends('superadmin/backend::layouts.backend')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
  welcome here !
  <script type="text/javascript">
		role={{ Auth::user()->role }};
		switch(role){
			case 1:var url="{{url('admin/superadmin')}}";break;
			case 2:var url="{{url('admin/instructor')}}";break;
			case 3:var url="{{url('admin/teacher')}}";break;
			case 4:var url="{{url('admin/bookmanager')}}";break;
		}
		if(url){
			window.location.href=url;
		}
  </script>
</div>     
@endsection
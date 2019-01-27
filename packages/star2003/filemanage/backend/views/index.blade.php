@extends('superadmin/backend::layouts.backend')

@section('content')
<link href="{{ asset('assets/css/plugins/jsTree/style.min.css')}}" rel="stylesheet">
<link href="{{ asset('assets/css/animate.css')}}" rel="stylesheet">
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>{{ $head_title or 'form' }}</h2>
                    <ol class="breadcrumb">
                    	@foreach($breadcrumbs as $b)
                        <li>
                        	@if($b['active'])
                            	<strong class="active">{{ trans('menu.'.$b['name']) }}</strong>
                        	@else
                        		<a href="{{$b['url']!=''?url($b['url']):'javascript:void(0);'}}">{{ trans('menu.'.$b['name']) }}</a>
                        	@endif
                        </li>
                        @endforeach
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
<div class="wrapper wrapper-content animated fadeInRight" id="loadFilemanage">
	@include('filemanage/backend::filemanage')
</div>  
@endsection
@extends('superadmin/backend::layouts.backend')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>{{ $head_title or 'List' }}</h2>
                    <ol class="breadcrumb">
                    	@foreach($breadcrumbs as $b)
                        <li>
                        	@if($b['active'])
                            	<strong class="active">{{ trans($b['name']) }}</strong>
                        	@else
                        		<a href="{{$b['url']!=''?url($b['url']):'javascript:void(0);'}}">{{ trans($b['name']) }}</a>
                        	@endif
                        </li>
                        @endforeach
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
 <div class="wrapper wrapper-content animated fadeInRight">
 	<div class="col-lg-3">
 				<a href="{{ url('admin/lendBook') }}">
	                <div class="widget style1 navy-bg">
	                    <div class="row">
	                        <div class="col-xs-4">
	                            <i class="fa fa-users fa-5x"></i>
	                        </div>
	                        <div class="col-xs-8 text-right">
	                            <span> {{ trans('bookmanager.untreated') }} </span>
	                            <h2 class="font-bold">{{ $untreated }}</h2>
	                        </div>
	                    </div>
	                </div>
                </a>
            </div>
            <div class="col-lg-3">
            	<a href="{{ url('admin/recoveryBook') }}">
	                <div class="widget style1 lazur-bg">
	                    <div class="row">
	                        <div class="col-xs-4">
	                            <i class="fa fa-clipboard fa-5x"></i>
	                        </div>
	                        <div class="col-xs-8 text-right">
	                            <span> {{ trans('bookmanager.toBeRecycled') }} </span>
	                            <h2 class="font-bold">{{ $toBeRecycled }}</h2>
	                        </div>
	                    </div>
	                </div>
	             </a>
            </div>
</div>
@endsection



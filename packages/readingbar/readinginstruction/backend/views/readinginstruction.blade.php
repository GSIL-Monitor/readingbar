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
 <div class="row">
            
            <div class="col-lg-3">
                <div class="widget style1 navy-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-users fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span> {{ trans('readinginstruction.unasignedStudents') }} </span>
                            <h2 class="font-bold">{{ $unasignedStudents }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="widget style1 lazur-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-clipboard fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span> {{ trans('readinginstruction.unfinishedApplies') }} </span>
                            <h2 class="font-bold">{{ $unfinishedApplies }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="widget style1 yellow-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-envelope-o fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span> {{ trans('readinginstruction.unansweredMessages') }} </span>
                            <h2 class="font-bold"> {{ $unansweredMessages }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="widget style1 blue-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-comments fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span> {{ trans('readinginstruction.untreatedComments') }} </span>
                            <h2 class="font-bold"> {{ $untreatedComments }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection



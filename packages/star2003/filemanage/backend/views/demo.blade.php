@extends('superadmin/backend::layouts.backend')

@section('content')

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
	<button class='file-set' for-input="input1" for-img="img1">test1</button>
	<input type="text" id="input1">
	<img alt="" src="" id="img1">
	<br>
	test2<input class='file-set' for-img="img2">
	<img alt="" src="" id="img2">
	<br>
	<img class='file-set' for-input="input3" alt="test3" src=''>
	<input type="text" id="input3">
	<br>
	needType test <img class='file-set' for-input="input4" alt="test4" src='' needType="image">
	<input type="text" id="input4">
</div>  
@endsection
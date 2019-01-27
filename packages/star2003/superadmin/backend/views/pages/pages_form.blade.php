@extends('superadmin/backend::layouts.backend')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>{{ $head_title or 'form' }}</h2>
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
	<div class="ibox-content">
	  <div class="row">
	    <div class="col-sm-12">
	      <h3 class="m-t-none m-b">{{ trans('pages.text_edit_file')}}</h3>
	      <form role="form" action="{{url('admin/pages/operations?operation=save_file')}}" method="post">
	        {!! csrf_field() !!}
			<input type="hidden" value="{{$direct}}" name="direct">
	        <div class="form-group">
	          <textarea rows="" cols="" style="height:400px" name='content' class="form-control">{{$content}}</textarea>
	        </div>
	        <div>
	          <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit">
	            <strong>save</strong></button>
	          <label>
	        </div>
	      </form>
	    </div>
	  </div>
	</div>
</div>     
@endsection
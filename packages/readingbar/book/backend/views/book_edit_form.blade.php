@extends('superadmin/backend::layouts.backend')

@section('content')
<link href="{{ asset('assets/css/plugins/summernote/summernote.css')}}" rel="stylesheet">
<link href="{{ asset('assets/css/plugins/summernote/summernote-bs3.css')}}" rel="stylesheet">
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

   <div class="wrapper wrapper-content animated fadeInRight ecommerce">
   		 <div class="row">
			  <div class="col-lg-12">
			    <div class="tabs-container">
			      <ul class="nav nav-tabs">
			        <li class="active">
			          <a data-toggle="tab" href="#tab-1">Book</a></li>
			        <li class="">
			          <a data-toggle="tab" href="#tab-2">Attach</a></li>
			        <li class="">
			          <a data-toggle="tab" href="#tab-3">Book Storage</a></li>
			      </ul>
			     <form class="form-horizontal" method="POST" action="{{ url($action) }}" enctype="multipart/form-data">
                    {!! csrf_field() !!}
					{{ method_field($method) }}
			      <div class="tab-content">
			        <div id="tab-1" class="tab-pane active">     
			          <div class="panel-body">
			            <fieldset class="form-horizontal">
			              @include("Readingbar/book/backend::books_form")
			            </fieldset>
			          </div>
			        </div>
			        <div id="tab-2" class="tab-pane">
			          <div class="panel-body">
			          	<fieldset class="form-horizontal">
			             	@include("Readingbar/book/backend::book_attach_form")
			            </fieldset>
			          </div>
			        </div>
			        <div id="tab-3" class="tab-pane">
			          <div class="panel-body">
			            <fieldset class="form-horizontal">
			              @include("Readingbar/book/backend::book_storage_form")
			            </fieldset>
			          </div>
			        </div>
			        <div class="panel-body">
				        <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" href="{{url('admin/books')}}"> <i class="fa fa-undo"></i>   Cancel</a>
                                        <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i>   Save</button>
                                    </div>
                                </div>
			        </div>
			       </form>
			      </div>
			    </div>
			  </div>
			</div>
   </div>     
<script src="{{ asset('assets/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
<script src="{{ asset('assets/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('assets/js/inspinia.js')}}"></script>
<script src="{{ asset('assets/js/plugins/pace/pace.min.js')}}"></script>

<!-- SUMMERNOTE -->
<script src="{{ asset('assets/js/plugins/summernote/summernote.min.js')}}"></script>

<!-- Data picker -->
<script src="{{ asset('assets/js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>

<script>
    $(document).ready(function(){

        $('.summernote').summernote();

        $('.input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });

    });
</script>
@endsection
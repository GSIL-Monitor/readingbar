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
              <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5><i class="fa fa-file-text-o"></i>  {{ trans('book_comment.form_title') }}</h5>
                           
                        </div>
                        <div class="ibox-content">
                            <form class="form-horizontal" method="POST" action="{{ url($action) }}">
                                {!! csrf_field() !!}
								{{ method_field($method) }}
								@if(isset($book_comment['id']))
									<input type="hidden" name="id" value="{{ $book_comment['id'] or '' }}"><br>
								@endif
								
                                <div class="form-group {{ $errors->has('ISBN')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('book_comment.column_ISBN') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="ISBN" value="{{ $book_comment['ISBN'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('ISBN'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('ISBN') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
	   				
                                <div class="form-group {{ $errors->has('commented_by')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('book_comment.column_commented_by') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="commented_by" value="{{ $book_comment['commented_by'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('commented_by'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('commented_by') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
	   				
                                <div class="form-group {{ $errors->has('comment')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('book_comment.column_comment') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="comment" value="{{ $book_comment['comment'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('comment'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('comment') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
	   				
                                <div class="form-group {{ $errors->has('status')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('book_comment.column_status') }}</label>
                                    <div class="col-sm-10">
                                    <select class="form-control" name="status">
                                    	<option value="0" >{{trans('book_comment.comment_status_0')}}</option>
                                    	<option value="1" {{ isset($book_comment['status']) && $book_comment['status']==1?"selected=selected":"" }}>{{trans('book_comment.comment_status_1')}}</option>
                                    </select>
	                                 
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
	   				
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a href="{{url('admin/book_comment')}}" class="btn btn-white"><i class="fa fa-undo"></i>   {{ trans('common.cancel') }}</a>
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>   {{ trans('common.save') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>     
@endsection

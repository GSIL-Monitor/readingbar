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
                            <h5><i class="fa fa-file-text-o"></i>  {{ trans('menu.form_title') }} </h5>
                            
                        </div>
                        <div class="ibox-content">
                            <form class="form-horizontal" method="POST" action="{{ url($action) }}">
                                {!! csrf_field() !!}
								{{ method_field($method) }}
								@if(isset($menu['id']))
									<input type="hidden" name="id" value="{{ $menu['id'] or '' }}"><br>
								@endif
                                <div class="form-group {{ $errors->has('name')?'has-error':''}}"><label class="col-sm-2 control-label">{{trans("menu.column_name")}}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="name" value="{{ $menu['name'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('name'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('name') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group {{ $errors->has('pre_id')?'has-error':''}}">
                                	<label class="col-sm-2 control-label">{{trans("menu.column_pre_id")}}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="pre_id" value="{{ $menu['pre_id'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('pre_id'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('pre_id') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group {{ $errors->has('rank')?'has-error':''}}">
                                	<label class="col-sm-2 control-label">{{trans("menu.column_rank")}}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="rank" value="{{ $menu['rank'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('rank'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('rank') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group {{ $errors->has('access')?'has-error':''}}">
                                    <label class="col-sm-2 control-label">{{trans("menu.column_access")}}</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="access" value="{{ $menu['access'] or '' }}" class="form-control"> 
                                        @if ($errors->has('access'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('access') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group {{ $errors->has('url')?'has-error':''}}">
                                    <label class="col-sm-2 control-label">{{trans("menu.column_url")}}</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="url" value="{{ $menu['url'] or '' }}" class="form-control"> 
                                        @if ($errors->has('url'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('url') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group {{ $errors->has('status')?'has-error':''}}">
                                    <label class="col-sm-2 control-label">{{trans("menu.column_status")}}</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="status" value="{{ $menu['status'] or '' }}" class="form-control"> 
                                        @if ($errors->has('status'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('status') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group {{ $errors->has('display')?'has-error':''}}">
                                    <label class="col-sm-2 control-label">{{trans("menu.column_display")}}</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="display" value="{{ $menu['display'] or '' }}" class="form-control"> 
                                        @if ($errors->has('display'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('display') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group {{ $errors->has('icon')?'has-error':''}}">
                                    <label class="col-sm-2 control-label">{{trans("menu.column_icon")}}</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="icon" value="{{ $menu['icon'] or '' }}" class="form-control"> 
                                        @if ($errors->has('icon'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('icon') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a onclick="history.back()" class="btn btn-white"><i class="fa fa-undo"></i>   {{trans("common.cancel")}}</a>
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>   {{trans("common.save")}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>     
@endsection

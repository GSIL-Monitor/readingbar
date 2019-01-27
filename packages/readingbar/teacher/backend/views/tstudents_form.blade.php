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
                            <h5><i class="fa fa-file-text-o"></i>  {{ trans('tstudents.form_title') }}</h5>
                           
                        </div>
                        <div class="ibox-content">
                            <form class="form-horizontal" method="POST" action="{{ url($action) }}">
                                {!! csrf_field() !!}
								{{ method_field($method) }}
								@if(isset($tstudents['id']))
									<input type="hidden" name="id" value="{{ $tstudents['id'] or '' }}"><br>
								@endif
								
                                <div class="form-group {{ $errors->has('parent_id')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('tstudents.column_parent_id') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="parent_id" value="{{ $tstudents['parent_id'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('parent_id'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('parent_id') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
	   				
                                <div class="form-group {{ $errors->has('name')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('tstudents.column_name') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="name" value="{{ $tstudents['name'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('name'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('name') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
	   				
                                <div class="form-group {{ $errors->has('nick_name')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('tstudents.column_nick_name') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="nick_name" value="{{ $tstudents['nick_name'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('nick_name'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('nick_name') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
	   				
                                <div class="form-group {{ $errors->has('avatar')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('tstudents.column_avatar') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="avatar" value="{{ $tstudents['avatar'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('avatar'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('avatar') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
	   				
                                <div class="form-group {{ $errors->has('dob')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('tstudents.column_dob') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="dob" value="{{ $tstudents['dob'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('dob'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('dob') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
	   				
                                <div class="form-group {{ $errors->has('sex')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('tstudents.column_sex') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="sex" value="{{ $tstudents['sex'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('sex'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('sex') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
	   				
                                <div class="form-group {{ $errors->has('survey_status')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('tstudents.column_survey_status') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="survey_status" value="{{ $tstudents['survey_status'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('survey_status'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('survey_status') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
	   				
                                <div class="form-group {{ $errors->has('group_id')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('tstudents.column_group_id') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="group_id" value="{{ $tstudents['group_id'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('group_id'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('group_id') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
	   				
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button type="submit" class="btn btn-white"><i class="fa fa-undo"></i>   {{ trans('common.cancel') }}</button>
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

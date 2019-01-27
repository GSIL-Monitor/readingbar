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
                            <h5><i class="fa fa-file-text-o"></i>  {{ trans('members.form_title') }}</h5>
                           
                        </div>
                        <div class="ibox-content">
                            <form class="form-horizontal" method="POST" action="{{ url($action) }}">
                                {!! csrf_field() !!}
								{{ method_field($method) }}
								@if(isset($members['id']))
									<input type="hidden" name="id" value="{{ $members['id'] or '' }}"><br>
								@endif
								
                                <div class="form-group {{ $errors->has('cellphone')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('members.column_cellphone') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="cellphone" value="{{ $members['cellphone'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('cellphone'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('cellphone') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
	   				
                                <div class="form-group {{ $errors->has('email')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('members.column_email') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="email" value="{{ $members['email'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('email'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('email') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
	   				
                                <div class="form-group {{ $errors->has('nickname')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('members.column_nickname') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="nickname" value="{{ $members['nickname'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('nickname'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('nickname') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
	   				
                                
                                
	   				
                                <div class="form-group {{ $errors->has('question')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('members.column_question') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="question" value="{{ $members['question'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('question'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('question') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
	   				
                                <div class="form-group {{ $errors->has('answer')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('members.column_answer') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="answer" value="{{ $members['answer'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('answer'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('answer') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
                                <div class="hr-line-dashed"></div>
                                
	   				
                                <div class="form-group {{ $errors->has('actived')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('members.column_actived') }}</label>
                                    <div class="col-sm-10">
                                    	<select name="actived" class="form-control">
                                    		<option value="0">{{trans('members.member_active_0')}}</option>
                                    		<option value="1" {{(isset($members['actived']) && $members['actived']==1)?'selected="selected"':''}}>{{trans('members.member_active_1')}}</option>
                                    	</select>
	                                    @if ($errors->has('actived'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('actived') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group {{ $errors->has('password')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('members.column_password') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="password" name="password"  class="form-control"> 
	                                    @if ($errors->has('password'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('password') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
	   							<div class="form-group"><label class="col-sm-2 control-label">{{ trans('members.column_repassword') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="password" name="password_confirmation"   class="form-control"> 
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a onclick="history.back();" class="btn btn-white"><i class="fa fa-undo"></i>   {{ trans('common.cancel') }}</a>
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

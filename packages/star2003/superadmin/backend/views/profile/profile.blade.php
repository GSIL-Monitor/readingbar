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
            <div class="col-lg-12 text-center">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>{{ trans('profile.head_title') }}</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-6 b-r"><h3 class="m-t-none m-b">{{ trans('profile.changepwd') }}</h3>
                                
                                <form role="form" action="{{url('admin/profile')}}" method="POST" class="form-horizontal">
                                	{!! csrf_field() !!}
									{{ method_field('POST') }}
									<input type="hidden" value="reset_password" name="operation">
                                    <div class="form-group {{ $errors->has('password')?'has-error':''}}">
	                                    <label class="col-sm-3 control-label">{{ trans('profile.oldpwd') }}</label> 
	                                    <div class="col-sm-9">
	                                    <input type="password" placeholder="{{ trans('profile.oldpwd') }}" name="password" class="form-control">
	                                    @if ($errors->has('password'))
												<span class="help-block m-b-none">
													<strong>{{ $errors->first('password') }}</strong>
												</span>
										@endif   
										</div>
                                    </div>
                                    <div class="form-group {{ $errors->has('newpassword')?'has-error':''}}">
	                                    <label class="col-sm-3 control-label">{{ trans('profile.newpwd') }}</label> 
	                                    <div class="col-sm-9">
	                                    <input type="password" placeholder="{{ trans('profile.newpwd') }}" name="newpassword" class="form-control">
	                                    @if ($errors->has('newpassword'))
												<span class="help-block m-b-none">
													<strong>{{ $errors->first('newpassword') }}</strong>
												</span>
										@endif 
										</div>
                                    </div>
                                    <div class="form-group {{ $errors->has('newpassword_confirmation')?'has-error':''}}">
	                                    <label class="col-sm-3 control-label">{{ trans('profile.reinputpwd') }}</label> 
	                                    <div class="col-sm-9">
	                                    <input type="password" placeholder="{{ trans('profile.newpwd') }}" name="newpassword_confirmation" class="form-control">
	                                    @if ($errors->has('newpassword_confirmation'))
												<span class="help-block m-b-none">
													<strong>{{ $errors->first('newpassword_confirmation') }}</strong>
												</span>
										@endif 
										</div>
                                    </div>
                                    <div>
                                        <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>{{ trans('profile.changepwd') }}</strong></button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-6">
                            <form action="{{url('admin/profile')}}" method="POST" enctype="multipart/form-data" id="avatar_form">
                            	{!! csrf_field() !!}
								{{ method_field('POST') }}
								<input type="hidden" value="reset_avatar" name="operation">
								<input type="file" value="" name="avatar" id="avatar" style="display:none" onchange="$('#avatar_form').submit()">
                            	<h4>{{ trans('profile.avatar') }}</h4>
                                
                                <p class="text-center">
                                	<img alt="" width="160px" height="160px" class="fa fa-sign-in big-icon" onclick="$('#avatar').click();" src="{{Auth::user()->avatar?url(Auth::user()->avatar):url('files/avatar/default_avatar.jpg')}}">
                                </p>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>     
@endsection
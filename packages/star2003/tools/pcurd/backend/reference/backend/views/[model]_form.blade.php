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
                            <h5><i class="fa fa-file-text-o"></i>  {{ trans('[model].form_title') }}</h5>
                           
                        </div>
                        <div class="ibox-content">
                            <form class="form-horizontal" method="POST" action="{{ url($action) }}">
                                {!! csrf_field() !!}
								{{ method_field($method) }}
								@if(isset($[model]['id']))
									<input type="hidden" name="id" value="{{ $[model]['id'] or '' }}"><br>
								@endif
								[input]
                                <div class="form-group {{ $errors->has('[column]')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('[model].column_[column]') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="[column]" value="{{ $[model]['[column]'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('[column]'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('[column]') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                [/input]
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a onclick="history.back()" class="btn btn-white"><i class="fa fa-undo"></i>   {{ trans('common.cancel') }}</a>
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

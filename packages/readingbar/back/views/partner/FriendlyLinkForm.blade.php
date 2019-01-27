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
  <section class="wrapper wrapper-content animated fadeInRight"  id="mainContent"> 
		<div class="row">
			<div class="col-md-12">
				<div class="box box-warning ibox-content">
		            <div class="box-header with-border ">
		              <h3 class="box-title">{{ trans('FriendlyLink.view_form') }}</h3>
		            </div>
		            <!-- /.box-header -->
		            <div class="box-body">
		              <form role="form" method="POST"  :action="action" enctype="multipart/form-data" >
		             	{!! csrf_field() !!}
		             	<input class="form-control"   type="hidden" name='id' v-model='form.id'>
		                <!-- text input -->
		                <div class="form-group">
		                  <label>{{ trans('FriendlyLink.columns.partner') }}</label>
		                  <input class="form-control" placeholder="{{ trans('FriendlyLink.placeholder.partner') }}" type="text" name='partner' v-model='form.partner'>
		                  <span class="help-block" v-if="errors.partner">[[ errors.partner[0] ]]</span>
		                </div>
		                <div class="form-group">
		                  <label>{{ trans('FriendlyLink.columns.link') }}</label>
		                  <input class="form-control" placeholder="{{ trans('FriendlyLink.placeholder.link') }}" type="text" name='link' v-model='form.link'>
		                  <span class="help-block" v-if="errors.link">[[ errors.link[0] ]]</span>
		                </div>
		                
		                <div class="form-group">
		                  <label>{{ trans('FriendlyLink.columns.status') }}</label>
		                  <select class="form-control"  name='status'  v-model='form.status'>
		                    <option value='0' >{{ trans('FriendlyLink.form.status.0') }}</option>
		                    <option value='1' >{{ trans('FriendlyLink.form.status.1') }}</option>
		                  </select>
		                  <span class="help-block" v-if="errors.status">[[ errors.status[0] ]]</span>
		                </div>
		             
						<div class="box-footer">
			                <a type="submit" :href="cancel" class="btn btn-default">{{ trans('FriendlyLink.btns.cancel') }}</a>
			                <button type="submit" class="btn btn-info pull-right">{{ trans('FriendlyLink.btns.save') }}</button>
			            </div>
		              </form>
		            </div>
		            <!-- /.box-body -->
		            <div class="overlay" v-if="loading.status">
			          <i class="fa fa-refresh fa-spin"></i>
			        </div>
		          </div>
			</div>
		</div>
    </section>
    <script type="text/javascript">
	    var mainContent=new Vue({
			el:"#mainContent",
			data:{
				action:"{{ $action }}",
				cancel:"{{ $cancel }}",
				form:{!! $editObj !!},
				loading:{
					status:false,
					msg:''
				},
				errors:{!! $errors->toJson() !!},
			},
			created:function(){
				for(i in this.errors){
					$('input[name='+i+'],select[name='+i+']').parent('.form-group').addClass('has-error');
					$(".error_"+i).parent('.form-group').addClass('has-error');
				}
			}
		});
    </script>
@endsection



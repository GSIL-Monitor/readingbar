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
		              <h3 class="box-title">{{ trans('ppc.view_form') }}</h3>
		            </div>
		            <!-- /.box-header -->
		            <div class="box-body">
		              <form role="form" method="POST" :action="action" enctype="multipart/form-data" >
		             	{!! csrf_field() !!}
		             	<input class="form-control"   type="hidden" name='id' v-model='form.id'>
		                <!-- text input -->
		                <div class="form-group">
		                  <label>{{ trans('ppc.columns.icon_pc') }}(图标建议尺寸18x18)</label>
		                  <br>
		                  <img alt=""  :src="form.icon_pc">
		                  <input placeholder="{{ trans('ppc.placeholder.icon_pc') }}" type="file" name='icon_pc'  >
		                  <span class="help-block" v-if="errors.icon_pc">[[ errors.icon_pc[0] ]]</span>
		                </div>
		                <div class="form-group">
		                  <label>{{ trans('ppc.columns.icon_wap') }}(图标建议尺寸18x18)</label>
		                   <br>
		                  <img alt=""  :src="form.icon_wap" v-if='form.icon_wap' >
		                  <input placeholder="{{ trans('ppc.placeholder.icon_wap') }}" type="file" name='icon_wap'  >
		                  <span class="help-block" v-if="errors.icon_wap">[[ errors.icon_wap[0] ]]</span>
		                </div>
		                <div class="form-group">
		                  <label>{{ trans('ppc.columns.catagory_name') }}</label>
		                  <input class="form-control" placeholder="{{ trans('ppc.placeholder.catagory_name') }}" type="text" name='catagory_name' v-model='form.catagory_name'>
		                  <span class="help-block" v-if="errors.catagory_name">[[ errors.catagory_name[0] ]]</span>
		                </div>
						<div class="box-footer">
			                <a type="submit" :href="cancel" class="btn btn-default">{{ trans('ppc.btns.cancel') }}</a>
			                <button type="submit" class="btn btn-info pull-right">{{ trans('ppc.btns.save') }}</button>
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
				}
			}
		});
    </script>
@endsection



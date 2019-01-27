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
		              <h3 class="box-title">{{ trans('PointProduct.view_form') }}</h3>
		            </div>
		            <!-- /.box-header -->
		            <div class="box-body">
		              <form role="form" method="POST"  :action="action" enctype="multipart/form-data" >
		             	{!! csrf_field() !!}
		             	<input class="form-control"   type="hidden" name='id' v-model='form.id'>
		                <!-- text input -->
		                <div class="form-group">
		                  <label>{{ trans('PointProduct.columns.image') }}</label><br>
		                  <img alt="商品图像" :src="form.image" v-if='form.image' width="300px" height="300px">
		                  <input placeholder="{{ trans('PointProduct.placeholder.image') }}" type="file" name='image' >
		                  <span class="help-block" v-if="errors.image">[[ errors.image[0] ]]</span>
		                </div>
		                <div class="form-group">
		                  <label>{{ trans('PointProduct.columns.product_name') }}</label>
		                  <input class="form-control" placeholder="{{ trans('PointProduct.placeholder.product_name') }}" type="text" name='product_name' v-model='form.product_name'>
		                  <span class="help-block" v-if="errors.product_name">[[ errors.product_name[0] ]]</span>
		                </div>
		                <div class="form-group">
		                  <label>{{ trans('PointProduct.columns.point') }}</label>
		                  <input class="form-control" placeholder="{{ trans('PointProduct.placeholder.point') }}" type="text" name='point' v-model='form.point'>
		                  <span class="help-block" v-if="errors.point">[[ errors.point[0] ]]</span>
		                </div>
		                <div class="form-group">
		                  <label>{{ trans('PointProduct.columns.desc') }}</label>
		                  <input class="form-control" placeholder="{{ trans('PointProduct.placeholder.desc') }}" type="text" name='desc' v-model='form.desc'>
		                  <span class="help-block" v-if="errors.desc">[[ errors.desc[0] ]]</span>
		                </div>
		                <div class="form-group">
		                  <label>{{ trans('PointProduct.columns.quantity') }}</label>
		                  <input class="form-control" placeholder="{{ trans('PointProduct.placeholder.quantity') }}" type="text" name='quantity' v-model='form.quantity'>
		                  <span class="help-block" v-if="errors.quantity">[[ errors.quantity[0] ]]</span>
		                </div>
		                <div class="form-group">
		                  <label>{{ trans('PointProduct.columns.catagory') }}</label>
		                  <select class="form-control"  name='catagory'  v-model='form.catagory'>
		                    <option v-for="c in catagory" :value="c.id">[[ c.catagory_name ]]</option>
		                  </select>
		                  <span class="help-block" v-if="errors.catagory">[[ errors.catagory[0] ]]</span>
		                </div>
		                <div class="form-group">
		                  <label>{{ trans('PointProduct.columns.type') }}</label>
		                  <select class="form-control"  name='type'  v-model='form.type'>
		                    <option value='0' >{{ trans('PointProduct.form.type.0') }}</option>
		                    <option value='1' >{{ trans('PointProduct.form.type.1') }}</option>
		                  </select>
		                  <span class="help-block" v-if="errors.type">[[ errors.type[0] ]]</span>
		                </div>
		                 <div class="form-group" v-if='form.type==1'>
		                  <label>{{ trans('PointProduct.columns.type_v') }}</label>
		                  <select class="form-control"  name='type_v'  v-model='form.type_v'>
		                    <option value='' >请选择优惠券类型</option>
		                    <option  v-for='d in discounts'  :value='d.id' >[[ d.name]]</option>
		                  </select>
		                  <span class="help-block" v-if="errors.type_v">[[ errors.type_v[0] ]]</span>
		                </div>
		                <div class="form-group">
		                  <label>{{ trans('PointProduct.columns.status') }}</label>
		                  <select class="form-control"  name='status'  v-model='form.status'>
		                    <option value='0' >{{ trans('PointProduct.form.status.0') }}</option>
		                    <option value='1' >{{ trans('PointProduct.form.status.1') }}</option>
		                  </select>
		                  <span class="help-block" v-if="errors.status">[[ errors.status[0] ]]</span>
		                </div>
		             
						<div class="box-footer">
			                <a type="submit" :href="cancel" class="btn btn-default">{{ trans('PointProduct.btns.cancel') }}</a>
			                <button type="submit" class="btn btn-info pull-right">{{ trans('PointProduct.btns.save') }}</button>
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
				catagory:{!! $catagory !!},
				discounts:{!! $discounts !!},
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



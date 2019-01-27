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
		              <h3 class="box-title">{{ trans('PointOrder.view_form') }}</h3>
		            </div>
		            <!-- /.box-header -->
		            <div class="box-body">
		              <form role="form" method="POST" :action="action">
		             	{!! csrf_field() !!}
		             	<input class="form-control"   type="hidden" name='id' v-model='form.id'>
		                <!-- text input -->
		                
		                <div class="form-group">
		                  <label>{{ trans('PointOrder.columns.order_id') }}</label>
		                  <input disabled class="form-control" placeholder="{{ trans('PointOrder.placeholder.order_id') }}" type="text" name='order_id' v-model='form.order_id'>
		                  <span class="help-block" v-if="errors.order_id">[[ errors.order_id[0] ]]</span>
		                </div>
		                <div class="form-group">
		                  <label>{{ trans('PointOrder.columns.member') }}</label>
		                  <input disabled class="form-control" placeholder="{{ trans('PointOrder.placeholder.member') }}" type="text" name='member' v-model='form.member'>
		                  <span class="help-block" v-if="errors.member">[[ errors.member[0] ]]</span>
		                </div>
		                <div class="form-group">
		                  <label>{{ trans('PointOrder.columns.student') }}</label>
		                  <input disabled class="form-control" placeholder="{{ trans('PointOrder.placeholder.student') }}" type="text" name='student' v-model='form.student'>
		                  <span class="help-block" v-if="errors.student">[[ errors.student[0] ]]</span>
		                </div>
		                <div class="form-group">
		                  <label>{{ trans('PointOrder.columns.reciver') }}</label>
		                  <input  class="form-control" placeholder="{{ trans('PointOrder.placeholder.reciver') }}" type="text" name='reciver' v-model='form.reciver'>
		                  <span class="help-block" v-if="errors.reciver">[[ errors.reciver[0] ]]</span>
		                </div>
		                <div class="form-group">
		                  <label>{{ trans('PointOrder.columns.tel') }}</label>
		                  <input class="form-control" placeholder="{{ trans('PointOrder.placeholder.tel') }}" type="text" name='tel' v-model='form.tel'>
		                  <span class="help-block" v-if="errors.tel">[[ errors.tel[0] ]]</span>
		                </div>
		                <div class="form-group">
		                  <label>{{ trans('PointOrder.columns.address') }}</label>
		                  <input class="form-control" placeholder="{{ trans('PointOrder.placeholder.address') }}" type="text" name='address' v-model='form.address'>
		                  <span class="help-block" v-if="errors.address">[[ errors.address[0] ]]</span>
		                </div>
		                <div class="form-group">
		                  <label>{{ trans('PointOrder.columns.product') }}</label>
		                  <div>

                            <table class="table table-bordered">
                                <thead>
	                                <tr>
	                                    <th><label>{{ trans('PointOrder.columns.product_name') }}</label></th>
	                                    <th>{{ trans('PointOrder.columns.product_quantity') }}</th>
	                                    <th>{{ trans('PointOrder.columns.product_point') }}</th>
	                                </tr>
                                </thead>
                                <tbody>
	                                <tr v-for="p in form.product">
	                                    <td>[[ p.product_name ]]</td>
	                                    <td>[[ p.quantity ]]</td>
	                                    <td>[[ p.point*p.quantity ]]</td>
	                                </tr>
                                </tbody>
                                <tfoot>
	                                <tr>
	                                    <th colspan='3'><label>{{ trans('PointOrder.columns.total_points') }}:</label>[[ form.total_points ]]</th>
	                                </tr>
                                </tfoot>
                            </table>

		                </div>
		                <div class="form-group">
		                  <label>{{ trans('PointOrder.columns.ShipperCode') }}</label>
		                  <select class="form-control"  name='ShipperCode'  v-model='form.ShipperCode'>
		                    	@foreach($ShipperCode as $v)
		                    			<option value="{{ $v->express_code }}">{{ $v->express_name }}</option>
		                    	@endforeach
		                  </select>
		                  <span class="help-block" v-if="errors.ShipperCode">[[ errors.ShipperCode[0] ]]</span>
		                </div>
		                <div class="form-group">
		                  <label>{{ trans('PointOrder.columns.LogisticCode') }}</label>
		                  <input class="form-control" placeholder="{{ trans('PointOrder.placeholder.LogisticCode') }}" type="text" name='LogisticCode' v-model='form.LogisticCode'>
		                  
		                  <span class="help-block" v-if="errors.LogisticCode">[[ errors.LogisticCode[0] ]]</span>
		                </div>
		                <div class="form-group" v-if="form.Traces">
		                  <label>{{ trans('PointOrder.columns.Traces') }}</label>
		                  <div class="form-control" >
		                  		[[ form.Traces.AcceptTime ]]:[[ form.Traces.AcceptStation ]]
		                  </div>
		                </div>
		                 <div class="form-group">
		                  <label>{{ trans('PointOrder.columns.status') }}</label>
		                 <select class="form-control"  name='status'  v-model='form.status'>
		                    <option value='0' >{{ trans('PointOrder.form.status.0') }}</option>
		                    <option value='1' >{{ trans('PointOrder.form.status.1') }}</option>
		                    <option value='2' >{{ trans('PointOrder.form.status.2') }}</option>
		                    <option value='3' >{{ trans('PointOrder.form.status.3') }}</option>
		                  </select>
		                  <span class="help-block" v-if="errors.status">[[ errors.status[0] ]]</span>
		                </div>
						<div class="box-footer">
			                <a type="submit" :href="cancel" class="btn btn-default">{{ trans('PointOrder.btns.cancel') }}</a>
			                <button type="submit" class="btn btn-info pull-right">{{ trans('PointOrder.btns.save') }}</button>
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



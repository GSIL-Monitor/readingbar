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
		              <h3 class="box-title">{{ trans('Point.view_form') }}</h3>
		            </div>
		            <!-- /.box-header -->
		            <div class="box-body">
		              <form role="form" method="POST"  :action="action" enctype="multipart/form-data" >
		             	{!! csrf_field() !!}
		             	<input class="form-control"   type="hidden" name='id' v-model='form.id'>
		                <!-- text input -->
		                <div class="form-group">
		                  <label>{{ trans('Point.columns.name') }}</label>
		                  <input class="form-control" placeholder="{{ trans('Point.placeholder.name') }}" type="text" name='name' v-model='form.name'>
		                  <span class="help-block" v-if="errors.name">[[ errors.name[0] ]]</span>
		                </div>
		                <div class="form-group">
		                  <label>{{ trans('Point.columns.point') }}</label>
		                  <input class="form-control" placeholder="{{ trans('Point.placeholder.point') }}" type="text" name='point' v-model='form.point'>
		                  <span class="help-block" v-if="errors.point">[[ errors.point[0] ]]</span>
		                </div>
		                <div class="form-group">
		                  <label>{{ trans('Point.columns.get_rule') }}</label>
		                  <select class="form-control"  name='get_rule'  v-model='form.get_rule'>
		                    	@foreach($get_rules as $k => $v)
		                    		<option value='{{ $k }}'>{{ $v }}</option>
		                    	@endforeach
		                  </select>
		                  <span class="help-block" v-if="errors.get_rule">[[ errors.get_rule[0] ]]</span>
		                </div>
		                <div class="form-group"  v-if="form.get_rule=='buy_product'">
		                  <label>{{ trans('Point.columns.get_rule_products') }}</label>
		                  <div class='row'>
		                  @foreach($products as $k => $v)
			                  <div class='col-md-3'>
			                        <input   type='checkbox' name='get_rule_products[]'  v-model='form.get_rule_products' value="{{ $v->id }}">
			                  		<label>{{ $v->product_name }}</label>
			                  </div>
		                  @endforeach
		                  </div>
		                  <span class="help-block error_get_rule_products" v-if="errors.get_rule_products">[[ errors.get_rule_products[0] ]]</span>
		                </div>
		                
		                <div class="form-group" v-if="form.get_rule=='promote_new_member' || form.get_rule=='create_first_child_tp'"">
		                			<label >{{ trans('Point.columns.get_rule_promotions_types') }}</label>
                                    <div class="row">
		                                @foreach($get_rule_promotions_types as $k=>$v)
		                                    <div  class="col-md-4">
		                                    	<label>
			                                    	<input  value="{{ $v ->id }}" type="checkbox" name='get_rule_promotions_types[]' v-model='form.get_rule_promotions_types'>
			                                    	{{ $v->name }}
		                                    	</label>
		                                    </div>
		                                @endforeach
	                                    <br style="clear:both">	
	                                    @if($errors->has('get_rule_promotions'))
	                                    	<label class="error">{{ $errors->first('get_rule_promotions') }}</label>
	                                    @endif
                                    </div>
                        </div>
		                <div class="form-group">
		                  <label>{{ trans('Point.columns.status') }}</label>
		                  <select class="form-control"  name='status'  v-model='form.status'>
		                    <option value='0' >{{ trans('Point.form.status.0') }}</option>
		                    <option value='1' >{{ trans('Point.form.status.1') }}</option>
		                  </select>
		                  <span class="help-block" v-if="errors.status">[[ errors.status[0] ]]</span>
		                </div>
		             
                        <div class="hr-line-dashed"></div>
						<div class="box-footer">
			                <a type="submit" :href="cancel" class="btn btn-default">{{ trans('Point.btns.cancel') }}</a>
			                <button type="submit" class="btn btn-info pull-right">{{ trans('Point.btns.save') }}</button>
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



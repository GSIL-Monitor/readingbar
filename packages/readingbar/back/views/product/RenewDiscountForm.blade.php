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
<div class="wrapper wrapper-content animated fadeInRight" id="PEPsList">
	<div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>续费策略设置</h5>
                        </div>
                        <div class="ibox-content">
                            <form method="get" class="form-horizontal">
                            	<div class="form-group"><label class="col-sm-2 control-label">策略名称</label>
                                    <div class="col-sm-10">
                                    	<input type="text"  class="form-control" v-model="form.name">
                                    	<label v-if="errors.name" class="error">[[ errors.name[0] ]]</label>
                                    </div>
                                </div>
                                
                                <div class="form-group"><label class="col-sm-2 control-label">续费产品</label>
                                    <div class="col-sm-10">
                                    	<select class="form-control" v-model="form.product_id" >
                                    		<option value="">请选择产品</option>
                                    		<option v-for="o in products" :value='o.value'>[[ o.text ]]</option>
                                    	</select>
                                    	<label v-if="errors.product_id" class="error ">[[ errors.product_id[0] ]]</label>
                                    </div>
                                </div>
                                
                                <div class="form-group" ><label class="col-sm-2 control-label">优惠金额</label>
                                    <div class="col-sm-10">
                                    	<input type="text"  class="form-control" v-model="form.discount_price">
                                    	<label v-if="errors.discount_price" class="error">[[ errors.discount_price[0] ]]</label>
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">策略类型</label>
                                    <div class="col-sm-10">
                                    	<select class="form-control" v-model="form.type" >
                                    		<option value="">请选择类型</option>
                                    		<option value='1'>所有对应服务期内</option>
                                    		<option value='2'>对应服务到期后n天内</option>
                                    		<option value='3'>相应产品购买之日起N天之内(以最后一个订单为准)</option>
                                    	</select>
                                    	<label v-if="errors.type" class="error ">[[ errors.type[0] ]]</label>
                                    </div>
                                </div>
                                <div class="form-group" v-if="form.type==1"><label class="col-sm-2 control-label">对应服务</label>
                                    <div class="col-sm-10">
                                    	<div class="col-sm-6" v-for="s in services"  >
                                    		<input type="checkbox"  :value="s.value"  v-model="form.services"> 
                                    		<span>[[ s.text ]]</span>
                                    	</div>
                                    	<br>
                                    	<label v-if="errors.services" class="error col-sm-12">[[ errors.services[0] ]]</label>
                                    </div>
                                </div>
                                <div class="form-group" v-if="form.type == 1"><label class="col-sm-2 control-label"></label>
                                    <div class="col-sm-10">
                                    	注：多选服务表示选中的所有服务都在服务期内方可生效。
                                    </div>
                                </div>
                                <div class="form-group" v-if="form.type==2"><label class="col-sm-2 control-label">对应服务</label>
                                    <div class="col-sm-10">
                                    	<select class="form-control" v-model="form.service_id" >
                                    		<option value="">请选择服务</option>
                                    		<option v-for="o in services" :value='o.value'>[[ o.text ]]</option>
                                    	</select>
                                    	<label v-if="errors.service_id" class="error ">[[ errors.service_id[0] ]]</label>
                                    </div>
                                </div>
                                <div class="form-group" v-if="form.type==3"><label class="col-sm-2 control-label">相应产品</label>
                                    <div class="col-sm-10">
                                    	<select class="form-control" v-model="form.product" >
                                    		<option value="">请选择产品</option>
                                    		<option v-for="o in products" :value='o.value'>[[ o.text ]]</option>
                                    	</select>
                                    	<label v-if="errors.product" class="error ">[[ errors.product[0] ]]</label>
                                    </div>
                                </div>
                                <div class="form-group" v-if="form.type == 2 || form.type == 3"><label class="col-sm-2 control-label">n天</label>
                                    <div class="col-sm-10">
                                    	<input type="text"  class="form-control" v-model="form.days">
                                    	<label v-if="errors.days" class="error">[[ errors.days[0] ]]</label>
                                    </div>
                                </div>
                                 <div class="form-group"><label class="col-sm-2 control-label">执行顺序</label>
                                    <div class="col-sm-10">
                                    	<select class="form-control" v-model="form.display" >
                                    		<option value="">请选择数值</option>
                                    		<option v-for="o in 10" :value='o +1'>[[ o+1 ]]</option>
                                    	</select>
                                    	<label v-if="errors.display" class="error ">[[ errors.display[0] ]]</label>
                                    </div>
                                </div>
                                <div class="form-group"  ><label class="col-sm-2 control-label"></label>
                                    <div class="col-sm-10">
                                    	注：数值越小越先校验。(所有策略中只会以优先满足条件的策略作为续费的优惠策略)
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" href="javascript:history.back()">取消</a>
                                        <a class="btn btn-primary"  v-if='ajaxStatus'>
                                        	<i class="fa fa-refresh fa-spin"></i>
                                        </a>
                                        <a class="btn btn-primary"  v-on:click="doSubmit()" v-else>保存</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
</div>
<script type="text/javascript">
var PEPsList=new Vue({
	el:"#PEPsList",
	data: {
		form: {
			product_id: null,
			type:'',
			services: [],
			service_id:null,
			days:'',
			name: ''
		},
		services: {!! $services !!},
		products: {!! $products !!},
		errors: [],
		ajaxStatus: false
	},
	created: function () {
	  @if (isset($data))
			var data = {!! $data->toJson() !!};
			for (i in data) {
				if (i == 'services') {
					for (j in data[i]) {
						this.form.services.push(parseInt(data[i][j]));
					}
				}else{
					this.form[i] = data[i];
				}
			}
	  @endif
	},
	methods: {
		doSubmit () {
			if (this.form.id) {
				this.doUpdate();
			}else{
				this.doCreate();
			}
		},
		doUpdate () {
			var _this = this;
			if (_this.ajaxStatus) {
				return;
			}
			_this.ajaxStatus = true;
			$.ajax({
				url: "{{ url('/admin/productRenewDiscount') }}/" + _this.form.id+'/update',
				type: "post",
				dateType: 'json',
				data: _this.form,
				success: function (json) {
					_this.rules = json;
					appAlert({
						'msg': '数据已保存！',
						ok: {
                          callback:function () {
                        	  window.location.href = "{{ url('admin/productRenewDiscount') }}";
						   }
						}
					})
				},
				error: function (e) {
					_this.errors = e.responseJSON
				},
				complete: function () {
					_this.ajaxStatus = false;
				}
			});
		},
		doCreate () {
			var _this = this;
			if (_this.ajaxStatus) {
				return;
			}
			_this.ajaxStatus = true;
			$.ajax({
				url: "{{ url('/admin/productRenewDiscount/store') }}",
				type: "post",
				dateType: 'json',
				data: _this.form,
				success: function (json) {
					_this.rules = json;
					appAlert({
						'msg': '数据已保存！',
						ok: {
                          callback:function () {	
                        	  window.location.href = "{{ url('admin/productRenewDiscount') }}";
						   }
						}
					})
				},
				error: function (e) {
					_this.errors = e.responseJSON
				},
				complete: function () {
					_this.ajaxStatus = false;
				}
			});
		}
	}
});
</script>
@endsection



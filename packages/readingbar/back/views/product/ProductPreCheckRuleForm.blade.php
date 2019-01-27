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
                            <h5>规则设置表单</h5>
                        </div>
                        <div class="ibox-content">
                            <form method="get" class="form-horizontal">
                                <div class="form-group"><label class="col-sm-2 control-label">规则类型</label>
                                    <div class="col-sm-10">
                                    	
                                    	<select class="form-control" v-model="form.type" >
                                    		<option value="">请选择条件类型</option>
                                    		<option v-for="t in typeOptions"  :value='t.value'>[[t.text]]</option>
                                    	</select>
                                    	<label v-if="errors.type" class="error ">[[ errors.type[0] ]]</label>
                                    </div>
                                </div>
                                <div class="form-group" v-if="form.type == 1 || form.type == 2"><label class="col-sm-2 control-label">服务</label>
                                    <div class="col-sm-10">
                                    	<div class="col-sm-6" v-for="s in services"  >
                                    		<input type="checkbox"  :value="s.value"  v-model="form.array"> 
                                    		<span>[[ s.text ]]</span>
                                    	</div>
                                    	<br>
                                    	<label v-if="errors.array" class="error col-sm-12">[[ errors.array[0] ]]</label>
                                    </div>
                                </div>
                                <div class="form-group" v-if="form.type == 6"><label class="col-sm-2 control-label">GE值</label>
                                    <div class="col-sm-10">
                                    	<input type="text"   v-model="form.number" class="form-control">
                                    	<label v-if="errors.number" class="error">[[ errors.number[0] ]]</label>
                                    </div>
                                </div>
                                <div class="form-group" v-if="form.type == 6"><label class="col-sm-2 control-label"></label>
                                    <div class="col-sm-10">
                                    	<div class="col-sm-6" >
                                    		<input type="radio"  value="1"  v-model="form.boolean">
                                    		<span>大于等于GE值</span>
                                    	</div>
                                    	<div class="col-sm-6" >
                                    		<input type="radio"  value="0"  v-model="form.boolean">
                                    		<span>小于等于GE值</span>
                                    	</div>
                                    	<label v-if="errors.boolean" class="error col-sm-12">[[ errors.boolean[0] ]]</label>
                                    </div>
                                </div>
                                <div class="form-group" v-if="form.type == 6"><label class="col-sm-2 control-label"></label>
                                    <div class="col-sm-10">
                                    	注：如果孩子未做过star测试，孩子的GE值默认为0;若孩子做过多次star测试，GE值取最大值。
                                    </div>
                                </div>
                                <div class="form-group" v-if="form.type != 4"><label class="col-sm-2 control-label">错误提示信息</label>
                                    <div class="col-sm-10">
                                    	<input type="text"  class="form-control" v-model="form.message">
                                    	<label v-if="errors.message" class="error">[[ errors.message[0] ]]</label>
                                    </div>
                                </div>
                                 <div class="form-group"><label class="col-sm-2 control-label">校验顺序</label>
                                    <div class="col-sm-10">
                                    	<select class="form-control" v-model="form.display" >
                                    		<option  value="">请选择数值</option>
                                    		<option v-for="n in 10"  :value='n+1 '>[[ n+1 ]]</option>
                                    	</select>
                                    	<label v-if="errors.display" class="error">[[ errors.display[0] ]]</label>
                                    </div>
                                </div>
                                <div class="form-group"  ><label class="col-sm-2 control-label"></label>
                                    <div class="col-sm-10">
                                    	注：数值越小越先校验。
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
			array: []
		},
		formType: null,
		services: {!! $services !!},
		errors: [],
		ajaxStatus: false,
		typeOptions: [
              {
	              value: 1,
				  text: '必须拥有的前置服务'
	          },
	          {
	              value: 2,
				  text: '不能拥有的前置服务'
	          },    
	          {
	              value: 3,
				  text: '做过测试报告'
	          },     
	          {
	              value: 4,
				  text: '没有未完成的借阅计划(提示信息已默认，若要修改请通知程序员)'
	          },     
	          {
	              value: 5,
				  text: '产品可购买(此条件不可修改产品在线售卖状态，仅修改产品不可购买时的提示信息)'
	          },     
	          {
	              value: 6,
				  text: 'GE值是否达标'
	          },     
	          {
	              value: 7,
				  text: '未曾购买过任意产品（包含赠送服务）'
	          },
	          {
	              value: 8,
				  text: '没有未完成的寒假悦读计划(提示信息已默认，若要修改请通知程序员)'
	          }            
		]
	},
	created: function () {
		@if (isset($product_id))
			this.form= {
				product_id: {!! $product_id !!},
				array: []
			};
		    this.formType = 'create';
		@elseif (isset($object))
			var object = {!! $object !!};
			for (i in object) {
				if (i == 'array') {
					for(j in object.array) {
						this.form['array'].push(parseInt(object.array[j]));
					}
				}else{
					this.form[i]= object[i];
				}
			}
			this.formType = 'edit';
		@endif
	},
	methods: {
		doSubmit () {
			if (this.formType ==='create') {
				this.doCreate();
			}else if (this.formType ==='edit'){
				this.doUpdate();
			}
		},
		doUpdate () {
			var _this = this;
			if (_this.ajaxStatus) {
				return;
			}
			_this.ajaxStatus = true;
			$.ajax({
				url: "{{ url('/admin/productBuyCheck/update') }}",
				type: "post",
				dateType: 'json',
				data: _this.form,
				success: function (json) {
					_this.rules = json;
					appAlert({
						'msg': '数据已保存！',
						ok: {
                          callback:function () {
                        	   window.location.href = "{{ url('admin/productBuyCheck') }}/"+_this.form.product_id+'/list';
						   }
						}
					})
				},
				error: function (e) {
					_this.errors = e.responseJSON
					if (_this.errors.product_id) {
						appAlert({
							msg: "产品参数错误！",
							ok: {
		                        callback: function () {
		                        	window.location.href = "{{ url('admin/product/list') }}";
								}
							}
						});
					}
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
				url: "{{ url('/admin/productBuyCheck/store') }}",
				type: "post",
				dateType: 'json',
				data: _this.form,
				success: function (json) {
					_this.rules = json;
					appAlert({
						'msg': '数据已保存！',
						ok: {
                          callback:function () {
                        	  window.location.href = "{{ url('admin/productBuyCheck') }}/"+_this.form.product_id+'/list';
						   }
						}
					})
				},
				error: function (e) {
					_this.errors = e.responseJSON
					if (_this.errors.product_id) {
						appAlert({
							msg: "产品参数错误！",
							ok: {
		                        callback: function () {
		                        	window.location.href = "{{ url('admin/product/list') }}";
								}
							}
						});
					}
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



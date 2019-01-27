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
<div class="wrapper wrapper-content animated fadeInRight" id="batchesList">
	<div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>礼品卡批次表单</h5>
                        </div>
                        <div class="ibox-content">
                            <form method="get" class="form-horizontal">
                                <div class="form-group"><label class="col-sm-2 control-label">批次名称</label>
                                    <div class="col-sm-10">
                                    	<input v-model="form.name" type="text" class="form-control">
                                    	<label v-if="errors.name" class="error">[[ errors.name[0] ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">关联产品</label>
                                    <div class="col-sm-10">
                                    	<select v-model="form.product_id" class="form-control">
                                    		<option v-for="p in products" :value="p.id">[[p.product_name]]</option>
                                    	</select>
                                    	<label v-if="errors.product_id" class="error">[[ errors.product_id[0] ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">价格</label>
                                    <div class="col-sm-10">
                                    	<input v-model="form.price" type="text" class="form-control">
                                    	<label v-if="errors.price" class="error">[[ errors.price[0] ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">押金</label>
                                    <div class="col-sm-10">
                                    	<input v-model="form.deposit" type="text" class="form-control">
                                    	<label v-if='errors.deposit' class="error">[[ errors.deposit[0] ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">描述</label>
                                    <div class="col-sm-10">
                                    	<input v-model="form.desc" type="text" class="form-control">
                                    	<label v-if='errors.desc' class="error">[[ errors.desc[0] ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">状态</label>
                                    <div class="col-sm-10">
                                    	<select v-model="form.status" class="form-control">
                                    		<option selected value="0">停用</option>
                                    		<option value="1">启用</option>
                                    	</select>
                                    	
                                    	<label v-if='errors.status' class="error">[[ errors.status[0] ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">过期日期</label>
                                    <div class="col-sm-10">
                                    	<input v-model="form.expired" type="text" readonly="readonly" class="form-control datepicker-date">
                                    	<label v-if='errors.expired' class="error">[[ errors.expired[0] ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" href="javascript:history.back()">取消</a>
                                        <a class="btn btn-primary"  v-on:click="submitForm()">保存</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
       
</div>
<script type="text/javascript">
var batchesList=new Vue({
	el:"#batchesList",
	data:{
		batch_id:"{{$batch_id}}",
		form:{
			ajaxStatus:false
		},
		products:null,
		errors:null
	},
	methods:{
		//获取批次数据
		doGetbatch:function(){
			var _this=this;
			if(_this.batch_id){
				$.ajax({
					url:"{{ url('admin/api/gift/cardBatch/getBatch') }}",
					data:{batch_id:_this.batch_id},
					dataType:"json",
					success:function(json){
						_this.form=json;
						_this.form.ajaxStatus=false;
					},
					error:function(XMLHttpRequest, textStatus, errorThrown){
						console.log(XMLHttpRequest.status);
						console.log(XMLHttpRequest.readyState);
						console.log(textStatus);
					}
				});
			}
		},
		//提交表单
		submitForm:function(){
			var _this=this;
			if(_this.form.ajaxStatus){
				return;
			}else{
				_this.form.ajaxStatus=true;
			}
			if(_this.batch_id){
				url="{{ url('admin/api/gift/cardBatch/edit') }}";
			}else{
				url="{{ url('admin/api/gift/cardBatch/create') }}";
			}
			$.ajax({
				url:url,
				data:_this.form,
				dataType:"json",
				type:"POST",
				success:function(json){
					if(json.status){
						//alert(json.success);
						window.location.href="{{ url('admin/gift/cardBatch') }}";
					}else{
						_this.errors=json.errors;
					}
					_this.form.ajaxStatus=false;
				},
				error:function(XMLHttpRequest, textStatus, errorThrown){
					console.log(XMLHttpRequest.status);
					console.log(XMLHttpRequest.readyState);
					console.log(textStatus);
					_this.form.ajaxStatus=false;
				}
			});
		},
		//获取关联产品
		getProducts:function(){
			var _this=this;
			if(_this.products){
				return;
			}
			$.ajax({
				url:"{{ url('admin/api/gift/cardBatch/getProducts') }}",
				dataType:"json",
				success:function(json){
					_this.products=json;
				},
				error:function(XMLHttpRequest, textStatus, errorThrown){
					console.log(XMLHttpRequest.status);
					console.log(XMLHttpRequest.readyState);
					console.log(textStatus);
				}
			});
		}
	}
});
batchesList.doGetbatch();
batchesList.getProducts();
</script>
<script>
//日期控件
$('.datepicker-date').datepicker({format: 'yyyy-mm-dd'});
</script>
@endsection



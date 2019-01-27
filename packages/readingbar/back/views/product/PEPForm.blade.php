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
                            <h5>公告表单</h5>
                        </div>
                        <div class="ibox-content">
                            <form method="get" class="form-horizontal">
                                <div class="form-group"><label class="col-sm-2 control-label">产品</label>
                                    <div class="col-sm-10">
                                    	
                                    	<select class="form-control" v-model="form.product_id" >
                                    		<option selected value="">请选择产品</option>
                                    		<option v-for="p in products" :value='p.id'>[[p.product_name]]</option>
                                    	</select>
                                    	<label v-if="errors.product_id" class="error">[[ errors.product_id[0] ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">附加价格标识 </label>
                                    <div class="col-sm-10">
                                    	<input v-model="form.name" type="text" class="form-control">
                                    	<label v-if="errors.name" class="error">[[ errors.name[0] ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">附加价格</label>
                                    <div class="col-sm-10">
                                    	<input v-model="form.extra_price" type="text" class="form-control">
                                    	<label v-if="errors.extra_price" class="error">[[ errors.extra_price[0] ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">类型</label>
                                    <div class="col-sm-10">
                                    	<select class="form-control" v-model="form.type" >
                                    		<option selected value="">请选择类型</option>
                                    		<option v-for="t in types" :value='t.id'>[[t.name]]</option>
                                    	</select>
                                    	<label v-if="errors.type" class="error">[[ errors.type[0] ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">地区</label>
                                    <div class="col-sm-10">
                                    	<div class="col-sm-3" v-for="a in areas">
                                    		<input v-model="form.areas" :value="a.name" type="checkbox" >[[ a.name ]]
                                    	</div>
                                    	<br style="clear:both">
                                    	<label v-if="errors.areas" class="error" style="clear:both">[[ errors.areas[0] ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">备注</label>
                                    <div class="col-sm-10">
                                    	<input v-model="form.memo" type="text" class="form-control">
                                    	<label v-if="errors.memo" class="error">[[ errors.memo[0] ]]</label>
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
var PEPsList=new Vue({
	el:"#PEPsList",
	data:{
		PEP_id:"{{ $PEP_id }}",
		form:{
			ajaxStatus:false,
			areas:[]
		},
		products:null,
		types:null,
		areas:null,
		errors:null
	},
	created:function(){
		this.doGetPEP();
		this.doGetPar();
	},
	methods:{
		//获取公告数据
		doGetPEP:function(){
			var _this=this;
			if(_this.PEP_id){
				$.ajax({
					url:"{{ url('admin/api/product/PEP/getPEP') }}",
					data:{PEP_id:_this.PEP_id},
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
		//获取表单参数
		doGetPar:function(){
			var _this=this;
			$.ajax({
				url:"{{ url('admin/api/product/PEP/getFormPar') }}",
				dataType:"json",
				success:function(json){
					if(json.products){
						_this.products=json.products;
					}
					if(json.areas){
						_this.areas=json.areas;
					}
					if(json.types){
						_this.types=json.types;
					}
				},
				error:function(XMLHttpRequest, textStatus, errorThrown){
					console.log(XMLHttpRequest.status);
					console.log(XMLHttpRequest.readyState);
					console.log(textStatus);
				}
			});
		},
		//提交表单
		submitForm:function(){
			var _this=this;
			if(_this.form.ajaxStatus){
				return;
			}else{
				_this.form.ajaxStatus=true;
			}
			if(_this.PEP_id){
				url="{{ url('admin/api/product/PEP/editPEP') }}";
			}else{
				url="{{ url('admin/api/product/PEP/createPEP') }}";
			}
			$.ajax({
				url:url,
				data:_this.form,
				dataType:"json",
				type:"POST",
				success:function(json){
					if(json.status){
						//alert(json.success);
						window.location.href="{{ url('admin/product/PEP') }}";
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
		}
	}
});
</script>
@endsection



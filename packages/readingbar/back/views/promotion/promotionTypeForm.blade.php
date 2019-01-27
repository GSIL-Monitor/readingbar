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
<div class="wrapper wrapper-content animated fadeInRight" id="editFrom">
	<div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>推广员类型表单</h5>
                        </div>
                        <div class="ibox-content">
                            <form method="get" class="form-horizontal">
                                <div class="form-group"><label class="col-sm-2 control-label">名称</label>
                                    <div class="col-sm-10">
                                    	<input v-model="form.name" type="text" class="form-control">
                                    	<label v-if="errors.name" class="error">[[ errors.name[0] ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
	                                <div class="form-group"><label class="col-sm-2 control-label">关联产品</label>
	                                 <div class="col-sm-10">
	                                    	<div class="col-md-4" v-for="p in products">
	                                    			<input v-model="form.products" type="checkbox" :value="p.id">
	                                    			<label>[[ p.product_name ]]</label>
	                                    	</div>
	                                    	<label v-if="errors.products" class="error">[[ errors.products[0] ]]</label>
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
var editFrom=new Vue({
	el:"#editFrom",
	data:{
		id:"{{$PromotionType_id}}",
		form:{
			ajaxStatus:false,
			name:'',
			products:[],
		},
		discount_types:null,
		errors:null,
		products:{!! $products !!}
	},
	created:function(){
		this.doGetEditObject();
		this.getFormPra();
	},
	methods:{
		//获取公告数据
		doGetEditObject:function(){
			var _this=this;
			if(_this.id){
				$.ajax({
					url:"{{ url('admin/api/promotion/type/getPromotionType') }}",
					data:{id:_this.id},
					dataType:"json",
					success:function(json){
						_this.form.name=json.name;
						_this.form.id=json.id;
						_this.form.products=[];
						for(i in json.products){
							_this.form.products.push(parseInt(json.products[i]));
						}
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
			if(_this.id){
				url="{{ url('admin/api/promotion/type/editPromotionType') }}";
			}else{
				url="{{ url('admin/api/promotion/type/createPromotionType') }}";
			}
			$.ajax({
				url:url,
				data:_this.form,
				dataType:"json",
				type:"POST",
				success:function(json){
					if(json.status){
						alert(json.success);
						window.location.href="{{ url('admin/promotion/type') }}";
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
		//获取表单参数
		getFormPra:function(){
			var _this=this;
			$.ajax({
				url:"{{ url('admin/api/promotion/type/getFormPar') }}",
				dataType:"json",
				success:function(json){
					if(json.discount_types){
						_this.discount_types=json.discount_types;
					}
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

</script>
<script>
//日期控件
$('.datepicker-date').datepicker({format: 'yyyy-mm-dd'});
</script>
@endsection



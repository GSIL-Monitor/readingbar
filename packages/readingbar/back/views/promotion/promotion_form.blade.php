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
<div class="wrapper wrapper-content animated fadeInRight" id="eidtForm">
	<div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>公告表单</h5>
                        </div>
                        <div class="ibox-content">
                            <form method="get" class="form-horizontal">
                                <div class="form-group"><label class="col-sm-2 control-label">会员名称</label>
                                    <div class="col-sm-10">
                                    	<label class="control-label">[[ form.name ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">手机 </label>
                                    <div class="col-sm-10">
                                    	<label class="control-label">[[ form.cellphone ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">邮箱</label>
                                    <div class="col-sm-10">
                                    	<label class="control-label">[[ form.email ]]</label>
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
var eidtForm=new Vue({
	el:"#eidtForm",
	data:{
		id:"{{ $id }}",
		form:{
			ajaxStatus:false,
			type:[]
		},
		types:null,
		errors:null
	},
	created:function(){
		this.doGetEditObject();
		this.doGetPar();
	},
	methods:{
		//获取推广员数据
		doGetEditObject:function(){
			var _this=this;
			if(_this.id){
				$.ajax({
					url:"{{ url('admin/api/promotion/getPromotion') }}",
					data:{id:_this.id},
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
				url:"{{ url('admin/api/promotion/getFormPar') }}",
				dataType:"json",
				success:function(json){
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
			url="{{ url('admin/api/promotion/editPromotion') }}";
			$.ajax({
				url:url,
				data:_this.form,
				dataType:"json",
				type:"POST",
				success:function(json){
					if(json.status){
						alert(json.success);
						window.location.href="{{ url('admin/promotion') }}";
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



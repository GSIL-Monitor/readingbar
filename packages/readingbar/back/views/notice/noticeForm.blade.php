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
<div class="wrapper wrapper-content animated fadeInRight" id="noticesList">
	<div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>公告表单</h5>
                        </div>
                        <div class="ibox-content">
                            <form method="get" class="form-horizontal">
                                <div class="form-group"><label class="col-sm-2 control-label">公告</label>
                                    <div class="col-sm-10">
                                    	<input v-model="form.notice" type="text" class="form-control">
                                    	<label v-if="errors.notice" class="error">[[ errors.notice[0] ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">外链 </label>
                                    <div class="col-sm-10">
                                    	<input v-model="form.url" type="text" class="form-control">
                                    	<label v-if="errors.url" class="error">[[ errors.url[0] ]]</label>
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
var noticesList=new Vue({
	el:"#noticesList",
	data:{
		notice_id:"{{$notice_id}}",
		form:{
			ajaxStatus:false
		},
		products:null,
		errors:null
	},
	methods:{
		//获取公告数据
		doGetnotice:function(){
			var _this=this;
			if(_this.notice_id){
				$.ajax({
					url:"{{ url('admin/api/notice/getNotice') }}",
					data:{notice_id:_this.notice_id},
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
			if(_this.notice_id){
				url="{{ url('admin/api/notice/editNotice') }}";
			}else{
				url="{{ url('admin/api/notice/createNotice') }}";
			}
			$.ajax({
				url:url,
				data:_this.form,
				dataType:"json",
				type:"POST",
				success:function(json){
					if(json.status){
						//alert(json.success);
						window.location.href="{{ url('admin/notice') }}";
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
noticesList.doGetnotice();
</script>
<script>
//日期控件
$('.datepicker-date').datepicker({format: 'yyyy-mm-dd'});
</script>
@endsection



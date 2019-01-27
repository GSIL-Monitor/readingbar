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
<div class="wrapper wrapper-content animated fadeInRight" id="wxArticlesList">
	<div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>微信文章表单</h5>
                        </div>
                        <div class="ibox-content">
                            <form method="POST" class="form-horizontal" enctype="multipart/form-data" id="wxArticleForm" :action="">
                               	<input type="hidden" v-if="form.id" name="id" v-model="form.id">
                                <div class="form-group"><label class="col-sm-2 control-label">标题</label>
                                    <div class="col-sm-10">
                                    	<input v-model="form.title" type="text" name='title' class="form-control">
                                    	<label v-if="errors.title" class="error">[[ errors.title[0] ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">标题图片</label>
                                    <div class="col-sm-10">
                                    	<img v-if='form.title_image' style="width:100px;" alt="上传图片" :src="form.title_image" >
                                    	<a class="btn btn-default" onclick="$('input[name=title_image]').click()">上传图片</a>
                                    	<input type="file" name="title_image" style="display: none">
                                    	<label>请上传尺寸为293*170的图片</label>
                                    	<label v-if="errors.title_image" class="error">[[ errors.title_image[0] ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">摘要</label>
                                    <div class="col-sm-10">
                                    	<input v-model="form.summary" type="text" name='summary' class="form-control">
                                    	<label v-if="errors.summary" class="error">[[ errors.summary[0] ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">微信文章链接</label>
                                    <div class="col-sm-10">
                                    	<input v-model="form.url" type="text" name='url' class="form-control">
                                    	<label v-if="errors.url" class="error">[[ errors.url[0] ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">标签1</label>
                                    <div class="col-sm-10">
                                    	<input v-model="form.lable" type="text" name='lable' class="form-control">
                                    	<label>最多5个标签,每个标签用“,”间隔,且字数最好控制在2-8个字内，如：儿童,冒险,...</label><br>
                                    	<label v-if="errors.lable" class="error">[[ errors.lable[0] ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">状态</label>
                                    <div class="col-sm-10">
                                    	<select v-model="form.status" class="form-control" name="status">
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
var wxArticlesList=new Vue({
	el:"#wxArticlesList",
	data:{
		wxArticle_id:"{{$wxArticle_id}}",
		form:{
			ajaxStatus:false
		},
		products:null,
		errors:null
	},
	methods:{
		//获取微信文章数据
		doGetWxArticle:function(){
			var _this=this;
			if(_this.wxArticle_id){
				$.ajax({
					url:"{{ url('admin/api/wxArticle/getWxArticle') }}",
					data:{wxArticle_id:_this.wxArticle_id},
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
			if(_this.wxArticle_id){
				url="{{ url('admin/api/wxArticle/editWxArticle') }}";
			}else{
				url="{{ url('admin/api/wxArticle/createWxArticle') }}";
			}
			$("#wxArticleForm").attr('action',url);
			$("#wxArticleForm").ajaxSubmit(function(json){
					if(json.status){
						window.location.href="{{ url('admin/wxArticle') }}";
					}else{
						_this.errors=json.errors;
						_this.form.ajaxStatus=false;
					}
				}
			);
		}
	}
});
wxArticlesList.doGetWxArticle();
</script>
@endsection



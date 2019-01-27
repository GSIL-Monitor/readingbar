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
	<div :class="alert.classes" role="alert" v-if="alert">
	  <button type="button" class="close" v-on:click="alert=null" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>[[ alert.msg ]]</strong>
	</div>
	<div class="row">
		<div class="col-lg-12">
		    <div class="ibox">
		    	<div class="ibox-title">
                        <h5><i class="fa fa-list-ul"></i>  微信文章列表 </h5>
                        <div class="ibox-tools">
                        	<a :href="a.create" class="btn btn-primary btn-xs" ><i class="fa fa-plus-square-o"></i>   {{ trans('common.add') }}</a>
                        	<a href="javascript:void(0)" v-on:click="doDelete()" class="btn btn-primary btn-xs"><i class="fa fa-trash"></i>   {{ trans('common.delete') }}</a>
                		</div>
                </div>
		        <div class="ibox-content">
		            <table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15">
		                <thead>
		                    <tr>
		                    	<th><input type="checkbox" :checked="(selected.length==wxArticles.data.length)" name="selectedAll" v-on:click="selectedAll()"></th>
		                        <th data-toggle="true" class="footable-visible footable-first-column footable-sortable footable-sorted">#ID</th>
		                        <th data-hide="phone" class="footable-visible footable-sortable col-md-1">
		                        	标题
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable col-md-2">
		                        	标题图片
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable col-md-3">
		                        	摘要
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable col-md-1">
		                        	微信文章链接
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable col-md-1">
		                        	标签
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable col-md-1">
		                        	状态
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable col-md-1">
		                        	创建时间
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable col-md-1">
		                        	更新时间
		                        </th>
		                        <th class="text-right footable-visible footable-last-column col-md-1" data-sort-ignore="true">操作</th></tr>
		                </thead>
		                <tbody>
		                    <tr class="footable-even" style="display: table-row;" v-for="n in wxArticles.data">
		                        <td class="footable-visible footable-first-column"><input v-model="selected" type="checkbox" name="selected" :value="n.id"></td>
		                        <td class="footable-visible">[[n.id]]</td>
		                        <td class="footable-visible">[[n.title]]</td>
		                        <td class="footable-visible"><img alt="暂无" :src="n.title_image" style="width:100px;"></td>
		                        
		                        <td class="footable-visible">[[n.summary]]</td>
		                        <td class="footable-visible"><a :href="n.url">预览</a></td>
		                        <td class="footable-visible">
		                        	<span class="badge badge-primary" v-for="l in n.lable" v-if="$index<5">[[ l ]]</span>
		                        </td>
		                        <td class="footable-visible">[[n.status]]</td>
		                        <td class="footable-visible">[[n.created_at]]</td>
		                        <td class="footable-visible">[[n.updated_at]]</td>
		                        <td class="footable-visible text-right">
		                        	<a class="btn btn-primary" :href="n.edit">编辑</a>
		                        	<a class="btn btn-primary" v-if="n.top==0" v-on:click="setTop(n)">文章置顶</a>
		                        	<a class="btn btn-primary" v-else v-on:click="cancelTop(n)">取消置顶</a>
		                        </td>
		                    </tr>
		                </tbody>
		                <tfoot v-if="wxArticles && wxArticles.last_page>1">
		                    <tr>
		                        <td colspan="12" class="footable-visible">
		                            <ul class="pagination pull-right" >
								    	<li v-if="wxArticles.current_page>1" v-on:click="doChangePage(1)"><a>«</a></li>
							    		<template v-for="p in wxArticles.last_page" v-if="Math.abs(wxArticles.current_page-(p+1))<=3">
							    			<li v-if="wxArticles.current_page==p+1" class="active" v-on:click="doChangePage(p+1)"><span>[[ p+1 ]]</span></li>
							    			<li v-else v-on:click="doChangePage(p+1)"><a>[[ p+1 ]]</a></li>
							    		</template>
								     	<li v-if="wxArticles.current_page < wxArticles.last_page" v-on:click="doChangePage(wxArticles.last_page)"><a>»</a></li>
							     	</ul>
		                        </td>
		                    </tr>
		                </tfoot>
		            </table>
		        </div>
		    </div>
		</div>
	</div>
</div>
<script type="text/javascript">
var wxArticlesList=new Vue({
	el:"#wxArticlesList",
	data:{
		wxArticles:null,
		search:{
			page:1,
			limit:10,
			order:'id',
			sort:'desc',
			ajaxStatus:false
		},
		a:{
			create:"{{url('admin/wxArticle/form')}}"
		},
		selected:[],
		alert:null
	},
	methods:{
		//获取公告数据
		doGetWxArticles:function(){
			var _this=this;
			if(_this.search.ajaxStatus){
				return;
			}else{
				_this.search.ajaxStatus=true;
			}
			$.ajax({
				url:"{{ url('admin/api/wxArticle/getWxArticles') }}",
				data:_this.search,
				dataType:"json",
				success:function(json){
					_this.wxArticles=json;
					_this.search.ajaxStatus=false;
				},
				error:function(){
					_this.search.ajaxStatus=false;
				}
			});
		},
		//选择所有复选框
		selectedAll:function(){
			if(this.selected.length==this.wxArticles.data.length){
				this.selected=[];
			}else{
				s=[];
				for(i in this.wxArticles.data){
					s[i]=this.wxArticles.data[i].id;
				}
				this.selected=s;
			}
		},
		//删除按钮
		doDelete:function(){
			if(confirm('是否确认删除！')){
				var _this=this;
				$.ajax({
					url:"{{ url('admin/api/wxArticle/deleteWxArticle') }}",
					data:{selected:_this.selected},
					dataType:"json",
					type:"POST",
					success:function(json){
						if(json.status){
							_this.doAlert('success',json.success);
							_this.doGetWxArticles();
						}else{
							_this.doAlert('error',json.error);
						}
					},
					error:function(XMLHttpRequest, textStatus, errorThrown){
						console.log(XMLHttpRequest.status);
						console.log(XMLHttpRequest.readyState);
						console.log(textStatus);
					}
				});
			}
		},
		//翻页
		doChangePage:function(p){
			this.search.page=p;
			this.doGetWxArticles();
		},
		//提示信息
		doAlert:function(type,msg){
			switch(type){
				case 'success':
					this.alert={
							msg:msg,
							classes:'alert alert-success'
						}
					break;
				case 'error':
					this.alert={
						msg:msg,
						classes:'alert alert-danger'
					}
	 				break;
			}
		},
		//文章置顶
		setTop:function(n){
			var _this=this;
			$.ajax({
				url:"{{ url('admin/api/wxArticle/setTop') }}",
				data:{id:n.id},
				dataType:"json",
				type:"POST",
				success:function(json){
					if(json.status){
						_this.doAlert('success',json.success);
						_this.doGetWxArticles();
					}
				},
				error:function(XMLHttpRequest, textStatus, errorThrown){
					console.log(XMLHttpRequest.status);
					console.log(XMLHttpRequest.readyState);
					console.log(textStatus);
				}
			});
		},
		//取消置顶
		cancelTop:function(n){
			var _this=this;
			$.ajax({
				url:"{{ url('admin/api/wxArticle/cancelTop') }}",
				dataType:"json",
				data:{id:n.id},
				type:"POST",
				success:function(json){
					if(json.status){
						_this.doAlert('success',json.success);
						_this.doGetWxArticles();
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
wxArticlesList.doGetWxArticles();
</script>
@endsection



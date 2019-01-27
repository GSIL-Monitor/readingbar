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
<div class="wrapper wrapper-content animated fadeInRight" id="reportsList">
	<!-- 搜索 -->
	 <div class="row">
             <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                         <h5><i class="fa fa-file-text-o"></i>条件搜索</h5>
                    </div>
                    <form class="ibox-content form-inline" onsubmit="return false">
                     	  <input class="form-control" v-model="search.parent"  placeholder="家长">  
                          <input class="form-control" v-model="search.email"  placeholder="邮箱">  
                          <input class="form-control" v-model="search.cellphone"  placeholder="手机"> 
                          <input class="form-control" v-model="search.student_name" value="{{ $student_name }}"  placeholder="学生姓名">
                          <input class="form-control" v-model="search.student_nickname"  placeholder="学生昵称">
                          <input class="form-control" v-model="search.star_account"  placeholder="star账号">
                          <button v-on:click="doSearch()" class="btn btn-white">查询</button>
                    </form>
                </div>
            </div>
    </div>
	<!-- /搜索 -->
	<div :class="alert.classes" role="alert" v-if="alert">
	  <button type="button" class="close" v-on:click="alert=null" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>[[ alert.msg ]]</strong>
	</div>
	<div class="row">
		<div class="col-lg-12">
		    <div class="ibox">
		    	<div class="ibox-title">
                        <h5><i class="fa fa-list-ul"></i>star报告列表 </h5>
                        <div class="ibox-tools">
                        	<a :href="a.create" class="btn btn-primary btn-xs" ><i class="fa fa-plus-square-o"></i>   {{ trans('common.add') }}</a>
                        	<a href="javascript:void(0)" v-on:click="doDelete()" class="btn btn-primary btn-xs"><i class="fa fa-trash"></i>   {{ trans('common.delete') }}</a>
                		</div>
                </div>
		        <div class="ibox-content">
		            <table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15">
		                <thead>
		                    <tr>
		                    	<th><input type="checkbox" :checked="(selected.length==reports.data.length)" name="selectedAll" v-on:click="selectedAll()"></th>
		                        <th data-toggle="true" class="footable-visible footable-first-column footable-sortable footable-sorted">#ID</th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	家长
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	邮箱
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	手机
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	学生姓名
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	学生昵称
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	star账号
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	测试时间
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	测试用时
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	备注
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	创建时间
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	更新时间
		                        </th>
		                        <th class="text-right footable-visible footable-last-column" data-sort-ignore="true">操作</th></tr>
		                </thead>
		                <tbody>
		                	<tr v-if="reports==null">
		                		<td colspan="13" class="text-center">数据加载中</td>
		                	</tr>
		                    <tr class="footable-even" style="display: table-row;" v-for="r in reports.data" v-else>
		                        <td class="footable-visible footable-first-column"><input v-model="selected" type="checkbox" name="selected" :value="r.id"></td>
		                        <td class="footable-visible">[[r.id]]</td>
		                        <td class="footable-visible">[[r.parent]]</td>
		                        <td class="footable-visible">[[r.email]]</td>
		                        <td class="footable-visible">[[r.cellphone]]</td>
		                        <td class="footable-visible">[[r.student_name]]</td>
		                        <td class="footable-visible">[[r.student_nickname]]</td>
		                        <td class="footable-visible">[[r.star_account]]</td>
		                        <td class="footable-visible">[[r.test_date]]</td>
		                        <td class="footable-visible">[[r.time_used]]</td>
		                        <td class="footable-visible">[[r.memo]]</td>
		                        <td class="footable-visible">[[r.created_at]]</td>
		                        <td class="footable-visible">[[r.updated_at]]</td>
		                        <td class="footable-visible text-right">
		                        	<a class="btn btn-primary" :href="r.edit">编辑</a>
		                        	<tmplate v-if="r.report_type==0">
		                        		<a class="btn btn-primary" :href="r.booklist">书单</a>
		                        		<a class="btn btn-primary" :href="r.en">英文报告</a>
		                        		<a class="btn btn-primary" v-on:click="openUrl(r.zh)">中文报告</a>
		                        	</tmplate>
		                        	<a class="btn btn-primary" :href="r.stage" v-else>阶段报告</a>
		                        </td>
		                    </tr>
		                </tbody>
		                <tfoot v-if="reports && reports.last_page>1">
		                    <tr>
		                        <td colspan="14" class="footable-visible">
		                            <ul class="pagination pull-right" >
								    	<li v-if="reports.current_page>1" v-on:click="doChangePage(1)"><a>«</a></li>
							    		<template v-for="p in reports.last_page" v-if="Math.abs(reports.current_page-(p+1))<=3">
							    			<li v-if="reports.current_page==p+1" class="active" v-on:click="doChangePage(p+1)"><span>[[ p+1 ]]</span></li>
							    			<li v-else v-on:click="doChangePage(p+1)"><a>[[ p+1 ]]</a></li>
							    		</template>
								     	<li v-if="reports.current_page < reports.last_page" v-on:click="doChangePage(reports.last_page)"><a>»</a></li>
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
var reportsList=new Vue({
	el:"#reportsList",
	data:{
		reports:null,
		search:{
			page:1,
			limit:10,
			ajaxStatus:false
		},
		a:{
			create:"{{url('admin/teacher/starreport/form')}}"
		},
		selected:[],
		alert:null
	},
	methods:{
		//获取公告数据
		doGetreports:function(){
			var _this=this;
			_this.reports=null;
			$.ajax({
				url:"{{ url('admin/api/teacher/starreport/getStarReports') }}",
				data:_this.search,
				dataType:"json",
				success:function(json){
					_this.reports=json;
				},
				error:function(){
					
				}
			});
		},
		
		//选择所有复选框
		selectedAll:function(){
			if(this.selected.length==this.reports.data.length){
				this.selected=[];
			}else{
				s=[];
				for(i in this.reports.data){
					s[i]=this.reports.data[i].id;
				}
				this.selected=s;
			}
		},
		//删除按钮
		doDelete:function(){
			if(confirm('是否确认删除！')){
				var _this=this;
				$.ajax({
					url:"{{ url('admin/api/teacher/starreport/deleteStarReport') }}",
					data:{selected:_this.selected},
					dataType:"json",
					type:"POST",
					success:function(json){
						if(json.status){
							_this.doAlert('success',json.success);
							_this.doGetreports();
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
			this.doGetreports();
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
		//条件检索
		doSearch:function(){
			this.search.page=1;
			this.doGetreports();
		},
		openUrl:function(url){
			window.open(url)
		}
	}
});
reportsList.doGetreports();
</script>
@endsection



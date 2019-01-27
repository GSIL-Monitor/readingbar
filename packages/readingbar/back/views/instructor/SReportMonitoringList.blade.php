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
<div class="wrapper wrapper-content animated fadeInRight" id="mainContent">
	<div :class="alert.classes" role="alert" v-if="alert">
	  <button type="button" class="close" v-on:click="alert=null" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>[[ alert.msg ]]</strong>
	</div>
	<!-- 搜索 -->
	 <div class="row">
             <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                         <h5><i class="fa fa-file-text-o"></i>条件搜索</h5>
                    </div>
                    <form class="ibox-content form-inline" onsubmit="return false">
                    	  <input class="form-control" v-model="search_ready.student_name" placeholder="学生姓名 "> 
                    	  <input class="form-control" v-model="search_ready.student_nickname" placeholder="学生昵称 "> 
                          <input class="form-control" v-model="search_ready.star_account" placeholder="star账号">  
                          <input class="form-control" v-model="search_ready.school_name" placeholder="学校 "> 
                          <select v-model="search_ready.grade" class="form-control">
                          	<option selected value=''>年级</option>
                          	<option v-for="g in grades" :value="g">[[ g ]]</option>
                          </select>
                          <select v-model="search_ready.report_type" class="form-control">
                          	<option value="0">star报告</option>
                          	<option value="1">阶段性报告</option>
                          </select>
                          <button class='btn btn-default' v-on:click='doSearch()'>查询</button>
                    </form>
                </div>
            </div>
    </div>
	<!-- /搜索 -->
	<div class="row">
		<div class="col-lg-12">
		    <div class="ibox">
		    	<div class="ibox-title">
                        <h5><i class="fa fa-list-ul"></i>报告列表 </h5>
                        <div class="ibox-tools">
                        	<a class="btn btn-primary btn-xs" v-on:click="exportList()" href="javascript:void(0)"><i class="fa fa-download"></i>导出</a>
                        </div>
                </div>
		        <div class="ibox-content">
		         <!-- star报告 -->
		            <table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15" v-if="search.report_type==0">
		                <thead>
		                	
		                    <tr>
		                    	<th data-toggle="true" class="footable-visible footable-first-column footable-sortable footable-sorted">报告序号</th>
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
		                        	年级
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	学校
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	报告创建日期
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	创建老师
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	测试时间
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	测试用时
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	SS
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	PR
		                        </th>
		                         <th data-hide="phone" class="footable-visible footable-sortable">
		                        	EST.OR
		                        </th>
		                         <th data-hide="phone" class="footable-visible footable-sortable">
		                        	GE
		                        </th>
		                         <th data-hide="phone" class="footable-visible footable-sortable">
		                        	IRL
		                        </th>
		                         <th data-hide="phone" class="footable-visible footable-sortable">
		                        	ZPD
		                        </th>
		                </thead>
		                <tbody>
		                	<tr v-if="list==null">
		                		<td colspan='13' class="text-center">数据加载中</td>
		                	</tr>
		                    <tr class="footable-even" style="display: table-row;" v-for="n in list.data" v-else>
		                        <td class="footable-visible">[[n.id]]</td>
		                        <td class="footable-visible">[[n.student_name]]</td>
		                        <td class="footable-visible">[[n.student_nickname]]</td>
		                        <td class="footable-visible">[[n.star_account]]</td>
		                         <td class="footable-visible">[[n.grade]]</td>
		                        <td class="footable-visible">[[n.school_name]]</td>
		                        <td class="footable-visible">[[n.created_at]]</td>
		                        <td class="footable-visible">[[n.teacher]]</td>
		                        <td class="footable-visible">[[n.test_date]]</td>
		                        <td class="footable-visible">[[n.time_used]]</td>
		                        <td class="footable-visible">[[n.ss]]</td>
		                        <td class="footable-visible">[[n.pr]]</td>
		                        <td class="footable-visible">[[n.estor]]</td>
		                        <td class="footable-visible">[[n.ge]]</td>
		                        <td class="footable-visible">[[n.irl]]</td>
		                        <td class="footable-visible">[[n.zpd]]</td>
		                    </tr>
		                </tbody>
		                <tfoot v-if="list && list.last_page>1">
		                    <tr>
		                    	<td>
		                    		<span class='row'>
		                    			[[ list.from ]]-[[ list.to ]]/[[ list.total ]]
		                    		</span>
		                    	</td>
		                        <td colspan="15" class="footable-visible">
		                            <ul class="pagination pull-right" >
								    	<li v-if="list.current_page>1" v-on:click="doChangePage(1)"><a>«</a></li>
							    		<template v-for="p in list.last_page" v-if="Math.abs(list.current_page-(p+1))<=3">
							    			<li v-if="list.current_page==p+1" class="active" v-on:click="doChangePage(p+1)"><span>[[ p+1 ]]</span></li>
							    			<li v-else v-on:click="doChangePage(p+1)"><a>[[ p+1 ]]</a></li>
							    		</template>
								     	<li v-if="list.current_page < list.last_page" v-on:click="doChangePage(list.last_page)"><a>»</a></li>
							     	</ul>
		                        </td>
		                    </tr>
		                </tfoot>
		            </table>
		            <!-- star报告 -->
		            <!--阶段报告报告 -->
		            <table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15" v-else>
		                <thead>
		                    <tr>
		                    	<th data-toggle="true" class="footable-visible footable-first-column footable-sortable footable-sorted">报告序号</th>
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
		                        	年级
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	学校
		                        </th>
		                         <th data-hide="phone" class="footable-visible footable-sortable">
		                        	报告创建日期
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	创建老师
		                        </th>
		                </thead>
		                <tbody>
		                   	<tr v-if="list==null">
		                		<td colspan='13' class="text-center">数据加载中</td>
		                	</tr>
		                    <tr class="footable-even" style="display: table-row;" v-for="n in list.data" v-else>
		                        <td class="footable-visible">[[n.id]]</td>
		                        <td class="footable-visible">[[n.student_name]]</td>
		                        <td class="footable-visible">[[n.student_nickname]]</td>
		                        <td class="footable-visible">[[n.star_account]]</td>
		                         <td class="footable-visible">[[n.grade]]</td>
		                        <td class="footable-visible">[[n.school_name]]</td>
		                        <td class="footable-visible">[[n.created_at]]</td>
		                        <td class="footable-visible">[[n.teacher]]</td>
		                    </tr>
		                </tbody>
		                <tfoot v-if="list && list.last_page>1">
		                    <tr>
		                    	<td>
		                    		<span class='row'>
		                    			[[ list.from ]]-[[ list.to ]]/[[ list.total ]]
		                    		</span>
		                    	</td>
		                        <td colspan="15" class="footable-visible">
		                            <ul class="pagination pull-right" >
								    	<li v-if="list.current_page>1" v-on:click="doChangePage(1)"><a>«</a></li>
							    		<template v-for="p in list.last_page" v-if="Math.abs(list.current_page-(p+1))<=3">
							    			<li v-if="list.current_page==p+1" class="active" v-on:click="doChangePage(p+1)"><span>[[ p+1 ]]</span></li>
							    			<li v-else v-on:click="doChangePage(p+1)"><a>[[ p+1 ]]</a></li>
							    		</template>
								     	<li v-if="list.current_page < list.last_page" v-on:click="doChangePage(list.last_page)"><a>»</a></li>
							     	</ul>
		                        </td>
		                    </tr>
		                </tfoot>
		            </table>
		            <!--阶段报告报告 -->
		        </div>
		    </div>
		</div>
	</div>
</div>
<script type="text/javascript">
var mainContent=new Vue({
	el:"#mainContent",
	data:{
		list:null,
		search:{
			page:1,
			limit:10,
			ajaxStatus:false,
			report_type:0
		},
		search_ready:{
			report_type:0
		},
		grades:[1,2,3,4,5,6,7,8,9,10,11,12,'k'],
		alert:null
	},
	created:function(){
		this.doGetList();
	},
	methods:{
		doGetList:function(){
			var _this=this;
			if(_this.search.ajaxStatus){
				return;
			}else{
				_this.search.ajaxStatus=true;
			}
			_this.list=null;
			$.ajax({
				url:"{{ url('admin/SReportMonitoring/api/getList') }}",
				data:_this.search,
				dataType:"json",
				success:function(json){
					_this.list=json;
					_this.search.ajaxStatus=false;
				},
				error:function(){
					_this.search.ajaxStatus=false;
				}
			});
		},
		//翻页
		doChangePage:function(p){
			this.search.page=p;
			this.doGetList();
		},
		//查询
		doSearch:function(){
			for(i in this.search_ready){
				this.search[i]=this.search_ready[i];
			}
			this.search.page=1;
			this.doGetList();
		},
		//导出
		exportList:function(){
			window.location.href="{{ url('admin/SReportMonitoring/api/export') }}?"+$.param(this.search);
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
		}
	}
});
</script>
@endsection



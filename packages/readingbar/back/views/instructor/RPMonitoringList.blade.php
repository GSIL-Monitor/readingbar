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
                    	  <select v-model="search_ready.status" class="form-control">
                          	<option selected value=''>计划状态</option>
                          	<option v-for="s in status" :value="$key">[[ s ]]</option>
                          </select>
                    	  <input class="form-control" v-model="search_ready.student_name" placeholder="学生姓名 "> 
                    	  <input class="form-control" v-model="search_ready.student_nickname" placeholder="学生昵称 "> 
                          <input class="form-control" v-model="search_ready.star_account" placeholder="star账号">  
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
                        <h5><i class="fa fa-list-ul"></i>阅读计划列表 </h5>
                </div>
		        <div class="ibox-content">
		            <table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15">
		                <thead>
		                    <tr>
		                    	<th data-toggle="true" class="footable-visible footable-first-column footable-sortable footable-sorted">报告序号</th>
		                         <th data-hide="phone" class="footable-visible footable-sortable">
		                        	计划标识
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	学生姓名
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	学生昵称
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	所属老师
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	star账号
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	状态
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	计划时间段
		                        </th>
		                </thead>
		                <tbody>
		                    <tr class="footable-even" style="display: table-row;" v-for="n in list.data">
		                    	<td class="footable-visible">[[n.id]]</td>
		                    	<td class="footable-visible">[[n.plan_name]]</td>
		                        <td class="footable-visible">[[n.student_name]]</td>
		                        <td class="footable-visible">[[n.student_nickname]]</td>
		                        <td class="footable-visible">[[n.teacher_name]]</td>
		                        <td class="footable-visible">[[n.star_account]]</td>
		                        <td class="footable-visible">[[n.status]]</td>
		                        <td class="footable-visible">[[n.from]]~[[n.to]]</td>
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
		        </div>
		    </div>
		</div>
	</div>
</div>
<script type="text/javascript">
var mainContent=new Vue({
	el:"#mainContent",
	data:{
		list:{!! $readPlans !!},
		search:{
			page:1,
			limit:10,
			ajaxStatus:false
		},
		search_ready:{
		},
		status:{!! $status !!},
		alert:null
	},
	created:function(){
		var _this=this;
	},
	methods:{
		doGetList:function(){
			var _this=this;
			if(_this.search.ajaxStatus){
				return;
			}else{
				_this.search.ajaxStatus=true;
			}
			$.ajax({
				url:"{{ url('admin/RPMonitoring/api/getList') }}",
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



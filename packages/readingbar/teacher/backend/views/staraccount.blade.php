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
<div class="wrapper wrapper-content animated fadeInRight">
	
    <div class="row">
             <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                         <h5><i class="fa fa-file-text-o"></i>{{ trans('staraccount.head_title') }}</h5>
                    </div>
                    <form class="ibox-content form-inline" onsubmit="return false">
                                <div class="form-group">
                                    <select class="btn-white btn btn-xs form-control" v-model='search.status'>
	                            		<option value=''>账号状态</option>
	                            		<option value="-1">{{ trans('staraccount.account_status-1')}}</option>
	                            		<option value="0">{{ trans('staraccount.account_status0')}}</option>
	                            		<option value="1">{{ trans('staraccount.account_status1')}}</option>
	                            		<option value="2">{{ trans('staraccount.account_status2')}}</option>
	                        		</select>
                                </div>
                                <div class="form-group">
                                    <select class="btn-white btn btn-xs form-control" v-model='search.grade'>
	                            		<option value=''>年级</option>
	                            		<option v-for='g in grades' :value="g">[[ g ]]</option>
	                        		</select>
                                </div>
                                <button v-on:click="doSearch()" class="btn btn-white">查询</button>
                                <button v-on:click="doCreateAccount()" class="btn btn-white">{{ trans('staraccount.ops_create') }}</button>
                    </form>
                </div>
            </div>
    </div>
	<div class="row">
		
		<div class="col-lg-12">
	    <div class="ibox">
	        <div class="ibox-content">
	            <table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15">
	                <thead>
	                    <tr>
	                        <th data-toggle="true" class="footable-visible footable-first-column footable-sortable footable-sorted">{{ trans('staraccount.column_id') }}</th>
	                        <th data-hide="phone" class="footable-visible footable-sortable">
	                        	{{ trans('staraccount.column_created_by') }}
	                        </th>
	                        <th data-hide="phone" class="footable-visible footable-sortable">
	                        	{{ trans('staraccount.column_star_account') }}
	                        </th>
	                        <th data-hide="phone" class="footable-visible footable-sortable">
	                        	{{ trans('staraccount.column_star_password') }}
	                        </th>
	                        <th data-hide="phone" class="footable-visible footable-sortable">
	                        	{{ trans('staraccount.column_grade') }}
	                        </th>
	                        <th data-hide="phone" class="footable-visible footable-sortable">
	                        	{{ trans('staraccount.column_status') }}
	                        </th>
	                        <th data-hide="phone" class="footable-visible footable-sortable">
	                        	{{ trans('staraccount.column_created_at') }}
	                        </th>
	                        <th data-hide="phone" class="footable-visible footable-sortable">
	                        	{{ trans('staraccount.column_updated_at') }}
	                        </th>
	                        <th class="text-right footable-visible footable-last-column" data-sort-ignore="true">{{ trans('staraccount.ops') }}</th></tr>
	                </thead>
	                <tbody>
	                	<tr v-if="result==null">
	                		<td colspan="9" class="text-center">数据加载中</td>
	                	</tr>
	                    <tr class="footable-even" style="display: table-row;" v-for="r in result.data" v-else>
	                        <td class="footable-visible footable-first-column">[[r.id]]</td>
	                        <td class="footable-visible">[[r.teacher_name]]</td>
	                        <td class="footable-visible">[[r.star_account]]</td>
	                        <td class="footable-visible">[[r.star_password]]</td>
	                        <td class="footable-visible">[[r.grade]]</td>
	                        <td class="footable-visible">
	                            <span class="label label-blue" v-if="r.status==-1">{{ trans('staraccount.account_status-1')}}</span>
	                            <span class="label label-primary" v-if="r.status==0">{{ trans('staraccount.account_status0')}}</span>
	                            <span class="label label-primary" v-if="r.status==1">{{ trans('staraccount.account_status1')}}</span>
	                            <span class="label label-danger" v-if="r.status==2">{{ trans('staraccount.account_status2')}}</span>
	                        </td>
	                        <td class="footable-visible">[[r.created_at]]</td>
	                        <td class="footable-visible">[[r.updated_at]]</td>
	                        <td class="text-right footable-visible footable-last-column">
	                            <div class="btn-group">
	                            	<select class="btn-white btn btn-xs" v-on:change="doChangeStatus(r.id,$event)">
	                            		<option >{{ trans('staraccount.ops_select_status')}}</option>
	                            		<option  value="-1">{{ trans('staraccount.account_status-1')}}</option>
	                            		<option  value="0">{{ trans('staraccount.account_status0')}}</option>
	                            		<option  value="2">{{ trans('staraccount.account_status2')}}</option>
	                            	</select>
	                            </div>
	                            <div class="btn-group">
	                            	<select v-on:change="doChangeGrade(r.id,$event)" class="btn-white btn btn-xs">
	                            		<option >{{ trans('staraccount.ops_select_grade')}}</option>
	                            		<option v-for="g in grades"  :value="[[ g ]]">[[ g ]]</option>
	                            	</select>
	                            </div>
	                            <div class="btn-group">
	                            	<button class="btn"  v-on:click="doResetPassword(r)">{{ trans('staraccount.ops_reset_password')}}</button>
	                            </div>
	                        </td>
	                    </tr>
	                </tbody>
	                <tfoot >
	                    <tr>
	                    	<td colspan="4">
	                    		<div class="pagination" >
	                    			当前[[result.current_page]]/[[result.last_page]]页 共[[result.total]]条记录
	                    		</div>
	                    	</td>
	                        <td colspan="5" class="footable-visible">
	                            <ul class="pagination pull-right"  v-if="result && result.last_page>1">
							    	<li v-if="result.current_page>1" v-on:click="dochangepage(1)"><a>«</a></li>
						    		<template v-for="p in result.last_page" v-if="Math.abs(result.current_page-(p+1))<=3">
						    			<li v-if="result.current_page==p+1" class="active" v-on:click="dochangepage(p+1)"><span>[[ p+1 ]]</span></li>
						    			<li v-else v-on:click="dochangepage(p+1)"><a>[[ p+1 ]]</a></li>
						    		</template>
							     	<li v-if="result.current_page < result.last_page" v-on:click="dochangepage(result.last_page)"><a>»</a></li>
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
var _accounts=new Vue({
	el:"body",
	data:{
		ajaxurls:{
				getAccounts:"{{ url('admin/staraccount/list') }}",
				createAccount:"{{ url('admin/staraccount/create') }}",
				changeStatus:"{{ url('admin/staraccount/changeStatus') }}",
				changeGrade:"{{ url('admin/staraccount/changeGrade') }}",
				resetPassword:"{{ url('admin/staraccount/resetPassword') }}"
		},
		search:{
			page:1,
			limit:10,
			status:'',
			order:'id',
			sort:'desc',
			grade:''
		},
		grades:['k','1','2','3','4','5','6','7','8','9','10','11','12'],
		result:null
	},
	methods:{
		doGetAccounts:function(){
			var _this=this;
			_this.result=null;
			$.ajax({
				url:_this.ajaxurls.getAccounts,
				type:"GET",
				data:_this.search,
				dataType:"json",
				success:function(json){
					_this.result=json;
				}
			});
		},
		doChangeStatus:function(aid,e){
			var _this=this;
			$.ajax({
				url:_this.ajaxurls.changeStatus,
				type:"GET",
				data:{account_id:aid,status:$(e.target).val()},
				dataType:"json",
				success:function(json){
					if(json.status){
						_this.doGetAccounts();
					}else{
						alert(json.error);
					}
				}
			});
		},
		doChangeGrade:function(aid,e){
			var _this=this;
			$.ajax({
				url:_this.ajaxurls.changeGrade,
				type:"GET",
				data:{account_id:aid,grade:$(e.target).val()},
				dataType:"json",
				success:function(json){
					if(json.status){
						_this.doGetAccounts();
					}else{
						alert(json.error);
					}
				}
			});
		},
		doCreateAccount:function(){
			var _this=this;
			$.ajax({
				url:_this.ajaxurls.createAccount,
				type:"GET",
				dataType:"json",
				success:function(json){
					if(json.status){
						_this.search.page=1;
						_this.search.status=-1;
						_this.doGetAccounts();
					}else{
						alert(json.error);
					}
				}
			});
		},
		doResetPassword:function(a){
			if(!confirm('请确认是否要重置'+a.star_account+'的密码!')){
				return;
			}
			var _this=this;
			$.ajax({
				url:_this.ajaxurls.resetPassword,
				type:"GET",
				dataType:"json",
				data:{account_id:a.id},
				success:function(json){
					if(json.status){
						_this.doGetAccounts();
					}else{
						alert(json.error);
					}
				}
			});
		},
		dochangepage:function(page){
			this.search.page=page;
			this.doGetAccounts();
		},
		doSearch:function(){
			this.search.page=1;
			this.doGetAccounts();
		}
	}
});
_accounts.doGetAccounts();
</script>
@endsection



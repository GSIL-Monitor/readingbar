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
                         <h5><i class="fa fa-file-text-o"></i>{{ trans('staraccountasign.head_title') }}</h5>
                    </div>
                    <form class="ibox-content form-inline" onsubmit="return false">
                                <div class="form-group">
                                   <input v-model='search.student_name'  class="form-control" placeholder="{{ trans('staraccountasign.column_student_name') }}">
                                </div>
                                <button v-on:click="doSearch()" class="btn btn-white">查询</button>
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
	                        <th data-toggle="true" class="footable-visible footable-first-column footable-sortable footable-sorted">{{ trans('staraccountasign.column_id') }}</th>
	                        <th data-hide="phone" class="footable-visible footable-sortable">
	                        	{{ trans('staraccountasign.column_created_by') }}
	                        </th>
	                        <th data-hide="phone" class="footable-visible footable-sortable">
	                        	{{ trans('staraccountasign.column_student_name') }}
	                        </th>
	                        <th data-hide="phone" class="footable-visible footable-sortable">	
	                        	{{ trans('staraccountasign.column_student_nickname') }}
	                        </th>
	                        <th data-hide="phone" class="footable-visible footable-sortable">
	                        	{{ trans('staraccountasign.column_student_grade') }}
	                        </th>
	                        <th data-hide="phone" class="footable-visible footable-sortable">
	                        	{{ trans('staraccountasign.column_star_account') }}
	                        </th>
	                        <th data-hide="phone" class="footable-visible footable-sortable">
	                        	{{ trans('staraccountasign.column_star_password') }}
	                        </th>
	                        <th data-hide="phone" class="footable-visible footable-sortable">
	                        	{{ trans('staraccountasign.column_asign_date') }}
	                        </th>
	                         <th data-hide="phone" class="footable-visible footable-sortable">
	                        	{{ trans('staraccountasign.column_notify_system') }}
	                        </th>
	                         <th data-hide="phone" class="footable-visible footable-sortable">
	                        	{{ trans('staraccountasign.column_notify_user') }}
	                        </th>
	                        <th class="text-right footable-visible footable-last-column" data-sort-ignore="true">{{ trans('staraccountasign.ops') }}</th></tr>
	                </thead>
	                <tbody>
	                	<tr v-if="result==null">
	                		<td colspan="9" class="text-center">数据加载中</td>
	                	</tr>
	                    <tr class="footable-even" style="display: table-row;" v-for="r in result.data"  v-else>
	                        <td class="footable-visible footable-first-column">[[r.id]]</td>
	                        <td class="footable-visible">[[r.teacher_name]]</td>
	                        <td class="footable-visible">[[r.student_name]]</td>
	                        <td class="footable-visible">[[r.student_nickname]]</td>
	                        <td class="footable-visible">[[r.grade]]</td>
	                        <td class="footable-visible">[[r.star_account]]</td>
	                        <td class="footable-visible">[[r.star_password]]</td>
	                        <td class="footable-visible">[[r.asign_date]]</td>
	                        <td class="footable-visible">
									<i class="fa fa-check" v-if="r.notify_system==1"></i>
									<i class="fa fa-close"  v-else></i>
							</td>
	                        <td class="footable-visible">
								 <i class="fa fa-check" v-if="r.notify_user==1"></i>
								<i class="fa fa-close"  v-else></i>
							</td>
	                        <td class="text-right footable-visible footable-last-column">
	                            <div class="btn-group form-inline">
	                            	
	                            	<select class="form-control" v-on:change="doAsign($event.target.value,r.student_id)">
	                            		<option>{{ trans('staraccountasign.ops_select_asign') }}</option>
	                            		<template v-for="s in selects">
	                            			<option  v-if="r.grade==s.grade"   :value="s.id">[[s.star_account]]</option>
	                            		</template>
	                            	</select>
	                            	<button class="btn btn-default" v-on:click="informParents(r.id)")>通知家长</button>
	                            </div>
	                        </td>
	                    </tr>
	                </tbody>
	                <tfoot v-if="result && result.total_pages>1">
	                    <tr>
	                        <td colspan="11" class="footable-visible">
	                            <ul class="pagination pull-right" >
							    	<li v-if="result.current_page>1" v-on:click="dochangepage(1)"><a>«</a></li>
						    		<template v-for="p in result.total_pages" v-if="Math.abs(result.current_page-(p+1))<=3">
						    			<li v-if="result.current_page==p+1" class="active" v-on:click="dochangepage(p+1)"><span>[[ p+1 ]]</span></li>
						    			<li v-else v-on:click="dochangepage(p+1)"><a>[[ p+1 ]]</a></li>
						    		</template>
							     	<li v-if="result.current_page < result.total_pages" v-on:click="dochangepage(result.total_pages)"><a>»</a></li>
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
				getApplies:"{{ url('admin/staraccountasign/appliesList') }}",
				getAccounts:"{{ url('admin/staraccountasign/accounts') }}",
				asign:"{{ url('admin/staraccountasign/asign') }}",
				informParentsUrl:"{{ url('admin/staraccountasign/informParents') }}"
		},
		search:{
			page:1,
			limit:10,
		},
		selects:null,
		result:null,
		informParentsStatus:false
	},
	methods:{
		doGetApplies:function(){
			var _this=this;
			_this.result=null;
			$.ajax({
				url:_this.ajaxurls.getApplies,
				type:"GET",
				data:_this.search,
				dataType:"json",
				success:function(json){
					if(json.status){
						_this.result=json;
					}else{
						alert(json.error);
					}
				}
			});
		},
		doGetAccounts:function(){
			var _this=this;
			$.ajax({
				url:_this.ajaxurls.getAccounts,
				type:"GET",
				dataType:"json",
				success:function(json){
					if(json.status){
						_this.selects=json.data;
					}else{
						alert(json.error);
					}
				}
			});
		},
		doAsign:function(aid,sid){
			if(!confirm("{{ trans('staraccountasign.confirm_asign') }}")){
				return;
			}
			var _this=this;
			$.ajax({
				url:_this.ajaxurls.asign,
				type:"GET",
				data:{account_id:aid,student_id:sid},
				dataType:"json",
				success:function(json){
					if(json.status){
						_this.doGetApplies();
						_this.doGetAccounts();
						alert(json.success);
					}else{
						alert(json.error);
					}
				}
			});
		},
		//通知家长
		informParents:function(sid){
			var _this=this;
			if(_this.informParentsStatus){
				return ;
			}else{
				if(confirm('是否确认发送通知？')){
					_this.informParentsStatus=true;
				}else{
					return;
				}
			}
			$.ajax({
				url:_this.ajaxurls.informParentsUrl,
				type:"GET",
				data:{student_id:sid},
				dataType:"json",
				success:function(json){
					if(json.status){
						_this.doGetApplies();
						_this.doGetAccounts();
						alert(json.success);
					}else{
						alert(json.error);
					}
					_this.informParentsStatus=false;
				},
				error:function(){
					_this.informParentsStatus=false;
				}
			});
		},
		dochangepage:function(page){
			this.search.page=page;
			this.doGetApplies();
		},
		doSearch:function(){
			this.search.page=1;
			this.doGetApplies();
		}
	}
});
_accounts.doGetApplies();
_accounts.doGetAccounts();
</script>
@endsection



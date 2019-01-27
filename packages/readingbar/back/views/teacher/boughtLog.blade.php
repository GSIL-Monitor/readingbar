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
<section class="wrapper wrapper-content animated fadeInRight"" id="mainContent"> 
	<div class='row'>
				<div class="alert alert-success alert-dismissible" v-if="OPmsg.status==true">
		                <button type="button" class="close"  v-on:click="OPmsg={}">×</button>
		                <i class="icon fa fa-check"></i>
		                [[ OPmsg.success ]]
		        </div>
		        <div class="alert alert-danger alert-dismissible" v-if="OPmsg.status==false">
		                <button type="button" class="close"  v-on:click="OPmsg={}">×</button>
		                <i class="icon fa fa-warning"></i>
						[[ OPmsg.error ]]
		        </div>
	   </div>
		<div class='row'>
			<div class="col-md-12">
				<div class="ibox float-e-margins">
	                        <div class="ibox-title">
	                            <h5> {{ trans('boughtLog.list_title') }}</h5>
	                        </div>
	                        <div class="ibox-content">
	                            <div class="row">
	                                <div class="col-sm-4">
	                                </div>
	                            </div>
	                            <div class="table-responsive">
	                                <table class="table table-striped">
	                                    <thead>
						                  <th v-for="d in thead">
						                 	<a href="javascript:void(0)" class="control-label order-[[ d.column]]" style="margin-bottom: 0px" v-on:click="orderBy(d.column)">
						                 		<i class="fa fa-sort"></i>
						                 		[[ d.text ]]
						                 	</a>
						                  </th>
						                  <th>{{ trans('boughtLog.columns.refund') }}</th>
						                </thead>
						                <tbody>
						                	 <tr v-if="list == null">
						                	 	<td colspan="13" class="text-center">数据加载中</td>
						                	 </tr>
							                 <tr v-for="d in list.data" v-else>
							                   <td>[[ d.id ]]</td>
							                   <td>[[ d.order_id ]]</td>
							                   <td>[[ d.total ]]</td>
							                   <td>[[ d.parent ]]</td>
							                   <td>[[ d.student ]]</td>
							                   <td>[[ d.star_account ]]</td>
							                   <td>[[ d.email ]]</td>
							                   <td>[[ d.cellphone ]]</td>
							                   <td>[[ d.product_name ]]</td>
							                   <td>[[ d.completed_at ]]</td>
							                   <td>
							                   		<template v-for="r in d.refunds">
							                   				<span v-if="r.order_type==1">{{ trans('boughtLog.columns.refund_type.1') }}：[[ Math.abs(r.total) ]]</span>
							                   				<br v-if="r.lenght>1">
							                   				<span v-if="r.order_type==2">{{ trans('boughtLog.columns.refund_type.2') }}：[[ Math.abs(r.total) ]]</span>
							                   		</template>
							                   </td>
							                </tr>
						                </tbody>
	                                </table>
	                            </div>
	                            <div class="row">
	                            	<div class="col-md-12">
	                            			 {{ trans('boughtLog.tip') }}
	                            	</div>
	                            </div>
								<div class="box-footer clearfix" >
									<div class="pagination pagination-sm no-margin" >
										当前[[ list.current_page ]]/[[ list.last_page ]]页 共[[ list.total ]]条记录
									</div>
									<ul class="pagination pagination-sm no-margin pull-right" v-if="list.last_page>1">
							            <li v-if="list.current_page==1" class="disabled"><span>&laquo;</span></li>
							            <li v-else><a href="javascript:void(0)" v-on:click="doChangePage(1)" rel="prev">&laquo;</a></li>
							    		<template v-for="page in list.last_page" v-if="Math.abs(list.current_page-page-1)<=3">
							    			<li v-if="list.current_page==page+1"  class="active"><span>[[ page+1 ]]</span></li>
							    			<li v-else><a href="javascript:void(0)" v-on:click="doChangePage(page+1)">[[ page+1 ]]</a></li>
							    		</template>
							            <li v-if="list.current_page==list.last_page" class="disabled"><span>&raquo;</span></li>
								        <li v-else><a href="javascript:void(0)" v-on:click="doChangePage(list.last_page)" rel="next">&raquo;</a></li>
								        <li>
						                 <input type="text"  v-model="goPage"/>
						                  <a href="javascript:void(0)" v-on:click="go()">Go</a>
						                </li>
								    </ul>
					            </div>	
					            
	                        </div>
	                    </div>
	             </div>
	    	</div>
	</section>
    <script type="text/javascript">
		var mainContent=new Vue({
			el:"#mainContent",
			data:{
				list:null,
				thead:[
				       {column:'id',text:"{{ trans('boughtLog.columns.id') }}"},
				       {column:'order_id',text:"{{ trans('boughtLog.columns.order_id') }}"},
				       {column:'total',text:"{{ trans('boughtLog.columns.total') }}"},
				       {column:'nickname',text:"{{ trans('boughtLog.columns.nickname') }}"},
				       {column:'nick_name',text:"{{ trans('boughtLog.columns.nick_name') }}"},
				       {column:'star_account',text:"{{ trans('boughtLog.columns.star_account') }}"},
				       {column:'email',text:"{{ trans('boughtLog.columns.email') }}"},
				       {column:'cellphone',text:"{{ trans('boughtLog.columns.cellphone') }}"},
				       {column:'product_name',text:"{{ trans('boughtLog.columns.product_name') }}"},
				       {column:'completed_at',text:"{{ trans('boughtLog.columns.completed_at') }}"}
				],
				search:{
					page:1,
					limit:10
				},
				searchReady:{
				},
				goPage:1,
				loading:{
					status:false,
					msg:''
				},
				OPmsg:{!! $OPmsg !!}
			},
			created:function(){
				this.doGetList();
			},
			methods:{
				//获取列表数据
				doGetList:function(){
					var _this=this;
					_this.list=null;
					$.ajax({
						url:"{{ url('admin/tstudents/'.$id.'/getboughtlog') }}",
						dataType:"json",
						data:_this.search,
						beforeSend:function(){
							_this.loading.status=true;
						},
						success:function(json){
							if (json.status === false) {
								appAlert({
									msg: json.error
								});
								_this.list = [];
							}else{
								_this.list=json;
							}
						},
						error:function(XMLHttpRequest, textStatus, errorThrown){
							_this.loading.status=false;
						},
						complete:function(){
							_this.loading.status=false;
						}
					});
				},
				//查询
				doSearch:function(){
					for(i in this.searchReady){
						this.search[i]=this.searchReady[i];
					}
					this.search.page=1;
					this.doGetList();
				},
				//翻页
				doChangePage:function(page){
					this.search.page=page;
					this.doGetList();
				},
				go: function () {
					this.doChangePage(this.goPage);
				},
				//排序
				orderBy:function(order){
					if(this.search.order==order){
						if(this.search.sort=='asc'){
							this.search.sort='desc';
						}else{
							this.search.sort='asc';
						}
					}else{
						this.search.sort='desc';
						this.search.order=order;
					}
					$('th a i').attr({'class':'fa fa-sort'});
					$('.order-'+order).find('i').attr({'class':'fa fa-sort-'+this.search.sort});
					this.doGetList();
				}
			}
		});
    </script>
@endsection



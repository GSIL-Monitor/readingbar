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
	                            <h5> {{ trans('bookStorageLog.list_title') }}</h5>
	                        </div>
	                        <div class="ibox-content">
	                            <div class="row">
	                                <div class="col-sm-8">
	                                    <form class="input-group" onsubmit="return false">
	                                    	<span class="input-group-btn">
	                                    		<select class="btn btn-sm btn-default"  v-model="searchReady.type">
	                                    			<option  v-for="t in types" :value="$key">[[ t ]]</option>
	                                    		</select>
	                                    	</span>
	                                        <input name="table_search" v-model='searchReady.keyword'  class="form-control input-sm" placeholder="Search" type="text">
	                                    	<span class="input-group-btn">
	                                    	    <select class="btn btn-sm btn-default"  v-model="searchReady.status">
	                                    			<option  v-for="s in status" :value="$key">[[ s ]]</option>
	                                    		</select>
	                                    		<select class="btn btn-sm btn-default"  v-model="searchReady.serial">
	                                    			<option  v-for="s in serial" :value="$key">[[ s ]]</option>
	                                    		</select>
	                                    		<button type="submit" class="btn btn-sm btn-default" v-on:click="doSearch()"><i class="fa fa-search"></i></button>
	                                        </span>
	                                     </form>
	                                </div>
	                            </div>
	                            <div class="table-responsive">
	                                <table class="table table-striped">
	                                    <thead>
						                  <th v-for="d in thead" >
						                  	<tempalte v-if="!d.order">
						                  		[[ d.text ]]
						                  	</tempalte>
						                 	<a href="javascript:void(0)" class="control-label order-[[ d.column]]" style="margin-bottom: 0px" v-on:click="orderBy(d.column)" v-else>
						                 		<i class="fa fa-sort"></i>
						                 		[[ d.text ]]
						                 	</a>
						                  </th>
						                </thead>
						                <tbody>
						                	 <tr v-if="list == null">
						                	 	<td colspan="13" class="text-center">数据加载中</td>
						                	 </tr>
							                 <tr v-for="d in list.data" v-else>
							                   <td>[[ d.id ]]</td>
							                   <td>[[ d.book_id ]]</td>
							                   <td class="col-md-3">[[ d.book_name ]]</td>
							                   <td>[[ d.ISBN ]]</td>
							                   <td>[[ d.serial ]]</td>
							                   <td>[[ d.status ]]</td>
							                   <td>[[ d.memo ]]</td>
							                   <td>[[ d.star_account ]]</td>
							                   <td>[[ d.operator ]]</td>
							                   <td>[[ d.created_at ]]</td>
							                </tr>
						                </tbody>
	                                </table>
	                            </div>
								<div class="box-footer clearfix">
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
								    		<input name="page">
								    		<a href="javascript:void(0)" v-on:click="goPage()" rel="next">Go</a>
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
					   {column:'id',text:"{{ trans('bookStorageLog.columns.id') }}",order:true},
				       {column:'book_id',text:"{{ trans('bookStorageLog.columns.book_id') }}",order:true},
				       {column:'book_name',text:"{{ trans('bookStorageLog.columns.book_name') }}",order:true},
				       {column:'ISBN',text:"{{ trans('bookStorageLog.columns.ISBN') }}",order:true},
				       {column:'serial',text:"{{ trans('bookStorageLog.columns.serial') }}",order:true},
				       {column:'status',text:"{{ trans('bookStorageLog.columns.status') }}",order:true},
				       {column:'memo',text:"{{ trans('bookStorageLog.columns.memo') }}",order:true},
				       {column:'star_account',text:"{{ trans('bookStorageLog.columns.star_account') }}",order:false},
				       {column:'operator',text:"{{ trans('bookStorageLog.columns.operator') }}",order:false},
				       {column:'created_at',text:"{{ trans('bookStorageLog.columns.created_at') }}",order:true}
				],
				search:{
					
					page:1,
					limit:10
				},
				searchReady:{
					
					status:0,
					type:0,
					serial:0
				},
				loading:{
					status:false,
					msg:''
				},
				types:{
					0:"{{ trans('bookStorageLog.btns.select_type') }}",
					ISBN:'ISBN',
					book_name:"{{ trans('bookStorageLog.columns.book_name') }}",
					memo:"{{ trans('bookStorageLog.columns.memo') }}",
					created_at:"{{ trans('bookStorageLog.columns.created_at') }}",	
					star_account: 	"{{ trans('bookStorageLog.columns.star_account') }}",
					ARQuizNo: 	"{{ trans('bookStorageLog.columns.ARQuizNo') }}",
				},
				status:{
					0:"{{ trans('bookStorageLog.btns.select_status') }}",
					1:"{{ trans('bookStorageLog.status.1') }}",
					2:"{{ trans('bookStorageLog.status.2') }}",
					3:"{{ trans('bookStorageLog.status.3') }}",
					4:"{{ trans('bookStorageLog.status.4') }}",
					5:"{{ trans('bookStorageLog.status.5') }}",
				},
				serial:{
					0:"{{ trans('bookStorageLog.btns.select_serial') }}",
					1:'01',
					2:'02',
					3:'03',
					4:'04',
					5:'05',
					6:'06',
					7:'07',
					8:'08',
					9:'09'
				},
				OPmsg:''
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
						url:"{{ url('admin/bookStorageLog/getLogs') }}",
						dataType:"json",
						data:_this.search,
						beforeSend:function(){
							_this.loading.status=true;
						},
						success:function(json){
							_this.list=json;
							_this.loading.status=false;
						},
						error:function(XMLHttpRequest, textStatus, errorThrown){
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
				},
				// 跳页
				goPage: function () {
					if (this.list) {
						var page = $("input[name='page']").val();
						if (page<=0) {
							this.search.page=1;
							$("input[name='page']").val(1)
						}else if (page > this.list.last_page) {
							this.search.page=this.list.last_page;
							$("input[name='page']").val(this.list.last_page)
						}else {
							this.search.page=page;
						}
						this.doGetList();
					}
				}
			}
		});
    </script>
@endsection



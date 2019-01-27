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
                    	  
                    	  <input class="form-control" v-model="search_ready.book_name" placeholder="书籍名称 ">  
                    	  <input class="form-control" v-model="search_ready.author" placeholder="作者 ">  
                    	  <input class="form-control" v-model="search_ready.publisher" placeholder="出版社 ">
                    	  <input class="form-control" v-model="search_ready.ISBN" placeholder="ISBN "> 
                    	  <input class="form-control" v-model="search_ready.BL" placeholder="Book Level区间（例:1-2） "> 
                    	  <select v-model="search_ready.type" class="form-control">
                          	<option selected value=''>书籍类型</option>
                          	<option value="Fiction">Fiction</option>
                          	<option value="Nonfiction">Nonfiction</option>
                          </select>
                    	  <select v-model="search_ready.IL" class="form-control">
	                          	<option selected value=''>IL类型 </option>
	                          	<option value="LG">LG</option>
	                          	<option value="MG">MG</option>
	                          	<option value="UG">UG</option>
	                          	<option value="MG+">MG+</option>
                          </select>
                    	  <select class="form-control" name="ARQuizType" v-model="search_ready.ARQuizType">
				                     		<option selected value="">Quiz 类型</option>
				                     		<option value="阅读">阅读</option>
				                     		<option value="阅读;词汇">阅读;词汇</option>
				                     		<option value="阅读;听力">阅读;听力</option>
				                     		<option value="阅读;读写">阅读;读写</option>
				                     		<option value="阅读;听力;词汇">阅读;听力;词汇</option>
				                     		<option value="阅读;读写;词汇">阅读;读写;词汇</option>
				                     		<option value="阅读;听力;读写">阅读;听力;读写</option>
				                     		<option value="阅读;听力;读写;词汇">阅读;听力;读写;词汇</option>
				          </select>
                    	  <input class="form-control" v-model="search_ready.ARQuizNo" placeholder="Quiz No."> 
                    	  <input class="form-control" v-model="search_ready.topic" placeholder="主题"> 
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
                        <h5><i class="fa fa-list-ul"></i>图书列表 </h5>
                </div>
		        <div class="ibox-content">
		        	
		            <table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15">
		             
		                <tbody>
		                	<tr class="footable-even" style="display: table-row;" v-if="list==null">
		                		<td col-span="13" class="footable-visible col-md-1 text-center">数据正在加载</td>
		                	</tr>
		                    <tr class="footable-even" style="display: table-row;" v-for="n in list.data" v-else>
		                    	<td class="footable-visible col-md-1 text-center">
		                    		<img alt="书籍封面" :src="n.image">
		                    	</td>
		                    	<td class="footable-visible col-md-11">
		                    		<h3 class='text-navy'>[[n.book_name]](￥[[n.price_rmb]])</h3>
		                    		<table class="table small m-b-xs">
				                        <tbody>
				                        	<tr>
					                            <td class="col-md-9" colspan="3">
					                                <strong>主题:</strong>[[n.topic]]
					                            </td>
					                            <td class="col-md-3">
					                                <strong>库存:</strong>
					                                <span class="badge badge-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="在库">[[ n.status1 ]]</span>
													<span class="badge badge-danger"  data-toggle="tooltip" data-placement="top" title="" data-original-title="借出">[[ n.status23 ]]</span>
													<span class="badge badge-warning" data-toggle="tooltip" data-placement="top" title="" data-original-title="锁定">[[ n.status4 ]]</span>
					                            </td>
					                        </tr>
					                        <tr>
					                            <td class="col-md-3">
					                                <strong>作者:</strong>[[n.author]]
					                            </td>
					                            <td class="col-md-3">
					                                <strong>ISBN:</strong>[[n.ISBN]]
					                            </td>
					                            <td class="col-md-3">
					                                <strong>出版社:</strong>[[n.publisher]]
					                            </td>
					                            <td class="col-md-3">
					                                <strong>书籍类型:</strong>[[n.type]]
					                            </td>
					                        </tr>
					                        <tr>
					                            <td class="col-md-3">
					                                <strong>BL:</strong>[[n.BL]]
					                            </td>
					                            <td class="col-md-3">
					                                <strong>IL:</strong>[[n.IL]]
					                            </td>
					                            <td class="col-md-3">
					                                <strong>ARQuizType:</strong>[[n.ARQuizType]]
					                            </td>
					                            <td class="col-md-3">
					                                <strong>ARQuizNo:</strong>[[n.ARQuizNo]]
					                            </td>
					                        </tr>
					                        
				                        </tbody>
				                    </table>
		                    	</td>
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
		list:{!! $books !!},
		search:{
			page:1,
			limit:10,
			ajaxStatus:false
		},
		search_ready:{
		},
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
			_this.list=null;
			$.ajax({
				url:"{{ url('admin/BookMonitoring/api/getList') }}",
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
$('[data-toggle=tooltip]').on('mouseover','',function(){
	$(this).tooltip('show');
});
</script>
@endsection



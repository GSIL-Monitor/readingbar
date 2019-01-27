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
	                            <h5>{{ trans('PointProduct.view_list') }}</h5>
	                        </div>
	                        <div class="ibox-content">
	                            <div class="row">
	                                <div class="col-sm-3">
	                                    <form class="input-group" onsubmit="return false">
	                                        <input name="table_search" v-model='searchReady.keyword'  class="form-control input-sm" placeholder="Search" type="text">
	                                    	<span class="input-group-btn">
	                                    		<button type="submit" class="btn btn-sm btn-default" v-on:click="doSearch()"><i class="fa fa-search"></i></button>
	                                        	<a class="btn btn-sm btn-default" href="{{ url('admin/PointProduct/form') }}"><i class="fa fa-plus"></i></a>
	                                        	<submit class="btn btn-sm btn-default" v-on:click="doDelete()"><i class="fa fa-trash"></i></submit>
	                                        </span>
	                                     </form>
	                                </div>
	                            </div>
	                            <div class="table-responsive">
	                                <table class="table table-striped">
	                                    <thead>
				                  <th style="width: 10px">
				                  	<input type="checkbox" class="minimal"  :checked="list.data && list.data.length==selected.length" v-on:click="selectedAll($event)">
				                  </th>
				                  <th>
				                 	<a href="javascript:void(0)" class="control-label order-id" style="margin-bottom: 0px" v-on:click="orderBy('id')">
				                 		<i class="fa fa-sort"></i>
				                 		{{ trans('PointProduct.columns.id') }}
				                 	</a>
				                  </th>
				                   <th>
				                 	<a href="javascript:void(0)" class="control-label order-product_name" style="margin-bottom: 0px" v-on:click="orderBy('product_name')">
				                 		<i class="fa fa-sort"></i>
				                 		{{ trans('PointProduct.columns.product_name') }}
				                 	</a>
				                  </th>
				                   <th>
				                 	<a href="javascript:void(0)" class="control-label order-image" style="margin-bottom: 0px" v-on:click="orderBy('image')">
				                 		<i class="fa fa-sort"></i>
				                 		{{ trans('PointProduct.columns.image') }}
				                 	</a>
				                  </th>
				                   <th>
				                 	<a href="javascript:void(0)" class="control-label order-desc" style="margin-bottom: 0px" v-on:click="orderBy('desc')">
				                 		<i class="fa fa-sort"></i>
				                 		{{ trans('PointProduct.columns.desc') }}
				                 	</a>
				                  </th>
				                  <th>
				                 	<a href="javascript:void(0)" class="control-label order-point" style="margin-bottom: 0px" v-on:click="orderBy('point')">
				                 		<i class="fa fa-sort"></i>
				                 		{{ trans('PointProduct.columns.point') }}
				                 	</a>
				                  </th>
				                  <th>
				                 	<a href="javascript:void(0)" class="control-label order-catagory" style="margin-bottom: 0px" v-on:click="orderBy('catagory')">
				                 		<i class="fa fa-sort"></i>
				                 		{{ trans('PointProduct.columns.catagory') }}
				                 	</a>
				                  </th>
				                  <th>
				                 	<a href="javascript:void(0)" class="control-label order-type" style="margin-bottom: 0px" v-on:click="orderBy('type')">
				                 		<i class="fa fa-sort"></i>
				                 		{{ trans('PointProduct.columns.type') }}
				                 	</a>
				                  </th>
				                  <th>
				                 	<a href="javascript:void(0)" class="control-label order-status" style="margin-bottom: 0px" v-on:click="orderBy('status')">
				                 		<i class="fa fa-sort"></i>
				                 		{{ trans('PointProduct.columns.status') }}
				                 	</a>
				                  </th>
				                  <th>
				                 	<a href="javascript:void(0)" class="control-label order-created_at" style="margin-bottom: 0px" v-on:click="orderBy('created_at')">
				                 		<i class="fa fa-sort"></i>
				                 		{{ trans('PointProduct.columns.created_at') }}
				                 	</a>
				                  </th>
				                  <th>
				                 	<a href="javascript:void(0)" class="control-label order-updated_at" style="margin-bottom: 0px" v-on:click="orderBy('updated_at')">
				                 		<i class="fa fa-sort"></i>
				                 		{{ trans('PointProduct.columns.updated_at') }}
				                 	</a>
				                  </th>
				                  <th>{{ trans('PointProduct.columns.operation') }}</th>
				                </thead>
					                <tbody>
					                	<tr v-if="list==null">
					                		<td colspan="13" class="text-center">正在加载数据</td>
					                	</tr>
						                 <tr v-for="d in list.data" v-else>
						                   <th style="width: 10px">
						                  	<input type="checkbox" class="minimal" v-model='selected' :value="d.id" >
						                   </th>
						                   <td>[[ d.id ]]</td>
						                   <td>[[ d.product_name ]]</td>
						                   <td><img alt="产品图"  :src="d.image" style="width: 50px;height:50px;" v-if="d.image"></td>
						                   <td>[[ d.desc ]]</td>
						                   <td>[[ d.point ]]</td>
						                   <td>[[ d.catagory ]]</td>
						                   <td>[[ d.type ]]</td>
						                   <td>[[ d.status ]]</td>
						                   <td>[[ d.created_at ]]</td>
						                   <td>[[ d.updated_at ]]</td>
						                   <td>
						                   		<a :href="d.edit" class="btn btn-default">{{ trans('PointProduct.btns.edit') }}</a>
						                   </td>
						                </tr>
					                </tbody>
	                                </table>
	                            </div>
								<div class="box-footer clearfix">
									<ul class="pagination pagination-sm no-margin pull-right" v-if="list.last_page>1">
							            <li v-if="list.current_page==1" class="disabled"><span>&laquo;</span></li>
							            <li v-else><a href="javascript:void(0)" v-on:click="doChangePage(1)" rel="prev">&laquo;</a></li>
							    		<template v-for="page in list.last_page">
							    			<li v-if="list.current_page==page+1"  class="active"><span>[[ page+1 ]]</span></li>
							    			<li v-else><a href="javascript:void(0)" v-on:click="doChangePage(page+1)">[[ page+1 ]]</a></li>
							    		</template>
							            <li v-if="list.current_page==list.last_page" class="disabled"><span>&raquo;</span></li>
								        <li v-else><a href="javascript:void(0)" v-on:click="doChangePage(list.last_page)" rel="next">&raquo;</a></li>
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
				list:{},
				selected:[],
				search:{
					page:1,
					limit:10
				},
				searchReady:{},
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
						url:"{{ url('admin/PointProduct/getList') }}",
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
				//删除
				doDelete:function(){
					var _this=this;
					$.ajax({
						url:"{{ url('admin/PointProduct/delete') }}",
						dataType:"json",
						data:{selected:_this.selected},
						type:"POST",
						beforeSend:function(){
							_this.loading.status=true;
						},
						success:function(json){
							_this.OPmsg=json;
							_this.doGetList();
							_this.loading.status=false;
						},
						error:function(XMLHttpRequest, textStatus, errorThrown){
							_this.loading.status=false;
						}
					});
				},
				//翻页
				doChangePage:function(page){
					this.search.page=page;
					this.doGetList();
				},
				//全选
				selectedAll:function(e){
					if(e.target.checked){
						this.selected=[];
						for(i in this.list.data){
							this.selected[i]=this.list.data[i]['id'];
						}
					}else{
						this.selected=[];
					}
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



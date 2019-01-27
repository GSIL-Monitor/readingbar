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
            
            <div class="col-lg-3">
                <div class="widget style1 navy-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-users fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span> {{ trans('teacher.unfinishedStarApplies') }} </span>
                            <h2 class="font-bold">{{ $unfinishedStarApplies }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
	            <a href="{{url('admin/readplan')}}" >
	                <div class="widget style1 lazur-bg">
	                    <div class="row">
	                        <div class="col-xs-4">
	                            <i class="fa fa-clipboard fa-5x"></i>
	                        </div>
	                        <div class="col-xs-8 text-right">
	                            <span> {{ trans('teacher.unfinishedReadPlans') }} </span>
	                            <h2 class="font-bold">{{ $unfinishedReadPlans }}</h2>
	                        </div>
	                    </div>
	                </div>
	             </a>
            </div>
            <div class="col-lg-3">
	            <a href="{{url('admin/messagesBox')}}">
	                <div class="widget style1 yellow-bg">
	                    <div class="row">
		                    
		                        <div class="col-xs-4">
		                            <i class="fa fa-envelope-o fa-5x"></i>
		                        </div>
		                        <div class="col-xs-8 text-right">
		                            <span> {{ trans('teacher.unansweredMessages') }} </span>
		                            <h2 class="font-bold"> {{ $unansweredMessages }}</h2>
		                        </div>
		                   
	                    </div>
	                </div>
	              </a>
            </div>
            <div class="col-lg-3">
                <div class="widget style1 blue-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-comments fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span> {{ trans('teacher.untreatedComments') }} </span>
                            <h2 class="font-bold"> {{ $untreatedComments }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ibox-content" id="mainContent">
	                            <div class="row">
	                                <div class="col-sm-4">
	                                    <form class="input-group"  onsubmit="return false">
	                                    	<span class="input-group-btn">
	                                    		<select class="btn btn-sm btn-default" v-model="searchReady.type">
	                                    			<option value="member">家长</option>
	                                    			<option value="star/_account">star账号</option>
	                                    		</select>
	                                        </span>
	                                        <input name="table_search" v-model='searchReady.keyword'  class="form-control input-sm" placeholder="Search" type="text">
	                                    	<span class="input-group-btn">
	                                    		<select class="btn btn-sm btn-default" v-model="searchReady.days">
	                                    			<option value="1">1天内</option>
	                                    			<option value="7">7天内</option>
	                                    			<option value="30">30天内</option>
	                                    		</select>
	                                    		<button type="submit" class="btn btn-sm btn-default" v-on:click="doSearch()"><i class="fa fa-search"></i></button>
	                                        </span>
	                                     </form>
	                                </div>
	                            </div>
	                            <div class="table-responsive">
	                                <table class="table table-striped">
	                                    <thead>
				                  <th>
				                 
				                 		家长
				                  </th>
				                   <th>
				                 
				                 		孩子
				                  </th>
				                   <th>
				                 	
				                 		孩子昵称
				                  </th>
				                     <th>
				                 	
				                 		star账号
				                  </th>
				                  <th>
				                 	
				                 		购买产品
				                  </th>
				                  <th>
				                 
				                 		购买日期
				                  </th>
				                 
				                </thead>
					                <tbody>
					                	<tr v-if="list==null">
					                		<td colspan=13 class="text-center">数据加载中</td>
					                	</tr>
						                 <tr v-for="d in list.data" v-else>
						                   <td>[[ d.parent ]]</td>
						                   <td>[[ d.student_name ]]</td>
						                   <td>[[ d.student_nickname ]]</td>
						                      <td>[[ d.star_account ]]</td>
						                   <td>[[ d.product_name ]]</td>
						                   <td>[[ d.completed_at ]]</td>
						                </tr>
					                </tbody>
	                                </table>
	                            </div>
								<div class="box-footer clearfix">
									<ul class="pagination pagination-sm no-margin pull-right" v-if="list.last_page>1">
							            <li v-if="list.current_page==1" class="disabled"><span>&laquo;</span></li>
							            <li v-else><a href="javascript:void(0)" v-on:click="doChangePage(1)" rel="prev">&laquo;</a></li>
							    		<template v-for="page in list.last_page"  v-if="Math.abs(page+1-list.current_page)<=3 ">
							    			<li v-if="list.current_page==page+1"  class="active"><span>[[ page+1 ]]</span></li>
							    			<li v-else><a href="javascript:void(0)" v-on:click="doChangePage(page+1)">[[ page+1 ]]</a></li>
							    		</template>
							            <li v-if="list.current_page==list.last_page" class="disabled"><span>&raquo;</span></li>
								        <li v-else><a href="javascript:void(0)" v-on:click="doChangePage(list.last_page)" rel="next">&raquo;</a></li>
								    </ul>
					            </div>	
	                        </div>
        </div>
        <script type="text/javascript">
        var mainContent=new Vue({
			el:"#mainContent",
			data:{
				list:null,
				search:{
					days:1,
					page:1,
					limit:10
				},
				searchReady:{
					type:"member",
					days:1
				},
				loading:{
					status:false,
					msg:''
				}
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
						url:"{{ url('admin/teacher/getBoughtInfo') }}",
						dataType:"json",
						data:_this.search,
						success:function(json){
							_this.list=json;
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
				}
			}
		});
		</script>
@endsection



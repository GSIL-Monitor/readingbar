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
	                            <h5>{{ trans('PointLog.view_list') }}</h5>
	                        </div>
	                        <div class="ibox-content">
	                            <div class="row">
	                                <div class="col-sm-4">
	                                    <form class="input-group" onsubmit="return false">
		                                    <span class="input-group-btn">
		                                    	<select class='btn btn-sm btn-default' style='padding-bottom: 6px' v-model='search.type'>
		                                        			<option value='member'>家长</option>
		                                        			<option value='student'>学生</option>
		                                        			<option value='starAccount'>star账号</option>
		                                       </select>
	                                       </span>
	                                        <input name="table_search" v-model='searchReady.keyword'  class="form-control input-sm" placeholder="Search" type="text">
	                                    	<span class="input-group-btn">
	                                    		<button type="submit" class="btn btn-sm btn-default" v-on:click="doSearch()"><i class="fa fa-search"></i></button>
	                                        	<a class="btn btn-sm btn-default" href="javascript:void(0)" v-on:click="showModal()"><i class="fa fa-plus"></i></a>
	                                        	
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
				                 		{{ trans('PointLog.columns.id') }}
				                 	</a>
				                  </th>
				                   <th>
				                 	<a href="javascript:void(0)" class="control-label order-member" style="margin-bottom: 0px" v-on:click="orderBy('member')">
				                 		<i class="fa fa-sort"></i>
				                 		{{ trans('PointLog.columns.member') }}
				                 	</a>
				                  </th>
				                   <th>
				                 	<a href="javascript:void(0)" class="control-label order-student" style="margin-bottom: 0px" v-on:click="orderBy('student')">
				                 		<i class="fa fa-sort"></i>
				                 		{{ trans('PointLog.columns.student') }}
				                 	</a>
				                  </th>
				                   <th>
				                 	<a href="javascript:void(0)" class="control-label order-student_point" style="margin-bottom: 0px" v-on:click="orderBy('student_point')">
				                 		<i class="fa fa-sort"></i>
				                 		{{ trans('PointLog.columns.student_point') }}
				                 	</a>
				                  </th>
				                   <th>
				                 	<a href="javascript:void(0)" class="control-label order-point" style="margin-bottom: 0px" v-on:click="orderBy('point')">
				                 		<i class="fa fa-sort"></i>
				                 		{{ trans('PointLog.columns.point') }}
				                 	</a>
				                  </th>
				                  <th>
				                 	<a href="javascript:void(0)" class="control-label order-memo" style="margin-bottom: 0px" v-on:click="orderBy('memo')">
				                 		<i class="fa fa-sort"></i>
				                 		{{ trans('PointLog.columns.memo') }}
				                 	</a>
				                  </th>
				                   <th>
				                 	<a href="javascript:void(0)" class="control-label order-status" style="margin-bottom: 0px" v-on:click="orderBy('status')">
				                 		<i class="fa fa-sort"></i>
				                 		{{ trans('PointLog.columns.status') }}
				                 	</a>
				                  </th>
				                  <th>
				                 	<a href="javascript:void(0)" class="control-label order-created_at" style="margin-bottom: 0px" v-on:click="orderBy('created_at')">
				                 		<i class="fa fa-sort"></i>
				                 		{{ trans('PointLog.columns.created_at') }}
				                 	</a>
				                  </th>
				                  <th>
				                 	<a href="javascript:void(0)" class="control-label order-updated_at" style="margin-bottom: 0px" v-on:click="orderBy('updated_at')">
				                 		<i class="fa fa-sort"></i>
				                 		{{ trans('PointLog.columns.updated_at') }}
				                 	</a>
				                  </th>
				                  <th>{{ trans('PointLog.columns.operation') }}</th>
				                </thead>
					                <tbody>
						                 <tr v-if="list" v-for="d in list.data">
						                   <th style="width: 10px">
						                  	<input type="checkbox" class="minimal" v-model='selected' :value="d.id" >
						                   </th>
						                   <td>[[ d.id ]]</td>
						                   <td>[[ d.member ]]</td>
						                   <td>[[ d.student ]]</td>
						                    <td>[[ d.student_point ]]</td>
						                   <td>[[ d.point ]]</td>
						                   <td>[[ d.memo ]]</td>
						                   <td>[[ d.status_text ]]</td>
						                   <td>[[ d.created_at ]]</td>
						                   <td>[[ d.updated_at ]]</td>
						                   <td>
						                   		<a  href="javascript:void(0)" class="btn btn-default" v-on:click='retractPoint(d.id)' v-if='d.status==0'>{{ trans('PointLog.btns.retract') }}</a>
						                   </td>
						                </tr>
					                </tbody>
	                                </table>
	                            </div>
								<div class="box-footer clearfix">
									<ul class="pagination pagination-sm no-margin pull-right" v-if="list.last_page>1">
							            <li v-if="list.current_page==1" class="disabled"><span>&laquo;</span></li>
							            <li v-else><a href="javascript:void(0)" v-on:click="doChangePage(1)" rel="prev">&laquo;</a></li>
							    		<template v-for="page in list.last_page" v-if="page-2< list.current_page && page+4 > list.current_page">
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
	    	<div class="modal inmodal" id="createLog" tabindex="-1" role="dialog" aria-hidden="true" style="display:none; padding-right: 17px;"> 
			   <div class="modal-dialog"> 
			    <div class="modal-content animated bounceInRight"> 
			     <div class="modal-header"> 
			      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> 
			     
			      <h4 class="modal-title">为学生授予积分</h4> 
			     </div> 
			     <div class="modal-body"> 
			     	<div class='row'>
			     		<label>学生</label>
			     			<div class="input-group">
		                                    <span class="input-group-btn">
		                                    	<select class='btn btn-sm btn-default' style='padding-bottom: 6px' v-model='giveForm.search_type'>
		                                        			<option value='member'>家长(手机/邮箱)</option>
		                                        			<option value='student'>学生(star账号)</option>
		                                       </select>
	                                       </span>
	                                        <input name="table_search" v-model='giveForm.search_value'  class="form-control input-sm" placeholder="Search" type="text">
	                                        <span class="input-group-btn">
	                                        	<button type="submit" class="btn btn-sm btn-default" v-on:click="doSearchStudent()"><i class="fa fa-search"></i></button>
	                                        </span>
	                	</div>
	                	<select class='form-control' v-model="giveForm.student_id">
			    			<option value=''>请选择学生</option>
			    			<option v-for='s in students'  :value='s.id'>[[ s.nick_name ]]</option>
			    		</select>
			    		<label>积分类型</label>
			    		<select class='form-control' v-model="giveForm.point_id" v-on:change="selectPt()">
			    			<option value=''>请选择积分类型</option>
			    			<option v-for='p in points'  :value='p.id'>[[ p.name ]]</option>
			    		</select>
			    		<label>积分数额（正数为增加积分，负数为扣除积分）</label>
			    		<input class='form-control' name='point' placeholder='积分数额' v-model="giveForm.point" >
			    		<label>备注</label>
			    		<textarea rows="" cols="" class='form-control'  v-model="giveForm.memo">
			    		</textarea>
			     	</div>
			    	
			     </div> 
			     <div class="modal-footer"> 
			      <button type="button" class="btn btn-white" data-dismiss="modal">取消</button> 
			      <button type="button" class="btn btn-primary" v-on:click="givePointToStudent()">确认</button> 
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
				points:{!! $points->toJson() !!},
				students:[],
				search:{
					type:'member',
					page:1,
					limit:10
				},
				giveForm:{
					search_type:'member',
					search_value:'',
					point_id:'',
					point:0,
					student_id:'',
					memo:'',
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
					$.ajax({
						url:"{{ url('admin/PointLog/getList') }}",
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
				},
				//显示创建记录弹出层
				showModal:function(){
					$('#createLog').modal('show');
				},
				//选择要授予的积分类型
				selectPt:function(p){
					for(i in this.points){
						if(this.giveForm.point_id==this.points[i].id){
							this.giveForm.point=this.points[i].point;
							return;
						}
					}
				},
				//检索要授予的学生
				doSearchStudent:function(){
					var _this=this;
					$.ajax({
						url:"{{ url('admin/PointLog/getStudents') }}",
						dataType:"json",
						data:{
							search_type:_this.giveForm.search_type,
							search_value:_this.giveForm.search_value,
						},
						beforeSend:function(){
							_this.loading.status=true;
						},
						success:function(json){
							if(json.status){
								_this.students=json.data;
							}else{
								alert(json.error);
							}
							_this.loading.status=false;
						},
						error:function(XMLHttpRequest, textStatus, errorThrown){
							_this.loading.status=false;
						}
					});
				},
				//授予积分
				givePointToStudent:function(){
					var _this=this;
					$.ajax({
						url:"{{ url('admin/PointLog/giveStudentPoint') }}",
						dataType:"json",
						type:'POST',
						data:_this.giveForm,
						beforeSend:function(){
							_this.loading.status=true;
						},
						success:function(json){
							if(json.status){
								_this.search.page=1;
								_this.doGetList();
								$('#createLog').modal('hide');
							}else{
								alert(json.error);
							}
							_this.loading.status=false;
						},
						error:function(XMLHttpRequest, textStatus, errorThrown){
							_this.loading.status=false;
						}
					});
				},
				//撤回给予的积分
				retractPoint:function(id){
					if(!confirm('确认撤回编号为'+id+'积分？！')){
						return;
					}
					var _this=this;
					$.ajax({
						url:"{{ url('admin/PointLog/retract') }}",
						dataType:"json",
						type:'POST',
						data:{id:id},
						beforeSend:function(){
							_this.loading.status=true;
						},
						success:function(json){
							if(json.status){
								_this.search.page=1;
								_this.doGetList();
								$('#createLog').modal('hide');
							}else{
								alert(json.error);
							}
							_this.loading.status=false;
						},
						error:function(XMLHttpRequest, textStatus, errorThrown){
							_this.loading.status=false;
						}
					});
				}
			}
		});
    </script>
@endsection



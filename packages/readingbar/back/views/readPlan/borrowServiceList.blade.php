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
<div class="wrapper wrapper-content animated fadeInRight" id="readPlanList">
	<!-- 搜索 -->
	 <div class="row">
             <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                         <h5><i class="fa fa-file-text-o"></i>条件搜索</h5>
                    </div>
                    <form class="ibox-content form-inline" onsubmit="return false">
                          <select v-model="search.status" class="form-control">
                          		<option selected value=''>计划状态</option>
                          		<option value='-1'>新建</option>
                          		<option value='0'>等待用户确认</option>
                          		<option value='1'>已确认</option>
                          		<option value='2'>已发货</option>
                          		<option value='3'>已收货</option>
                          		<option value='4'>已发回</option>
                          		<option value='5'>全部回收上架</option>
                          		<option value='6'>计划已过期</option>
                          		<option value='7'>部分回收上架</option>
                          </select>     
                          <input class="form-control" v-model="search.plan_name" placeholder="计划标识">
                          <input class="form-control" v-model="search.student_name" value="{{ $student?$student->name:''}}" placeholder="学生姓名">
                          <input class="form-control" v-model="search.star_account" value="{{ $student?$student->nick_name:''}}" placeholder="star账号">
                          <input class="form-control" v-model="search.courier_number" value="" placeholder="快递单号">
                          <button v-on:click="doGetReadPlans()" class="btn btn-white">搜索</button>
                          <a v-on:click="showModal()" class="btn btn-white">创建计划</a>
                    </form>
                </div>
            </div>
    </div>
	<!-- /搜索 -->
	<!-- 阅读计划列表  -->
	<div class="row">
		<div class="col-lg-12">
		    <div class="ibox">
		        <div class="ibox-content">
		            <table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15">
		                <thead>
		                    <tr>
		                        <th data-toggle="true" class="footable-visible footable-first-column footable-sortable footable-sorted">{{ trans('staraccount.column_id') }}</th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	阅读计划标识
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	学生
		                        </th>
		                         <th data-hide="phone" class="footable-visible footable-sortable">
		                        	star账号
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable" style="min-width: 200px">
		                        	快递单号
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	起始日期
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	结束日期
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	计划状态
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	创建日期
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	更新日期
		                        </th>
		                        <th class="text-right footable-visible footable-last-column" data-sort-ignore="true">操作</th></tr>
		                </thead>
		                <tbody>
		                    <tr class="footable-even" style="display: table-row;" v-for="r in readPlans.data">
		                        <td class="footable-visible footable-first-column">[[r.id]]</td>
		                        <td class="footable-visible">[[r.plan_name]]</td>
		                        <td class="footable-visible">[[r.student_name]]</td>
		                        <td class="footable-visible">[[r.star_account]]</td>
		                        <td class="footable-visible">
		                        	<div v-if="r.express_1">
		                        		【借出】<a v-on:click="getTraces(r.express_1)">[[r.express_1.logistic_code]]</a>
		                        	</div>
		                        	<div v-if="r.express_2">
		                        		【回收】<a v-on:click="getTraces(r.express_2)">[[r.express_2.logistic_code]]</a>
		                        	</div>
		                        </td>
		                        <td class="footable-visible">[[r.from]]</td>
		                        <td class="footable-visible">[[r.to]]</td>
		                        <td class="footable-visible">
		                        	<span class="label label-primary" v-if="r.status==-1">新建</span>
		                        	<span class="label label-primary" v-if="r.status==0">等待用户确认</span>
		                        	<span class="label label-primary" v-if="r.status==1">已确认</span>
		                        	<span class="label label-primary" v-if="r.status==2">已发货</span>
		                        	<span class="label label-primary" v-if="r.status==3">已收货</span>
		                        	<span class="label label-primary" v-if="r.status==4">已发回</span>
		                        	<span class="label label-primary" v-if="r.status==5">已收回</span>
		                        	<span class="label label-primary" v-if="r.status==6">已过期</span>
		                        	<span class="label label-primary" v-if="r.status==7">部分回收上架</span>
		                        </td>
		                        <td class="footable-visible">[[r.created_at]]</td>
		                        <td class="footable-visible">[[r.updated_at]]</td>
		                        <td class="footable-visible">
		                        	<button v-on:click="goReadPlanDetail(r)" class="btn btn-primary">查看详情</button>
		                        	<a :href="'{{ url('admin/teacher/starreport?student_name=') }}'+r.student_name" class="btn btn-primary" target="_blank">star评测</a>
		                        	<a :href="'{{ url('admin/tstudents/sessions?student_id=') }}'+r.student_id"  class="btn btn-primary" target="_blank">沟通记录</a>
		                        </td>
		                    </tr>
		                </tbody>
		                <tfoot v-if="readPlans && readPlans.total_pages>1">
		                    <tr>
		                        <td colspan="12" class="footable-visible">
		                            <ul class="pagination pull-right" >
								    	<li v-if="readPlans.current_page>1" v-on:click="doChangePage(1)"><a>«</a></li>
							    		<template v-for="p in readPlans.total_pages" v-if="Math.abs(readPlans.current_page-(p+1))<=3">
							    			<li v-if="readPlans.current_page==p+1" class="active" v-on:click="doChangePage(p+1)"><span>[[ p+1 ]]</span></li>
							    			<li v-else v-on:click="doChangePage(p+1)"><a>[[ p+1 ]]</a></li>
							    		</template>
								     	<li v-if="readPlans.current_page < readPlans.total_pages" v-on:click="doChangePage(readPlans.total_pages)"><a>»</a></li>
							     	</ul>
		                        </td>
		                    </tr>
		                </tfoot>
		            </table>
		        </div>
		    </div>
		</div>
	</div>
	<!-- /阅读计划列表  -->
	
  <div class="modal inmodal" id="CreateFormModal" tabindex="-1" role="dialog" aria-hidden="true" style="display:none; padding-right: 17px;"> 
   <div class="modal-dialog"> 
    <div class="modal-content animated bounceInRight"> 
     <div class="modal-header"> 
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> 
     
      <h4 class="modal-title">创建新计划</h4> 
     </div> 
     <div class="modal-body"> 
     		<form id="FTForm">
     				<input type="hidden" id="exampleInputEmail1" placeholder="Enter email">
     				<div class="form-group">
	                  <label for="exampleInputEmail1" class="control-label">学生筛选</label>
	                  <div class="input-group">
	                     <span class="input-group-btn">
							<select class="btn btn-default btn-md"  v-model="filter.type">
		                  		<option v-for="p in filter.options" :value="p.value">[[ p.text ]]</option>
		                  	</select>
						</span>
		                <input type="text" class="form-control" v-model="filter.text">
		              </div>
	                </div>
	     			<div class="form-group" id="for">
	                  <label for="exampleInputEmail1"  class="control-label">学生</label>
	                  <select class="form-control"  v-model="createForm.for">
	                  		<option v-for="s in student_options | filterStudent" :value="s.id">[[ s.nick_name ]]</option>
	                  </select>
	                </div>
	                <div class="form-group"  id="plan_name">
	                  <label for="exampleInputEmail1"  class="control-label">计划名称</label>
	                  <input type="text" class="form-control" v-model="createForm.plan_name">
	                </div>
     			  <div class="form-group" id="ft">
	                  <label for="exampleInputEmail1" class="control-label">起始和结束日期</label>
				      <div class="input-daterange input-group" id="datepicker" >
		                  <input type="text" v-model="readPlan.from" class="input-sm form-control" name="from" value="" v-model="createForm.from"/>
		                  <span class="input-group-addon">to</span>
		                  <input type="text" v-model="readPlan.to" class="input-sm form-control" name="to" value=""  v-model="createForm.to"/>
		        	  </div>
	                </div>
        	 </form>
     </div> 
     <div class="modal-footer"> 
      <button type="button" class="btn btn-white" data-dismiss="modal" >取消</button> 
      <button type="button" class="btn btn-primary" v-on:click="doCreate()">确认</button> 
     </div> 
    </div> 
   </div> 
  </div>
  
  
	  <div class="modal fade" id="tracesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	                <h4 class="modal-title" id="myModalLabel">物流跟踪</h4>
	            </div>
	            <div class="modal-body">
					<div class="row"  v-if="!traces && !tracesMessage">
						<div class="col-md-12 text-center" >
							<i class="fa fa-spin fa-refresh"></i>
						</div>
					</div>
					<div class="row" v-else-if="traces && （traces.State == 0 || traces.State == 4）">
						<div class="col-md-12 text-center" >
							[[ traces.Reason ]]
						</div>
					</div>
					<ul class="timeline" v-else-if="traces && (traces.State == 1 || traces.State == 2 || traces.State == 3)">
					    <li class="time-label" v-for='d in traces.Traces'>
					        <span class="bg-red">
					            [[ d.AcceptTime ]]
					        </span>
					        <div class="timeline-item">
					        	[[ d.AcceptStation ]]
					        </div>
					    </li>
					</ul>
					<div class="row" v-else-if = 'tracesMessage'>
						<div class="col-md-12 text-center" >
							[[ tracesMessage ]]
						</div>
					</div>
				</div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
	            </div>
	        </div><!-- /.modal-content -->
	    </div><!-- /.modal -->
	</div>
</div>

<script type="text/javascript">
var readPlanList=new Vue({
	el:"#readPlanList",
	data:{
		ajaxUrls:{
			//获取相关阅读计划
			getReadPlansUrl:"{{url('admin/api/readplan/getReadPlans')}}"
		},
		search:{
			type: 1,
			page:1,
			limit:10,
			order:'read_plan.created_at',
			sort:'desc'
		},
		createForm:{
			type: 1,
			plan_name: null,
			from: null,
			to: null,
			for: null
		},
		readPlans:null,
		student_options:  {!! $student_options !!},
		filter: {
			type: 'nick_name',
			options:[
					{value:'nick_name',text:'昵称'},{value:'cellphone',text:'手机号'},{value:'email',text:'邮箱'},{value:'star_account',text:'star账号'}
			],
			text: ''
		},
		traces: null,
		tracesMessage: null,
		tracesAjax:null
	},
	created:function () {
			var _this=this;
		  $('.input-daterange').datepicker({
				format:"yyyy-mm-dd",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
		}).on('changeDate', function(ev){
			switch (ev.target.name) {
				case 'from': 
					_this.createForm.from = $('input[name="from"]').val();
					break;
				case 'to': 
					_this.createForm.to = $('input[name="to"]').val();
					break;
			}
		});
	},
	methods:{
		//获取相关阅读计划
		doGetReadPlans:function(){
			var _this=this;
			$.ajax({
				url:_this.ajaxUrls.getReadPlansUrl,
				data:_this.search,
				dataType:"json",
				success:function(json){
					if(json.status){
						_this.readPlans=json;
					}else{
						alert(json.error);
					}
				}
			});
		},
		//翻页
		doChangePage:function(page){
			this.search.page=page;
			this.doGetReadPlans();
		},
		//跳转详情页
		goReadPlanDetail:function(r){
			window.location.href="{{url('admin/borrowService')}}"+'/'+r.id+'/detail';
		},
		// 获取物流信息
		getTraces : function (express) {
			var _this = this
			if (_this.tracesAjax) {
				_this.tracesAjax.abort();
			}
			_this.traces = null
			_this.tracesMessage = null
			$("#tracesModal").modal();
			_this.tracesAjax=$.ajax({
				url: "{{ url('admin/express/traces') }}/"+express.id,
				type: "get",
				dataType: 'json',
				success: function (json) {
					_this.traces = json
				},
				error: function (e){
					_this.tracesMessage = e.responseText.trim()
				}
			});
		},
		// 显示创建计划的modal
		showModal: function () {
			$("#CreateFormModal").modal('show');
		},
		// 创建计划
		doCreate: function () {
			var _this = this;
			$(".create-error-lable").remove();
			$(".has-error").removeClass('has-error');
			$.ajax({
				url: "{{ url('admin/api/readplan/createPlan') }}",
				type: "POST",
				dataType: 'json',
				data: _this.createForm,
				success: function (json) {
					if (json.status) {
						$('#CreateFormModal').modal('hide');
						appAlert({
							title:"提示",
							msg: json.success
						});
						_this.doGetReadPlans();
					} else {
						for(i in json.errors) {
							switch (i) {
								case 'plan_name':
									$("#plan_name").addClass('has-error');
									$("#plan_name").append("<lable class='control-label create-error-lable'>"+json.errors[i][0]+"</lable>");
									break;
								case 'for':
									$("#for").addClass('has-error');
									$("#for").append("<lable class='control-label create-error-lable'>"+json.errors[i][0]+"</lable>");
									break;
								case 'to':
								case 'from':
									$("#ft").addClass('has-error');
									$("#ft").append("<lable class='control-label create-error-lable'>"+json.errors[i][0]+"</lable>");
									break;
							}
						}
					}
				}
			});
		}
	},
	filters: {  
	    filterStudent: function (students) {
		    if (this.filter.text == '') {
				return students;
			} else {
				 var rStudents = [];
				var text = '';
			    switch (this.filter.type) {
			      case 'nick_name': 
						for (s in students) {
							if (students[s].nick_name && students[s].nick_name.indexOf(this.filter.text) >= 0) {
								rStudents[rStudents.length] = students[s];
							}
						}
			      break;
				  case 'cellphone':
				      for (s in students) {
							if (students[s].cellphone && students[s].cellphone.indexOf(this.filter.text) >= 0) {
								rStudents[rStudents.length] = students[s];
							}
						}
			      break;
			      case 'email':
			    	  for (s in students) {
							if (students[s].email && students[s].email.indexOf(this.filter.text) >= 0) {
								rStudents[rStudents.length] = students[s];
							}
						}
			      break;
			      case 'star_account': 
			    	  for (s in students) {
							if (students[s].star_account && students[s].star_account.indexOf(this.filter.text) >= 0) {
								rStudents[rStudents.length] = students[s];
							}
						}
			      break;
			      default: return false;
			    }
			    return rStudents;
			}
	    }  
	 } 
});
readPlanList.doGetReadPlans();
</script>
@endsection



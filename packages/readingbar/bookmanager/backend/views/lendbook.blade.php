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
		<!-- 阅读计划 -列表 -->
        <template id="rps" >
        	
	<div class="row">
		
		<div class="col-lg-12">
		    <div class="ibox">
		        <div class="ibox-content">
		            <table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15">
		                <thead>
		                    <tr>
		                        <th data-toggle="true" class="footable-visible footable-first-column footable-sortable footable-sorted">{{ trans('lendbook.column_id') }}</th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	{{ trans('lendbook.column_plan_name') }}
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	{{ trans('lendbook.column_from') }}
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	{{ trans('lendbook.column_to') }}
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	{{ trans('lendbook.column_star_account') }}
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	{{ trans('lendbook.column_student_name') }}
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	{{ trans('lendbook.column_teacher_name') }}
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	{{ trans('lendbook.column_read_plan_status') }}
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	{{ trans('lendbook.column_created_at') }}
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	{{ trans('lendbook.column_updated_at') }}
		                        </th>
		                        <th class="text-right footable-visible footable-last-column" data-sort-ignore="true">{{ trans('lendbook.ops') }}</th></tr>
		                </thead>
		                <tbody>
		                    <tr class="footable-even" style="display: table-row;" v-for="r in readPlans.data">
		                        <td class="footable-visible footable-first-column">[[r.id]]</td>
		                        <td class="footable-visible">[[r.plan_name]]</td>
		                        <td class="footable-visible">[[r.from]]</td>
		                        <td class="footable-visible">[[r.to]]</td>
		                        <td class="footable-visible">[[r.star_account.replace('readingbar','')]]</td>
		                        <td class="footable-visible">[[r.student_name]]</td>
		                        <td class="footable-visible">[[r.teacher_name]]</td>
		                        <td class="footable-visible">[[r.status]]</td>
		                        <td class="footable-visible">[[r.created_at]]</td>
		                        <td class="footable-visible">[[r.updated_at]]</td>
		                        <td class="footable-visible">
		                        	<a class="btn btn-primary" v-on:click="showDetail(r);">{{ trans('lendbook.ops_detail') }}</a>
		                        	<a class="btn btn-primary" v-on:click="doRefund(r.id);">{{ trans('lendbook.ops_refund') }}</a>
		                        </td>
		                    </tr>
		                </tbody>
		                <tfoot v-if="readPlans && readPlans.total_pages>1">
		                	
		                    <tr>
		                        <td colspan="10" class="footable-visible">
		                            <ul class="pagination pull-right" >
								    	<li v-if="readPlans.current_page>1" v-on:click="dochangepage(1)"><a>«</a></li>
							    		<template v-for="p in readPlans.total_pages" v-if="Math.abs(readPlans.current_page-(p+1))<=3">
							    			<li v-if="readPlans.current_page==p+1" class="active" v-on:click="dochangepage(p+1)"><span>[[ p+1 ]]</span></li>
							    			<li v-else v-on:click="dochangepage(p+1)"><a>[[ p+1 ]]</a></li>
							    		</template>
								     	<li v-if="readPlans.current_page < result.total_pages" v-on:click="dochangepage(readPlans.total_pages)"><a>»</a></li>
							     	</ul>
		                        </td>
		                    </tr>
		                </tfoot>
		            </table>
		        </div>
		    </div>
		</div>
	</div>
        	
        </template>
        <!-- /阅读计划 -列表 -->
        <!-- 阅读计划 -详情 -->
        <template id="rpd">
        	<div class="row">
            
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>{{ trans('lendbook.column_plan_detail') }}</h5>
                            <div class="ibox-tools">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-wrench"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li><a  v-on:click="lend()">借书</a></li>
                                    <li><a  v-on:click="back()">返回</a></li>
                                </ul>
                                <a class="close-link" v-on:click="back()">
                                    <i class="fa fa-times" ></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <h3>
                               {{ trans('lendbook.column_address') }}
                            </h3>
                            <p>
                               [[ readPlanDetail.address ]]
                            </p>
                            <table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15">
		                <thead>
		                    <tr>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	{{ trans('lendbook.column_book_name') }}
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	{{ trans('lendbook.column_serial') }}
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	{{ trans('lendbook.column_book_isbn') }}
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	BL
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	AR quiz number
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	{{ trans('lendbook.column_book_status') }}
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	{{ trans('lendbook.column_created_at') }}
		                        </th>
		                </thead>
		                <tbody>
		                    <tr class="footable-even" style="display: table-row;" v-for="r in readPlanDetail.details">
		                        <td class="footable-visible">[[r.book_name]]</td>
		                        <td class="footable-visible">[[r.serial]]</td>
		                        <td class="footable-visible">[[r.book_isbn]]</td>
		                        <td class="footable-visible">[[r.book_bl]]</td>
		                        <td class="footable-visible">[[r.book_arquizno]]</td>
		                        <td class="footable-visible">[[ status[r.status] ]]</td>
		                        <td class="footable-visible">[[r.created_at]]</td>
		                    </tr>
		                </tbody>
		                <tfoot>
		                	<tr>
								<td colspan="10" class="footable-visible">
									<span>
										<span>快递单号（借出）：
											<span v-if='readPlanDetail.express_1'>
													【[[ readPlanDetail.express_1.sender ]] to [[ readPlanDetail.express_1.receiver ]]】
													【[[ getCompany(readPlanDetail.express_1.shipper_code)]]】
													【[[ readPlanDetail.express_1.cost ]] 元】
													 [[readPlanDetail.express_1.logistic_code]]
												<a v-on:click="getTraces(readPlanDetail.express_1)">[物流跟踪]</a>
											</span>
											
										</span>
                                		<a  v-on:click="showSCNModal()">[编辑]</a>
                                	</span>
								</td>
		                    </tr>
		                </tfoot>
		            </table>
                        </div>
                    </div>
                </div>
            </div>
            
		  
		  
		    <div class="modal fade" id="SCNModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			    <div class="modal-dialog">
			        <div class="modal-content">
			            <div class="modal-header">
			                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			                <h4 class="modal-title" id="myModalLabel">快递表单</h4>
			            </div>
			            <div class="modal-body">
				            <form class="form-horizontal">
				              
						            <div class="form-group">
					                  <label for="inputEmail3" class="col-sm-2 control-label">发件人</label>
					                  <div class="col-sm-10">
					                    <input type="text" class="form-control" id="inputEmail3" placeholder="发件人" v-model="express.sender">
					                  </div>
					                </div>
					                 <div class="form-group">
					                  <label for="inputEmail3" class="col-sm-2 control-label">收件人</label>
					                  <div class="col-sm-10">
					                    <input type="text" class="form-control" id="inputEmail3" placeholder="收件人" v-model="express.receiver">
					                  </div>
					                </div>
					                <div class="form-group">
					                  <label for="inputEmail3" class="col-sm-2 control-label">快递类型</label>
					                  <div class="col-sm-10">
					                    <select class="form-control" v-model="express.type" disabled>
					                    	<option v-for='(key, d) in types'  :value="key">[[ d ]]</option>
					                    </select>
					                  </div>
					                </div>
					                 <div class="form-group">
					                  <label for="inputEmail3" class="col-sm-2 control-label">快递公司</label>
					                  <div class="col-sm-10">
					                    <select class="form-control" v-model="express.shipper_code" >
					                    	<option v-for='d in companies'  :value="d.express_code">[[ d.express_name ]]</option>
					                    </select>
					                  </div>
					                </div>
					                 <div class="form-group">
					                  <label for="inputEmail3" class="col-sm-2 control-label">快递单号</label>
					                  <div class="col-sm-10">
					                    <input type="text" class="form-control" id="inputEmail3" placeholder="快递单号" v-model="express.logistic_code">
					                  </div>
					                </div>
					                 <div class="form-group">
					                  <label for="inputEmail3" class="col-sm-2 control-label">快递金额</label>
					                  <div class="col-sm-10">
					                    <input type="text" class="form-control" id="inputEmail3" placeholder="快递金额" v-model="express.cost">
					                  </div>
					                </div>
					                 <div class="form-group">
					                  <label for="inputEmail3" class="col-sm-2 control-label">备注</label>
					                  <div class="col-sm-10">
					                    <input type="text" class="form-control" id="inputEmail3" placeholder="备注" v-model="express.memo">
					                  </div>
					                </div>
					
					
				            </form>
			            </div>
			            <div class="modal-footer">
			                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
			                
			                <button type="button" class="btn btn-primary" v-if="ajaxStatus.store"><i class="fa fa-refresh fa-spin"></i></button>
			                <button type="button" class="btn btn-primary" v-on:click="doStoreExpress()"  v-else>保存</button>
			            </div>
			        </div><!-- /.modal-content -->
			    </div><!-- /.modal -->
			    
			    	
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
		</template>
        <!-- /阅读计划 -详情 -->
        <rps v-if="currentView=='rps'" v-bind:read-plans="p_read_plans"></rps>
        <rpd v-if="currentView=='rpd'" v-bind:read-plan-detail="p_read_plan"></rpd>  
</div>
<script type="text/javascript">
Vue.component('rps',{ 
	template:"#rps",
	props: ['readPlans'],
	methods:{
		showDetail:function(rp){
			this.$parent.p_read_plan=rp;
			this.$parent.currentView='rpd';
		},
		dochangepage:function(page){
			this.$parent.search.page=page;
			this.$parent.getPlans();
		},
		doRefund:function(id){
			var _this=this;
			if(!confirm('确认退款？！')){
				return;
			}
			$.ajax({
					url:"{{url('admin/lendBook/refund')}}",
					type:'GET',
					data:{rpid:id},
					dataType:"json",
					success:function(json){
						if(json.status){
							alert(json.success);
							_this.$parent.getPlans();
						}else{
							alert(json.error);
						}
					}
			});
		}
	}
});
Vue.component('rpd',{ 
	template:"#rpd",
	props: ['readPlanDetail'],
	data () {
		return {
			status: {
				0:'等待用户确认',
				1:'用户已确认',
				2:'已发货',
				3:'已收货',
				4:'已锁定',
				5:'全部上架',
				6:'已过期',
				7:'部分上架'
			},
			express: {},
			companies: {!! $express_companies->toJson() !!},
			types: {
				1: '寄出',
				2: '寄回'
			},
			ajaxStatus:{
				store: false
			},
			traces: null,
			tracesMessage: null,
			tracesAjax:null
		}
	},
	created: function () {
		if (this.readPlanDetail.express_1) {
			this.express = this.readPlanDetail.express_1
		}else{
			this.express.type = 1
			this.express.plan_id = this.readPlanDetail.id
		}
	},
	methods:{
		lend:function(){
				var _this=this;
				$.ajax({
						url:"{{url('admin/lendBook/doLend')}}",
						type:'GET',
						data:{rpid:_this.readPlanDetail.id},
						dataType:"json",
						success:function(json){
							if(json.status){
								alert(json.success);
								_this.back();
								_this.$parent.getPlans();
							}else{
								alert(json.error);
							}
						}
				})
			},
		back:function(){
			this.$parent.currentView='rps';
		},
		//显示快递单号记录框
		showSCNModal:function(){
			$("#SCNModal").modal('show');
		},
		//记录快递单号
		doStoreExpress:function(){
			var _this = this;
			_this.ajaxStatus.store = true;
			$.ajax({
				url: "{{ url('admin/express/plan/store') }}",
				type: 'post',
				dataType: 'json',
				data: _this.express,
				success:function (json) {
					if (json.status) {
						_this.readPlanDetail.express_1 = _this.express
						$("#SCNModal").modal('hide');
					}else{
						$("#SCNModal").modal('hide');
						appAlert({
							msg: json.error,
							ok: {
								callback: function () {
									$("#SCNModal").modal({backdrop: 'static', keyboard: false});
								}
							}
						});
					}
				},
				complete: function () {
					_this.ajaxStatus.store = false;
				}
			});
		},
		getCompany : function (code) {
			for(var i in this.companies) {
				if (this.companies[i].express_code == code) {
					return this.companies[i].express_name;
				}
			}
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
		}
	}
});
new Vue({
	  el: 'body',
	  data: {
			currentView:"rps",
		    p_read_plans: 'Message from parent2312',
		    p_read_plan:'32323232',
		    search:{
				page:1,
				limit:10
			}
	  },
	  methods:{
			getPlans:function(){
				var _this=this;
				$.ajax({
						url:"{{url('admin/lendBook/getReadPlans')}}",
						type:'GET',
						data:_this.search,
						dataType:"json",
						success:function(json){
							if(json.status){
								_this.p_read_plans=json;
							}else{
								alert(json.error);
							}
						}
				})
			}
	  }
}).getPlans();
</script>
@endsection



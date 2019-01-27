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
    <div class="row" style="clear:both">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-content">
                            <div class="panel-body">
                                <div class="feed-activity-list" >
												<div class="row m-b-lg m-t-lg" style="border-bottom: 1px solid #e7eaec " >
										                <div class="col-md-6">
										
										                    <div class="profile-image">
										                        <img :src="student.avatar" class="img-circle circle-border m-b-md" alt="profile">
										                    </div>
										                    <div class="profile-info">
										                        <div class="">
										                            <div>
										                                <h2 class="no-margins">
										                                    [[student.name]]  
										                                    <font style="font-size:12px">（
										                                    <span>
								                                        		<font v-if="student.sex==0">女</font>
																				<font v-else>男</font>
							                                        		</span>
							                                        		/
							                                        		<span>[[student.age]]岁</span>
							                                        		）</font>                                                                
										                                </h2>
										                                                                                                       
										                                <h4>[[student.nick_name]]</h4>
										                                <small>                                                               
										                                	    偏好：
										                                	<templage v-for='i in student.favorite'>
						                                        				[[i]];
						                                        			</templage>
						                                        			<br>
						                                        			 地址：[[student.province+student.city+student.area+student.address]]
										                                </small>
										                            </div>
										                        </div>
										                    </div>
										                </div>
										                <div class="col-md-6">
										                    <table class="table small m-b-xs">
										                        <tbody>
										                        <tr>
										                            <td class='col-md-7' colspan='2'>
										                                <strong>学校:</strong> [[student.school_name]]
										                            </td>
																	<td class='col-md-5'>
																		<strong>年级:</strong>  [[student.grade]]
																	</td>	
										                        </tr>
										                        <tr>
										                        	
										                            <td>
										                                 <strong>star账号:</strong><strong style="color: #4bd2bf;">[[student.star_account]]</strong>
										                                 <br>
										                                 <strong>star密码:</strong><strong style="color: #4bd2bf;">[[student.star_password]]</strong>
										                            </td>
										                           	
										                             <td>
										                                <strong>最近购买产品:</strong>
										                                <div v-html="popoverBoughtLog($event,student.BoughtLog)"></div>
										                            </td>
										                            <td>
										                           		<i class='fa fa-list'></i> <strong>服务:</strong>
																		<div v-html="popoverServices($event,student)"></div>
										                            <td>
										                        </tr>
										                        <tr>
										                        	<td>
										                            	<strong>家长:</strong><strong>[[student.parent_name]]</strong>
										                            </td>
										                            <td>
										                                <strong>手机:</strong> [[student.parent_cellphone]]
										                            </td>
										                            <td>
										                                <strong>邮箱:</strong> [[student.parent_email]]
										                            </td>
										                            
										                        </tr>
										                        </tbody>
										                    </table>
										                </div>
										            </div> 
										    <h3>STAR评测数据：</h3>
										    <div class="row m-b-lg m-t-lg" style="border-bottom: 1px solid #e7eaec " >
												<table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15">
													<thead>
														<tr>
															<th class="footable-visible footable-sortable" data-hide="phone"></th>
															<th class="footable-visible footable-sortable" data-hide="phone">SS</th>
															<th class="footable-visible footable-sortable" data-hide="phone">PR</th>
															<th class="footable-visible footable-sortable" data-hide="phone">EST.OR</th>
															<th class="footable-visible footable-sortable" data-hide="phone">GE</th>
															<th class="footable-visible footable-sortable" data-hide="phone">IRL</th>
															<th class="footable-visible footable-sortable" data-hide="phone">ZPD</th>
															<th class="footable-visible footable-sortable" data-hide="phone">创建时间</th>
														</tr>
													</thead>
													<tbody>
														<tr v-for="r in reports">
															<td class="footable-visible footable-sortable" data-hide="phone">第[[ $index+1 ]]次</td>
															<td class="footable-visible footable-sortable" data-hide="phone">[[ r.ss ]]</td>
															<td class="footable-visible footable-sortable" data-hide="phone">[[ r.pr ]]</td>
															<td class="footable-visible footable-sortable" data-hide="phone">[[ r.estor ]]</td>
															<td class="footable-visible footable-sortable" data-hide="phone">[[ r.ge ]]</td>
															<td class="footable-visible footable-sortable" data-hide="phone">[[ r.irl ]]</td>
															<td class="footable-visible footable-sortable" data-hide="phone">[[ r.zpd ]]</td>	
															<td class="footable-visible footable-sortable" data-hide="phone">[[ r.created_at ]]</td>	
														</tr>
													</tbody>
												</table>
											</div>
											<h3>沟通记录：<a class='pull-right btn btn-default' v-on:click="setEdit()">新增</a></h3>
										    <div class="row m-b-lg m-t-lg" style="border-bottom: 1px solid #e7eaec " >
												<table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15">
													<thead>
														<tr>
															<th class="footable-visible footable-sortable" data-hide="phone">时间</th>
															<th class="footable-visible footable-sortable" data-hide="phone">沟通内容</th>
															<th class="footable-visible footable-sortable" data-hide="phone">沟通方式</th>
															<th class="footable-visible footable-sortable" data-hide="phone">操作</th>
														</tr>
													</thead>
													<tbody>
														<tr v-for="s in sessions">
															<td class="footable-visible footable-sortable" data-hide="phone">[[ s.time ]]</td>
															<td class="footable-visible footable-sortable" data-hide="phone">[[ s.content ]]</td>
															<td class="footable-visible footable-sortable" data-hide="phone">[[ s.type_name ]]</td>
															<td class="footable-visible footable-sortable" data-hide="phone">
																<a class='btn btn-default' v-on:click="setEdit(s)">编辑</a>
																<a class='btn btn-default' v-on:click="doDelete(s.id)">删除</a>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
				                 </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
     </div>
</div>
<!-- 沟通记录弹出层 -->     
  <div class="modal inmodal" id="SessionsModal" tabindex="-1" role="dialog" aria-hidden="true"> 
   <div class="modal-dialog"> 
    <div class="modal-content animated fadeIn"> 
     <div class="modal-header"> 
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> 
      <i class="fa fa-pencil-square-o modal-icon"></i> 
      <h4 class="modal-title">沟通记录表单</h4> 
     </div> 
     <div class="modal-body"> 
	     <div class="input-group col-md-12">
	     	<label>沟通日期</label>
	     	<input v-model="editSession.time" class="form-control date"  placeholder="沟通日期 ">
	     </div>
     	 <div class="input-group col-md-12">
	     	<label>沟通内容</label>
	     	<textarea v-model="editSession.content" class="form-control" placeholder="沟通内容 "></textarea>
	     </div>
	      <div class="input-group col-md-12">
	     	<label>沟通类型</label>
	     	<select v-model="editSession.type" class="form-control">
	     		<option selected>沟通类型</option>
		        <option v-for="t in types" :value="$key">[[ t ]]</option>
	     	</select>
	     </div>
     </div> 
     <div class="modal-footer"> 
      <button type="button" class="btn btn-white" data-dismiss="modal" v-on:click="doGetSessions()">取消</button> 
      <button v-on:click="doSubmit()" type="button" class="btn btn-primary" >保存</button> 
     </div> 
    </div> 
   </div> 
  </div> 
<link href="https://cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<script src="https://cdn.bootcss.com/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdn.bootcss.com/moment.js/2.18.1/locale/zh-cn.js"></script>
<script src="https://cdn.bootcss.com/bootstrap-datetimepicker/4.0.0/js/bootstrap-datetimepicker.min.js"></script>
<!-- /沟通记录弹出层 --> 
<script type="text/javascript">
 var _tstudents=new Vue({
		el:"body",
		data:{
				student:{!! $student !!},
				reports:{!! $reports !!},
				sessions:{!! $sessions !!},
				types:{!! $types !!},
				editSession:{
				}
		},
		created:function(){
			var _this=this;
			$('.date').datetimepicker({
				format: 'YYYY-MM-DD HH:mm:ss'
			}).on('changeDate', function(e){
	        	 _this.editSession=$(e.target).val();
	        });
		},
		methods:{
			//设置要编辑的内容
			setEdit:function(){
				if(arguments[0]){
					this.editSession=arguments[0];
				}else{
					this.editSession={};
				}
				this.showModal();
			},
			//获取sessions
			doGetSessions:function(){
				_this=this;
				$.ajax({
					url:"{{ url('admin/tstudents/getSessions') }}",
					data:_this.editSession,
					dataType:'json',
					type:'GET',
					success:function(json){
						_this.sessions=json;
					}
				});
				
			},
			//提交
			doSubmit:function(){
				_this=this;
				if(_this.editSession.id){
					var url="{{ url('admin/tstudents/updateSessions') }}";
				}else{
					var url="{{ url('admin/tstudents/createSessions') }}";
				}

				_this.editSession.student_id=_this.student.id;
				$.ajax({
					url:url,
					data:_this.editSession,
					dataType:'json',
					type:'POST',
					success:function(json){
						if(json.status){
							alert(json.success);
						}else{
							alert(json.error);
						}
						_this.hideModal();
						_this.doGetSessions();
					}
				});
			},
			doDelete:function(sid){
				_this=this;
				if(!confirm('删除后将不可恢复,确定是否删除?')){
					return;
				}
				$.ajax({
					url:"{{ url('admin/tstudents/deleteSessions') }}",
					data:{id:sid},
					dataType:'json',
					type:'POST',
					success:function(json){
						if(json.status){
							alert(json.success);
						}else{
							alert(json.error);
						}
						_this.doGetSessions();
					}
				});
			},
			//显示modal
			showModal:function(){
				$('#SessionsModal').modal({ show:true, backdrop:'static' });
			},
			//隐藏modal
			hideModal:function(){
				$('#SessionsModal').modal('hide');
			},
			//显示购买记录
			popoverBoughtLog: function(e,products){
				var content = ''
				for(i in products) {
					content = content+'<strong style="color: #4bd2bf;">'+products[i].product_name+'('+products[i].completed_at+')</strong><br>';
				}
				return content;
				$(e.target).popover({
					html:true,
					content: content,
					placement: 'top'
				}).popover('toggle');
			},
			//显示购买记录
			popoverServices: function(e,s){
				var content = ''
				for(i in s.services) {
					if (s.services[i].status) {
						if (s.freezeService) {
							content = content+'<strong style="color: red;">'+s.services[i].service_name+'('+s.services[i].expirated+')</strong><br>';
						} else {
							content = content+'<strong style="color: #4bd2bf;">'+s.services[i].service_name+'('+s.services[i].expirated+')</strong><br>';
						}
					}else {
						content = content+'<strong style="color: #c5c5c5;">'+s.services[i].service_name+'('+s.services[i].expirated+')</strong><br>';
					}
				}
				return content;
				$(e.target).popover({
					html:true,
					content: content,
					placement: 'top'
				}).popover('toggle');
			}
		}
	});
</script>
@endsection



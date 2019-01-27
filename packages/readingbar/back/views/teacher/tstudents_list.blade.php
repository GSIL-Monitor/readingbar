<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
             <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                         <h5><i class="fa fa-file-text-o"></i>学生检索</h5>
                    </div>
                    <form class="ibox-content form-inline" onsubmit="return false">
                                <div class="form-group">
                                    <input placeholder="家长昵称" v-model="search.parent" id="exampleInputEmail2" class="form-control" data-form-un="1476083165683.326" type="text">
                                </div>
                                <div class="form-group">
                                    <input placeholder="手机" v-model="search.cellphone" id="exampleInputEmail2" class="form-control" data-form-un="1476083165683.326" type="text">
                                </div>
                                <div class="form-group">
                                    <input placeholder="学生姓名" v-model="search.student_name" id="exampleInputEmail2" class="form-control" data-form-un="1476083165683.326" type="text">
                                </div>
                                <div class="form-group">
                                    <input placeholder="star账号" v-model="search.star_account" id="exampleInputEmail2" class="form-control" data-form-un="1476083165683.326" type="text">
                                </div>
                                <div class="form-group">
                                    <input placeholder="地区(如：上海，北京)" v-model="search.province" id="exampleInputEmail2" class="form-control" data-form-un="1476083165683.326" type="text">
                                </div>
                                  <div class="form-group">
                                    <select  v-model="search.grade" id="exampleInputEmail2" class="form-control" >
                                    	<option selected value="0">选择年级</option>
                                    	<option v-for="g in grades" :value="g">[[g]]</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select  v-model="search.group" id="exampleInputEmail2" class="form-control" >
                                    	<option selected value="">选择分组</option>
                                    	<option v-for="g in groups" :value="g.id">[[g.group_name]]</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select  v-model="search.payStatus" id="exampleInputEmail2" class="form-control" >
                                    	<option selected value="0">付款状态</option>
                                    	<option value="1">未付款</option>
                                    	<option value="2">已付款</option>
                                    </select>
                                </div>
                                <div class="input-daterange input-group" id="datepicker">
		                               <input type="text" class="input-sm form-control" v-model="search.from">
		                               <span class="input-group-addon">至</span>
		                               <input type="text" class="input-sm form-control" v-model="search.to">
		                         </div>
                                <button class="btn btn-white" v-on:click="doSearch()">查询</button>
                                <button class="btn btn-white" data-toggle="modal" data-target="#manageGroupModal">分组管理</button>
                    </form>
                </div>
            </div>
    </div>
    <div class="row" style="clear:both">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                        	<h5>{{ trans('tstudents.list_title') }}</h5>
                            <div class="ibox-tools">
	                        	<a class="btn btn-primary btn-xs"  href="{{url('admin/tstudents/exportStudents')}}"><i class="fa fa-download"></i>导出</a>
	                        </div>
                        </div>
                        <div class="ibox-content">
                            <div class="panel-body">
                                <div class="feed-activity-list" >
												<div class="row m-b-lg m-t-lg" style="border-bottom: 1px solid #e7eaec " v-for=" s in students.data">
										                <div class="col-md-6">
										
										                    <div class="profile-image">
										                        <img :src="s.avatar" class="img-circle circle-border m-b-md" alt="profile">
										                    </div>
										                    <div class="profile-info">
										                        <div class="">
										                            <div>
										                                <h2 class="no-margins">
										                                    [[s.name]]  
										                                    <font style="font-size:12px">（
										                                    <span>
								                                        		<font v-if="s.sex==0">女</font>
																				<font v-else>男</font>
							                                        		</span>
							                                        		/
							                                        		<span>[[s.age]]岁</span>
							                                        		）</font>                                                                
										                                </h2>
										                                                                                                       
										                                <h4>[[s.nick_name]]</h4>
										                                <small>                                                               
										                                	    偏好：
										                                	<templage v-for='i in s.favorite'>
						                                        				[[i]];
						                                        			</templage>
						                                        			<br>
						                                        			 地址：[[s.province+s.city+s.area+s.address]]
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
										                                <strong>学校:</strong> [[s.school_name]]
										                            </td>
																	<td class='col-md-5'>
																		<strong>年级:</strong>  [[s.grade]]
																	</td>	
										                        </tr>
										                        <tr>
										                        	
										                            <td>
										                                 <strong>star账号:</strong><strong style="color: #4bd2bf;">[[s.star_account]]</strong>
										                                 <br>
										                                 <strong>star密码:</strong><strong style="color: #4bd2bf;">[[s.star_password]]</strong>
										                            </td>
										                           	
										                             <td>
										                                <strong>购买记录:</strong>
										                                <div v-html="popoverBoughtLog($event,s.BoughtLog)"></div>
										                             </td>
										                            <td>
										                           		<i class='fa fa-list'></i> <strong>服务:</strong>
										                           		<a href="javascript:void(0)" class="btn btn-primary btn-xs" v-on:click="goBoughtLogDetails(s)">购买记录</a>
										                           		<div v-html="popoverServices($event,s)"></div>
																		       		
										                            <td>
										                        </tr>
										                        <tr>
										                        	<td>
										                            	<strong>家长:</strong><strong>[[s.parent_name]]</strong>
										                            </td>
										                            <td>
										                                <strong>手机:</strong> [[s.parent_cellphone]]
										                            </td>
										                            <td>
										                                <strong>邮箱:</strong> [[s.parent_email]]
										                            </td>
										                            
										                        </tr>
										                        </tbody>
										                    </table>
										                </div>
										                <div class="col-md-6" style="margin-left:120px;">
										                	<div class="actions">
				                                                <select v-model="s.group_id" v-on:change="doschangegroup(s.id,$event.target.value)" class="btn btn-xs btn-white">
				                                                	<option v-for="sg in groups" :value="sg.id">[[sg.group_name]]</option>
				                                                </select>
				                                                <a v-on:click="getSComments(s.id)" class="btn btn-xs btn-white"  data-toggle="modal" data-target="#SCommentsModal"><i class="fa fa-comment-o"></i> {{ trans('tstudents.students_comments') }}</a>
				                                                <a href="{{url('admin/readplan')}}?student_id=[[s.id]]" target="_blank" class="btn btn-xs btn-white"><i class="fa fa-graduation-cap"></i> {{ trans('tstudents.students_readplan') }}</a>
				                                                <a class="btn btn-xs btn-white" href="{{ url('admin/teacher/starreport?student_name=') }}[[ s.name ]]"><i class="fa fa-file-text-o"></i> {{ trans('tstudents.students_starsurvey') }}</a>
				                                            	<a :href="s.sessionsHref" class="btn btn-xs btn-white" ><i class="fa fa-comment-o"></i>沟通记录</a>
				                                            </div>
										                </div>
										            </div> 
				                                </div>
				                                <div class="row">
						                            <ul class="pagination pull-right" >
												    	<li v-if="students.current_page>1" v-on:click="doChangePage(1)"><a>«</a></li>
											    		<template v-for="p in students.last_page" v-if="Math.abs(students.current_page-(p+1))<=3">
											    			<li v-if="students.current_page==p+1" class="active" v-on:click="doChangePage(p+1)"><span>[[ p+1 ]]</span></li>
											    			<li v-else v-on:click="doChangePage(p+1)"><a>[[ p+1 ]]</a></li>
											    		</template>
												     	<li v-if="students.current_page < students.last_page" v-on:click="doChangePage(students.last_page)"><a>»</a></li>
											     	</ul>
										     	</div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
<!-- 分组管理弹出层 -->     
  <div class="modal inmodal" id="manageGroupModal" tabindex="-1" role="dialog" aria-hidden="true"> 
   <div class="modal-dialog"> 
    <div class="modal-content animated fadeIn"> 
     <div class="modal-header"> 
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> 
      <i class="fa fa-pencil-square-o modal-icon"></i> 
      <h4 class="modal-title">分组管理</h4> 
     </div> 
     <div class="modal-body"> 
     
     	<table class="table">
             <thead>
                            <tr>
                                <th>分组名称</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="g in groups">
                                <td class="col-md-6">[[ g.group_name]]</td>
                                <td class="col-md-6">
                                	<button class="btn btn-primary" v-on:click="showGroupModal('edit',g)">重命名</button>
                                	<button class="btn btn-primary" v-on:click="doremovegroup(g.id)">移除</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
        <button class="btn btn-primary col-md-12" v-on:click="showGroupModal('new')">新建分组</button>     
       	          
     </div> 
     <div class="modal-footer"> 
      	<button type="button" class="btn btn-white" data-dismiss="modal">{{ trans('favorites.close') }}</button>
     </div> 
    </div> 
   </div> 
  </div> 
<!-- /分组管理弹出层 -->            
<!-- 分组新增弹出层 -->     
  <div class="modal inmodal" id="newgroupModal" tabindex="-1" role="dialog" aria-hidden="true"> 
   <div class="modal-dialog"> 
    <div class="modal-content animated fadeIn"> 
     <div class="modal-header"> 
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> 
      <i class="fa fa-pencil-square-o modal-icon"></i> 
      <h4 class="modal-title">{{ trans('tstudents.newgroup') }}</h4> 
     </div> 
     <div class="modal-body"> 
     	<input v-model="newgroup.group_name" class="form-control">
     </div> 
     <div class="modal-footer"> 
      <button type="button" class="btn btn-white" data-dismiss="modal">{{ trans('favorites.close') }}</button> 
      <button v-on:click="donewgroup()" type="button" class="btn btn-primary" v-on:click="docomment">{{ trans('favorites.save') }}</button> 
     </div> 
    </div> 
   </div> 
  </div> 
<!-- /分组新增弹出层 --> 
<!-- 分组重命名弹出层 -->    
   <div class="modal inmodal" id="renamegroupModal" tabindex="-1" role="dialog" aria-hidden="true"> 
   <div class="modal-dialog"> 
    <div class="modal-content animated fadeIn"> 
     <div class="modal-header"> 
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> 
      <i class="fa fa-pencil-square-o modal-icon"></i> 
      <h4 class="modal-title">{{ trans('tstudents.renamegroup') }}</h4> 
     </div> 
     <div class="modal-body"> 
     	<input v-model="renamegroup.group_name" class="form-control">
     </div> 
     <div class="modal-footer"> 
      <button type="button" class="btn btn-white" data-dismiss="modal">{{ trans('favorites.close') }}</button> 
      <button v-on:click="dorenamegroup()" type="button" class="btn btn-primary" v-on:click="docomment">{{ trans('favorites.save') }}</button> 
     </div> 
    </div> 
   </div> 
  </div>   
 <!-- /分组重命名弹出层 -->
<!-- 学生评论弹出层 -->    
   <div class="modal inmodal" id="SCommentsModal" tabindex="-1" role="dialog" aria-hidden="true"> 
   <div class="modal-dialog"> 
    <div class="modal-content animated fadeIn"> 
     <div class="modal-header"> 
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> 
      <i class="fa fa-comment-o modal-icon"></i> 
      <h4 class="modal-title">{{ trans('tstudents.students_comments') }}</h4> 
     </div> 
     <div class="modal-body" >
     		<div class="feed-activity-list" v-if="scomments!=null">
			  <div class="feed-element" v-for=" sc in scomments" >
			  	<a href="#" class="pull-left">
                     <img alt="image" class="img-circle" :src="sc.avatar">
                </a>
			    <div class="media-body ">
			      <h4><strong>{{ trans('tstudents.text_book') }}:[[sc.book_name]]</strong></h4>
			      <strong>[[sc.comment]]</strong>
			      <br>
			      <small class="text-muted">[[sc.created_at]]</small>
			      <div class="actions">
			        <a class="btn btn-xs btn-success" v-if="sc.status=='confirm'">
			          {{ trans('tstudents.comment_status_confirm') }}
			        </a>
			        <a class="btn btn-xs btn-danger" v-if="sc.status=='close'">
			          {{ trans('tstudents.comment_status_close') }}
			        </a>
			        <a class="btn btn-xs btn-white" v-if="sc.status=='open'">
			          {{ trans('tstudents.comment_status_open') }}
			        </a>
			        <select class="btn btn-xs btn-white">
			           <option>{{ trans('tstudents.openrations') }}</option>
				       <option v-on:click="doExamineSComment(sc,'confirm')">{{ trans('tstudents.comment_status_confirm') }}</option>
				       <option v-on:click="doExamineSComment(sc,'close')">{{ trans('tstudents.comment_status_close') }}</option>
				    </select>                                         	
			      </div>
			    </div>
			  </div>
			</div>
			<p v-else>{{ trans('tstudents.message_notdata') }}</p>
     </div> 
     <div class="modal-footer"> 
      <button type="button" class="btn btn-white" data-dismiss="modal">{{ trans('favorites.close') }}</button> 
     </div> 
    </div> 
   </div> 
  </div>   
 <!-- /学生评论弹出层 -->
 <!-- 学生评论弹出层 -->    
   <div class="modal inmodal" id="SCommentsModal" tabindex="-1" role="dialog" aria-hidden="true"> 
   <div class="modal-dialog"> 
    <div class="modal-content animated fadeIn"> 
     <div class="modal-header"> 
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> 
      <i class="fa fa-comment-o modal-icon"></i> 
      <h4 class="modal-title">{{ trans('tstudents.students_comments') }}</h4> 
     </div> 
     <div class="modal-body" >
     		<div class="feed-activity-list" v-if="scomments!=null">
			  <div class="feed-element" v-for=" sc in scomments" >
			  	<a href="#" class="pull-left">
                     <img alt="image" class="img-circle" :src="sc.avatar">
                </a>
			    <div class="media-body ">
			      <h4><strong>{{ trans('tstudents.text_book') }}:[[sc.book_name]]</strong></h4>
			      <strong>[[sc.comment]]</strong>
			      <br>
			      <small class="text-muted">[[sc.created_at]]</small>
			      <div class="actions">
			        <a class="btn btn-xs btn-success" v-if="sc.status=='confirm'">
			          {{ trans('tstudents.comment_status_confirm') }}
			        </a>
			        <a class="btn btn-xs btn-danger" v-if="sc.status=='close'">
			          {{ trans('tstudents.comment_status_close') }}
			        </a>
			        <a class="btn btn-xs btn-white" v-if="sc.status=='open'">
			          {{ trans('tstudents.comment_status_open') }}
			        </a>
			        <select class="btn btn-xs btn-white">
			           <option>{{ trans('tstudents.openrations') }}</option>
				       <option v-on:click="doExamineSComment(sc,'confirm')">{{ trans('tstudents.comment_status_confirm') }}</option>
				       <option v-on:click="doExamineSComment(sc,'close')">{{ trans('tstudents.comment_status_close') }}</option>
				    </select>                                         	
			      </div>
			    </div>
			  </div>
			</div>
			<p v-else>{{ trans('tstudents.message_notdata') }}</p>
     </div> 
     <div class="modal-footer"> 
      <button type="button" class="btn btn-white" data-dismiss="modal">{{ trans('favorites.close') }}</button> 
     </div> 
    </div> 
   </div> 
  </div>   
 <!-- /学生评论弹出层 -->
</div>
	<script src="{{ asset('assets/js/plugins/d3/d3.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/c3/c3.min.js') }}"></script>
<script type="text/javascript">

 var _tstudents=new Vue({
		el:"body",
		data:{
				students:null,
				groups:null,
				showgroup:'all',
				selectgroup:null,
				newgroup:{group_name:null},
 				renamegroup:{group_id:null,group_name:null},
 				scomments:null,
 				grades:[1,2,3,4,5,6,7,8,9,10,11,12,'k'],
 				search:{
					page:1,
					limit:10
 	 			}
		},
		created: function () {
			var _this = this
			_this.dateRange=$('.input-daterange').datepicker({
				format:"yyyy-mm-dd",
			    keyboardNavigation: false,
			    forceParse: false,
			    autoclose: true
			});
		},
		methods:{
				//获取学生信息
				getstudents:function(){
						var _this=this;
						$.ajax({
								url:"{{url('admin/tstudents/tstudents')}}",
								type:"GET",
								data:_this.search,
								dataType:"json",
								success:function(json){
									if(json.status){
										_this.students=json.data;
									}else{
										alert(json.msg);
									}
								}
							});
					},
				//获取分组信息
				getgroups:function(){
						var _this=this;
						$.ajax({
								url:"{{url('admin/tstudents/stgroups')}}",
								type:"GET",
								data:null,
								dataType:"json",
								success:function(json){
									if(json){
										_this.groups=json.data;
									}else{
										alert(json.msg);
									}
								}
							});
				},
				//分组显示切换
				changegrouptab:function(gid){
					this.showgroup=gid;
				},
				//学生转移分组
				doschangegroup:function(sid,gid){
					if(!confirm("{{ trans('tstudents.change_student_group_confirm') }}")){
						return;
					}
					var _this=this;
					$.ajax({
						url:"{{url('admin/tstudents/schanggroup')}}",
						type:"POST",
						data:{student_id:sid,group_id:gid},
						dataType:"json",
						success:function(json){
							if(json.status){
								_this.newgroup.group_name=null;
								_this.getstudents();
							}else{
								alert(json.msg);
							}
							$("#newgroupModal").modal('hide');
						}
					});
				},
				//显示分组弹出层
				showGroupModal:function(){
					switch(arguments[0]){
						case 'new':$("#newgroupModal").modal('show');$("#manageGroupModal").modal('hide');break;
						case 'edit':this.renamegroup.group_name=arguments[1].group_name;
									this.renamegroup.group_id=arguments[1].id;
									$("#renamegroupModal").modal('show');
									$("#manageGroupModal").modal('hide');
					}
					
				},
				//新建分组
				donewgroup:function(){
					var _this=this;
					if(_this.newgroup.group_name==null){
						alert("{{ trans('tstudents.error_group_name_notid') }}");
						return;
					}
					$.ajax({
							url:"{{url('admin/tstudents/newgroup')}}",
							type:"POST",
							data:_this.newgroup,
							dataType:"json",
							success:function(json){
								if(json.status){
									_this.newgroup.group_name=null;
									_this.getgroups();
								}else{
									alert(json.msg);
								}
								$("#newgroupModal").modal('hide');
							}
					});
				},
				//删除分组
				doremovegroup:function(group_id){
					if(!confirm("{{ trans('tstudents.remove_group_confirm') }}")){
						return;
					}
					var _this=this;
					$.ajax({
						url:"{{url('admin/tstudents/removegroup')}}",
						type:"POST",
						data:{group_id:group_id},
						dataType:"json",
						success:function(json){
							if(json.status){
								_this.getgroups();
								_this.getstudents();
							}else{
								alert(json.msg);
							}
						}
					});
				},
				//重名名弹出层弹出前获取要修改的数据
				getGroupBeforeRename:function(group){
					this.renamegroup.group_name=group.group_name;
					this.renamegroup.group_id=group.id;
				},
				//重名名分组
				dorenamegroup:function(){
					var _this=this;
					if(_this.renamegroup.group_id==null){
						alert("{{ trans('tstudents.error_group_id_notnull') }}");
						return;
					}else if(_this.renamegroup.group_name==null){
						alert("{{ trans('tstudents.error_group_name_notnull') }}");
						return;
					}
					$.ajax({
						url:"{{url('admin/tstudents/renamegroup')}}",
						type:"POST",
						data:_this.renamegroup,
						dataType:"json",
						success:function(json){
							if(json.status){
								_this.renamegroup.group_name=null;
								_this.renamegroup.group_id=null;
								_this.getgroups();
							}else{
								alert(json.msg);
							}
							$("#renamegroupModal").modal('hide');
						}
					});
				},
				//学生评论数据
				getSComments:function(sid){
					var _this=this;
					$.ajax({
						url:"{{url('admin/tstudents/SComments')}}",
						type:"GET",
						data:{student_id:sid},
						dataType:"json",
						success:function(json){
							if(json.status){
								if(json.data.length){
									_this.scomments=json.data;
								}else{
									_this.scomments=null;
								}
							}else{
								alert(json.msg);
							}
						}
					});
				},
				//审核学生评论
				doExamineSComment:function(sc,status){
					var _this=this;
					$.ajax({
						url:"{{url('admin/tstudents/examineSComment')}}",
						type:"POST",
						data:{scid:sc.id,status:status},
						dataType:"json",
						success:function(json){
							if(json.status){
								sc.status=status;
							}else{
								alert(json.msg);
							}
						}
					});
				},
				//条件检索
				doSearch:function(){
					this.search.page=1;
					this.getstudents();
				},
				//翻页
				doChangePage:function(page){
					this.search.page=page;
					this.getstudents();
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
				// 查看购买记录详情
				goBoughtLogDetails : function(s){
					var url = "{{url('admin/tstudents/id/boughtlog')}}";
					window.location.href = url.replace('id',s.id);
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
 _tstudents.getstudents();
 _tstudents.getgroups();
</script>



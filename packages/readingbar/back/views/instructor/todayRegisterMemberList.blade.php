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
             <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                         <h5><i class="fa fa-file-text-o"></i>学生检索</h5>
                    </div>
                    <div class="ibox-content form-inline">
                    			<div class="input-daterange input-group" id="datepicker">
		                               <input type="text" class="input-sm form-control" v-model="search.from">
		                               <span class="input-group-addon">至</span>
		                               <input type="text" class="input-sm form-control" v-model="search.to">
		                         </div>
                                <div class="form-group">
                                    <input placeholder="家长昵称" v-model="search.parent" id="exampleInputEmail2" class="form-control" data-form-un="1476083165683.326" type="text">
                                </div>
                                <div class="form-group">
                                    <input placeholder="学生姓名" v-model="search.student_name" id="exampleInputEmail2" class="form-control" data-form-un="1476083165683.326" type="text">
                                </div>
                                <div class="form-group">
                                    <input placeholder="学生昵称" v-model="search.student_nickname" id="exampleInputEmail2" class="form-control" data-form-un="1476083165683.326" type="text">
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
                                <button class="btn btn-white" v-on:click="doSearch()">查询</button>
                    </div>
                </div>
            </div>
    </div>
    <div class="row" style="clear:both">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                        	<h5>今日报名学生列表</h5>
                            
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
										                            <td>
										                                <strong>学校:</strong> [[s.school_name]]
										                            </td>
										                            <td>
										                                <strong>年级:</strong>  [[s.grade]]
										                            </td>
																	<td>
																		<strong>指导老师:</strong>  [[s.teacher]]
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
</div>
	<script src="{{ asset('assets/js/plugins/d3/d3.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/c3/c3.min.js') }}"></script>
<script type="text/javascript">

 var _students=new Vue({
		el:"body",
		data:{
				students:null,
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
				getStudents:function(){
						var _this=this;
						$.ajax({
								url:"{{url('admin/api/instructor/getTodayRegisterMemberList')}}",
								type:"GET",
								data:_this.search,
								dataType:"json",
								success:function(json){
									_this.students=json;
								}
							});
				},
				//条件检索
				doSearch:function(){
					this.search.page=1;
					this.getStudents();
				},
				//翻页
				doChangePage:function(page){
					this.search.page=page;
					this.getStudents();
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
					window.location.href = s.boughtLogUrl;
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
 _students.getStudents();
</script>
@endsection



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
<div class="wrapper wrapper-content animated fadeInRight" id="readPlanDetail">
	<div class='row'>
		<div class="ibox collapsed">
                    <div class="ibox-content" style="display: block;">
									<div class="row  m-t-lg" >
										                <div class="col-md-6">
										
										                    <div class="profile-image">
										                        <img class="img-circle circle-border m-b-md" alt="profile" src="http://localhost.readingbar.net/files/avatar/avatar_student_sex1.jpg">
										                    </div>
										                    <div class="profile-info">
										                        <div class="">
										                            <div>
										                                <h2 class="no-margins">
										                                    [[ readPlan.student.name]]  
										                                    <font style="font-size:12px">（
										                                    <span>
								                                        		<font>[[ readPlan.student.sex]]</font>
							                                        		</span>
							                                        		/
							                                        		<span>[[ readPlan.student.age]]岁</span>
							                                        		）</font>                                                                
										                                </h2>
										                                                                                                       
										                                <h4>[[ readPlan.student.nick_name]]</h4>
										                                <small>                                                               
										                                	    偏好：
										                                	<templage v-for="fa in readPlan.student.favorite">
						                                        				[[ fa ]];
						                                        			</templage>
						                                        			<br>
						                                        			 地址：[[ readPlan.student.province+readPlan.student.city+readPlan.student.area+readPlan.student.address ]]
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
										                                <strong>学校:</strong> [[readPlan.student.school_name]]
										                            </td>
																	<td class='col-md-5'>
																		<strong>年级:</strong>  [[readPlan.student.grade]]
																	</td>	
										                        </tr>
										                         <tr>
										                            <td>
										                                 <strong>star账号:</strong><strong style="color: #4bd2bf;">[[readPlan.student.star_account]]</strong>
										                                 <br>
										                                 <strong>star密码:</strong><strong style="color: #4bd2bf;">[[readPlan.student.star_password]]</strong>
										                            </td>
										                           	
										                             <td>
										                                <strong>最近购买产品:</strong>
										                                <p><strong style="color: #4bd2bf;" v-if="readPlan.student.product">[[ readPlan.student.product ]]</strong></p>
										                            </td>
										                            <td>
										                           		<i class='fa fa-list'></i> <strong>服务:</strong>
										                           		<template v-if='readPlan.student.freezeService' >
										                             			<p v-for="se in readPlan.student.services">
																				<strong style="color: red;" >[[ se.name ]]<span>([[ se.expirated ]])</span></strong>
																			</p>
										                             		</template>
										                             		<template v-else>
										                             			<p v-for="se in readPlan.student.services">
																				<strong style="color: #4bd2bf;" >[[ se.name ]]<span>([[ se.expirated ]])</span></strong>
																			</p>
										                             		</template>
																			
										                            <td>
										                        </tr>
										                        <tr>
										                        	<td>
										                            	<strong>家长:</strong><strong>[[ readPlan.student.parent_name]]</strong>
										                            </td>
										                            <td>
										                                <strong>手机:</strong> [[ readPlan.student.parent_cellphone]]
										                            </td>
										                            <td>
										                                <strong>邮箱:</strong> [[ readPlan.student.parent_email]]
										                            </td>
										                            
										                        </tr>
										                        </tbody>
										                    </table>
										                </div>
										            </div>
                    </div>
                </div>
	</div>
	<div class='row'>
		<div class="ibox">
			<div class="ibox-content">
				<div class="row text-center"><h3><strong>[[ readPlan.plan_name]]</strong></h3></div>
				<div class="row text-center">
					<strong>[[ readPlan.from]]</strong>-<strong>[[ readPlan.to]]</strong>  <a href="javascript:void(0)" v-on:click="doShowFTForm()">修改</a>
				</div>
				<div class="row">
					<div class="col-md-1"></div>
					<div class="col-md-10">
						<table class="col-md-12 footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15">
							<thead>
								<tr>
									<th class="col-md-1 text-center">序号</th>
									<th class="col-md-3 text-center">书名</th>
									<th class="col-md-4 text-center">书籍介绍</th>
									<th class="col-md-1 text-center">Ar编号</th>
									<th class="col-md-1 text-center">BL</th>
									<th class="col-md-1 text-center">F/N</th>
									<th class="col-md-2 text-center" v-if="readPlan.status>=2 || readPlan.status==-1">操作</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for='b in readPlan.books'>
									<td class="col-md-3 text-center">[[ $index + 1 ]]</td>
									<td class="col-md-3 text-center">《[[b.book_name]]》</td>
									
									<td class="col-md-5 text-left">
										[[b.summary]]
									</td>
									<td class="col-md-1 text-center">
										<span v-if="b.Ar_id">[[b.Ar_id]]</span>
										<span v-else>暂无</span>
									</td>
									<td class="col-md-1 text-center">
										<span>[[b.BL]]</span>
									</td>
									<td class="col-md-1 text-center">
										<span>[[b.book_type]]</span>
									</td>
									
									<td class="col-md-2 text-center" v-if="readPlan.status>=2 || readPlan.status==-1">
										<button class="btn btn-default" v-if="readPlan.status==-1" v-on:click="doRemoveBookFromPlan(b.id)">移除书籍</button>
									</td>
								</tr>
							</tbody>
							<tfoot v-if="readPlan.status==-1">
								<tr>
									<td class="col-md-12 text-center" colspan='7'>
										
										<button class="btn btn-primary col-md-12" v-on:click="showQueryBooks()">加入书籍</button>
									</td>
								</tr>
							</tfoot>
						</table>
					</div>
					<div class="col-md-1"></div>
				</div>
				
				<hr class="row">
				<div class="row text-center">
					<button v-if="readPlan.status==-1" v-on:click="doAllowUserConfirm()" class="btn btn-primary">完成编辑交给用户确认</button>
					<button v-if="readPlan.status==0" v-on:click="doRevokeReadPlan()" class="btn btn-primary">重新编辑</button>
				</div>
			</div>
		</div>
	</div>
	<!-- 其他表单模拟框 -->
	@include('back::readPlan.readPlanFTForm')
	@include('back::readPlan.booksSearch')
</div>

<script type="text/javascript">
	var readPlanDetail=new Vue({
		el:"#readPlanDetail",
		data:{
			readPlan:null,
			ajaxUrls:{
				//获取计划详情
				getReadPlanDetail:"{{url('admin/api/readplan/getReadPlanById')}}",
				/*让会员确认阅读计划*/
				allowUserConfirm:"{{url('admin/api/readplan/allowUserConfirm')}}",
				/*撤回未确认的计划*/
				revokeReadPlan:"{{url('admin/api/readplan/revokeReadPlan')}}",
				/*上传AR报告*/
				submitARUrl:"{{url('admin/api/readplan/uploadArReport')}}",
				/*上传本月报告*/
				submitMRUrl:"{{url('admin/api/readplan/uploadMRReport')}}",
				/*修改报告的起始和结束日期*/
				changeFromTo:"{{url('admin/api/readplan/changeFromTo')}}",
				/*书籍查询*/
				seachBooks:"{{url('admin/api/readplan/seachBooks')}}",
				/*加入书籍*/
				addBookIntoPlan:"{{url('admin/api/readplan/addBookIntoPlan')}}",
				/*移除书籍*/
				removeBookFromPlan:"{{url('admin/api/readplan/removeBookFromPlan')}}"
			},
			search:{
				plan_id:"{{ $plan_id }}"
			},
			bookSearch:{
				page:1,
				limit:20
			},
			editRPD:null,
			books:null,
			Goals:null,
			Proposal:null,
			ajaxStatus:false
		},
		methods:{
			//获取计划详情
			doGetReadPlanDetail:function(){
				var _this=this;
				$.ajax({
					url:_this.ajaxUrls.getReadPlanDetail,
					data:_this.search,
					dataType:"json",
					success:function(json){
						if(json.status){
							_this.readPlan=json.data;
						}else{
							window.history.back();
						}
					}
				});
			},
			//阅读计划交给用户确认
			doAllowUserConfirm:function(){
				var _this=this;
				if(_this.ajaxStatus){
					return;
				}else{
					_this.ajaxStatus=true;
				}
				$.ajax({
					url:_this.ajaxUrls.allowUserConfirm,
					data:_this.search,
					dataType:"json",
					success:function(json){
						if(json.status){
							_this.readPlan.status=0;
						}else{
							window.history.back();
						}
						_this.ajaxStatus=false;
					}
				});
			},
			//撤回未确认的计划
			doRevokeReadPlan:function(){
				var _this=this;
				if(_this.ajaxStatus){
					return;
				}else{
					_this.ajaxStatus=true;
				}
				$.ajax({
					url:_this.ajaxUrls.revokeReadPlan,
					data:_this.search,
					dataType:"json",
					success:function(json){
						if(json.status){
							_this.readPlan.status=-1;
						}else{
							window.history.back();
						}
						_this.ajaxStatus=false;
					}
				});
			},
			//显示日期编辑表单
			doShowFTForm:function(){
				$('#FTFormModal').modal({backdrop: 'static', keyboard: false});
			},
			//取消日期表单
			doCancelFTForm:function(){
				$('#FTFormModal').modal('hide');
			},
			//提交日期表单
			doSubmitFTForm:function(){
				var _this=this;
				if(_this.ajaxStatus){
					return;
				}else{
					_this.ajaxStatus=true;
				}
				var oldReadPlan=this.readPlan;
				$.ajax({
					url:_this.ajaxUrls.changeFromTo,
					data:$('#FTForm').serialize(),
					dataType:"json",
					success:function(json){
						if(json.status){
							_this.doGetReadPlanDetail();
							$('#FTFormModal').modal('hide');
						}else{
							this.readPlan=oldReadPlan;
							alert(json.error);
						}
						_this.ajaxStatus=false;
					}
				});
			},
			//显示书籍查询
			showQueryBooks:function(){
				$('#booksSearchModal').modal({backdrop: 'static', keyboard: false});
			},
			/*获取查询书籍*/
			doGetBooksSearch:function(){
				var _this=this;
				$.ajax({
					url:_this.ajaxUrls.seachBooks,
					data:_this.bookSearch,
					dataType:"json",
					success:function(json){
						_this.books=json;
					}
				});
			},
			/*查询书籍翻页重置*/
			resetBookPage:function(){
				this.bookSearch.page=1;
			},
			/*查询书籍翻页*/
			doChangePageOfBS:function(page){
				this.bookSearch.page=page;
				this.doGetBooksSearch();
			},
			hasRead:function(b){
				return this.readPlan.student.hasReadBooks.indexOf(b.id)>=0;
			},
			//加入书籍
			doAddBookIntoPlan:function(b){
				var _this=this;
				//校验加入的书籍当前学生是否已读
				if(_this.readPlan.student.hasReadBooks.indexOf(b.id)>=0){
					if(!confirm('该书籍当前学生已读过，请确定是否继续添加？')){
						return;
					}
				}
				$.ajax({
					url:_this.ajaxUrls.addBookIntoPlan,
					data:{plan_id:_this.readPlan.id,book_id:b.id},
					dataType:"json",
					success:function(json){
						if(json.status){
							_this.doGetReadPlanDetail();
						}else{
							alert(json.error);
						}
					}
				});
			},
			//移除书籍
			doRemoveBookFromPlan:function(id){
				var _this=this;
				$.ajax({
					url:_this.ajaxUrls.removeBookFromPlan,
					data:{id:id},
					dataType:"json",
					success:function(json){
						if(json.status){
							_this.doGetReadPlanDetail();
						}else{
							alert(json.error);
						}
					}
				});
			}
		}
	});
	readPlanDetail.doGetReadPlanDetail();
</script>
@endsection



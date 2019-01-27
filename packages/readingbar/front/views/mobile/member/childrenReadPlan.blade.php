<!-- 继承整体布局 -->
@extends('front::mobile.common.main2l')

@section('content')
<style type="text/css">
	.am-control-nav{ display: none;}
</style>
<!-- 扩展内容-->
<script type="text/javascript" src="{{url('home/wap/js/jquery.touchSwipe.min.js')}}"></script>
<section>
    <div data-am-widget="tabs" class="am-tabs astation-message"    id="readPlans" >
		
			<div class="am-tab-panel am-active padding0">
				
               	<div class="am-g box_163css readplan2017-conte">
				 
					   <ul class="am-slides readplan2017 line">
				   		<!--孩子的选中状态是：class="active"；-->
				   		<template v-for="s in students">
				   			<li  class="active" v-if="s.id == search.student_id">
								<img class="" :src="s.avatar">
								<span>[[ s.name ]]</span>
							</li>
							<li v-on:click="selectChild(s)"  v-else>
								<img class="" :src="s.avatar">
								<span>[[ s.name ]]</span>
							</li>
				   		</template>
					</ul>
				</div>
			</div>

		    <!--/-->
		    <div data-am-widget="list_news" class="am-tabs-bd am-list-news" >
		   
		    	<div class="chider-bt"><span>阅读计划</span></div><!--/-->
		    	<div class="container" style="padding: 15px;">
					<a href="javascript:void(0)" v-on:click="starReadPlan()"><img src="{{url('home/wap/images/2017/530_03.jpg')}}" class="am-img-responsive" alt=""/></a>
				</div>
				<!--<h4 class="my-plan-titile"><i class="am-icon-bookmark"></i><b>我的计划</b></h4>-->
		     	<ul class="children-reard-list" style="padding: 0 15px;">
		     		<li class="am-g reardlist-box readplan-item" v-for="rp in listdata.data">
		     			<div>
		     				<div class="readplan-item-name">[[rp.plan_name]]</div>
		     				<div class="readplan-item-date">[[rp.from]]~[[rp.to]]</div>
		     			</div>
                		<div class="padding0 fr">
                			<a v-if="rp.status!=-1" href="{{url('member/children/readplan/detail')}}/[[rp.id]]" class="blade-buttom-3-01 fl">查看详情</a>
                			<a v-else href="javascript:alert('老师正在制定阅读计划,请耐心等待！')" class="blade-buttom-3-01 fl">查看详情</a>
                		</div>
		     		</li>
		     	</ul>
		     	<!--page-->
                <div class="am-text-center">
					  		<div class='loading-local1'  v-if="loadStatus">
						  		<ul >
									<li class="node1"></li>
									<li class="node2"></li>
									<li class="node3"></li>
								</ul>
					  		</div>
					  		<span v-if="loadStatus">数据加载中...</span>
			 				<span v-if="!loadStatus && !loadEnd">下拉加载数据</span>
			 				<span v-if="!loadStatus && loadEnd">已经到底了</span>
					  	</div>
                <!--page end-->
		    </div>
  		</div>
    </div>
</section>	
<script type="text/javascript">
	var readPlans=new Vue({
			el:"#readPlans",
			data:{
				listdata:null,
				student:null,
				students:{!! $students !!},
				search:{
					type: 0,
					student_id:0,
					page:1,
					limit:5
				},
				loadStatus:false,
				ajax:null,
			},
			computed:{
				loadEnd: function(){
					var a=this.listdata.current_page>=this.listdata.last_page;
					if(a){
						return true;
					}else{
						return false;
					}
				}
			},
			created:function(){
				if(this.students[0]){
					this.student=this.students[0];
					this.search.student_id=this.students[0].id;
					this.getReadPlans();
				}
				this.scrollLoad();
			},
			methods:{
				//获取阅读计划
				getReadPlans:function(){
					var _this=this;
					if(_this.loadStatus){
						return;
					}
					_this.loadStatus=true;
					_this.ajax=$.ajax({
							url:"{{url('api/member/children/readplan/plans')}}",
							dataType:"json",
							data:_this.search,
							success:function(json){
								if(_this.search.page>1){
									for(i in json.data){
										_this.listdata.data.push(json.data[i]);
									}
									_this.listdata.current_page=_this.search.page;
								}else{
									_this.listdata=json;
								}
								_this.loadStatus=false;
							},
							error:function(){
								_this.loadStatus=false;
							}
					});
				},
				//翻页
				doChangePage:function(page){
					this.search.page=page;
					this.getReadPlans();
				},
				//选择孩子
				selectChild:function(s){
					this.ajax.abort();
					this.student=s;
					this.search.student_id=s.id;
					this.search.page=1;
					this.getReadPlans();
				},
				//确认申请阅读计划
				starReadPlan:function(){
					var _this=this;
					amazeConfirm({
						title:'申请阅读计划/还书',
						msg:'确认申请阅读计划或还书？',
						onConfirm:function(){
							_this.checkStudent();
						}
					});
				},
				//检查是否选择了学生
				checkStudent:function(){
					if(this.student){
						this.checkPay();
					}else{
						appAlert({
							'title':'提醒',
							'msg':'请选择学生！'
						});
					}
				},
				//检查学生是否为付费用户
				checkPay:function(){
					
					if(this.student.payingCustomers){
						this.checkRPAble();
					}else{
	 					amazeConfirm({
							msg:'请您先购买产品套餐!',
							confirm:'购买',
							onConfirm:function(){
								window.location.href="{{url('product/list')}}";
							}
						});
					}
				},
				//检查学生购买的服务是否有阅读计划的服务项
				checkRPAble:function(){
					if(this.student.hasReadPlanService){
						this.checkStarTest();
					}else{
	 					amazeConfirm({
							msg:'您购买的产品无此服务！',
							confirm:'购买',
							onConfirm:function(){
								window.location.href="{{url('product/list')}}";
							}
						});
					}
				},
				//检查学生是否做过star评测
				checkStarTest:function(){
					var _this=this;
					amazeConfirm({
 						msg:'您是否做过star评测？',
 						confirm:'是',
						onConfirm:function(){
							_this.chooseService();
						},
						cancel:'否',
						onCancel:function(){
							window.open("{{config('readingbar.starTestWebSite')}}");
						}
					});
				},
				//询问是否根据当前star评测申请阅读计划
				chooseService:function(){
					var _this=this;
					amazeConfirm({
 						msg:'您希望根据现有STAR报告制定阅读计划吗？',
 						confirm:'是',
						onConfirm:function(){
							_this.applyRP();
						},
						cancel:'否',
						onCancel:function(){
							window.open("{{config('readingbar.starTestWebSite')}}");
						}
					});
				},
				//申请阅读计划
				applyRP:function(){
					var _this=this;
					$.ajax({
						url:"{{url('api/member/children/readplan/apply')}}",
						dataType:"json",
						data:{student_id:_this.student.id},
						success:function(json){
							if(json.status){
								_this.getReadPlans();
								amazeAlert({
									title:'提示信息',
									msg:json.success
								});
							}else{
								amazeAlert({
									title:'提示信息',
									msg:json.error
								});
							}
						}
					});
				},
				/*滚动至底部加载数据*/
				scrollLoad:function(){
					var _this=this;
					$(document).scroll(function(){
						if((document.body.scrollHeight-(document.body.clientHeight+document.body.scrollTop))<20){
							if(!_this.loadStatus && !_this.loadEnd){
								_this.search.page++;
								_this.getReadPlans();
							}
						}
					});  
				}
			}
	});		
</script>
<!-- //扩展内容--> 
@endsection
<!-- //继承整体布局 -->

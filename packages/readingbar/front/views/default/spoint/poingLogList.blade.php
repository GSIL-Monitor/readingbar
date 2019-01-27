<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')

	
<!-- 包含会员菜单 -->
<!-- 扩展内容-->

<div class="container">
	<div class="row padt9">
	  	<div class="col-md-2 home-column-fl">
	  		@include('front::default.member.memberMenu')
	    </div>
	    <!--/ home-column-fl end-->
	    <div class="col-md-10 home-column-fr100">
	        <ul class="nav nav-tabs">
				<li role="presentation" class="active"><a href="#">我的积分</a></li>
			</ul>
			<div style="clear:both"></div>
			<div class="col-md-12 home-column-fr" id="childrenList">
				<div style="margin-left:0;width: 100%;margin-left:21px;">
				<div class="row baby-list" >
					<div class="col-md-2 fl">
						<div class="user-tx2">
							<a href="{{ url('member/children/baseinfo') }}/[[student.avatar.id]]"><img :src="student.avatar"></a>
							<em class="user-tx-hover2"></em>
						</div>
						<div class="rdmony">
							<span><img src="{{url('home/pc/images/ioc-rdm.png')}}"></span>
							<b>[[ student.point ]]</b>	
							<a href="#" data-placement="right" title="
蕊丁币的获得方式：
*会员每天登陆官网，就可获得10个蕊丁币。（和登录次数无关，对所有注册会员有效）
*凡进入每月更新的小达人排行榜，都可以获得100个蕊丁币。
*定制会员，每完成阅读计划中的任务目标，就可以获得100个蕊丁币。
*所有蕊丁使者，成功推广一名注册会员，即可获得20蕊丁币。
*购买蕊丁吧产品，即可获得相同数量的蕊丁币。
*参与蕊丁吧“Reading Camp”，完成任务可获得奖励蕊丁币。
*蕊丁吧年费会员，凡是获得过区、市、省、国家级的英语类奖项，可获得额外获得50，100，150，200蕊丁币的奖励。
" style="font-size: 14px;
    line-height: 20px;
    margin-left: 5px;
    color: #4bd2bf;
    font-weight: bold;margin-top: -4px;"><img src="{{url('home/pc/images/wh.png')}}"></a>
						</div>
					</div>
					<!--/-->
					<div class="baby-info col-md-6">
						<a href="{{ url('member/children/baseinfo')}}/[[student.id]]"><h4>姓名：[[ student.nick_name ]]</h4></a>
					    <p>昵称：[[ student.name ]]</p>
					    <template v-if="student.services.length">
					    	<p v-for='se in student.services'>
					    		[[ se.name ]]-过期日期：[[ se.expirated ]]
					    		<a href="{{ url('member/pay/renewConfirm?student_id=')}}[[ student.id ]]&service_id=[[ se.service_id ]]">[续费]</a>	
					    	</p>
					    </template>
					    <div style="margin-top: 8px;">
							<a href="javascript::void(0);"  class="link728">明细</a>
							<a href="javascript::void(0);"  onclick="alert('功能正在完善，敬请期待!');" class="link728">兑换</a>
						</div>
						
					</div>
					
					<div class="baby-operation col-md-2">
						
						<button class="click-delete" v-on:click="doDeleteChild(student.id);">删除</button>
						<a :href="student.edit_url" class="click-bj">编辑</a>
					</div>
				</div>
				<!--/baby-list-->
				
			</div>
			<!--/ loadData==1-->
			
			<ul class="pagination pull-right" v-if="logs.last_page>1">
			    	<li v-if="logs.current_page>1" v-on:click="doChangePage(1)"><a>«</a></li>
		    		<template v-for="p in logs.last_page" v-if="Math.abs(logs.current_page-(p+1))<=3">
		    			<li v-if="logs.current_page==p+1" class="active" v-on:click="doChangePage(p+1)"><span>[[ p+1 ]]</span></li>
		    			<li v-else v-on:click="doChangePage(p+1)"><a>[[ p+1 ]]</a></li>
		    		</template>
			     	<li v-if="logs.current_page < logs.last_page" v-on:click="doChangePage(logs.last_page)"><a>»</a></li>
		     	</ul>			
			<!-- 礼品卡激活表单 -->
			
				<!-- //礼品卡激活表单 -->
			</div>
			
		  	<!--/home-column-fr-->    
		</div>
		<!--/col-md-10-->	
	</div>
	<!--/row end-->
</div>
<!-- /扩展内容 -->
<script type="text/javascript">
new Vue({
	 el:'#childrenList',
	 data:{
		student:{!! $student->toJson() !!},
		logs:[],
		search:{
				page:1,
				limit:10,
		},
		activeCard:{
			student_id:null,
			card:null,
			card_pwd:null,
			address:null,
			name:"{{ auth('member')->member->nickname }}",
			tel:"{{ auth('member')->member->cellphone }}"
		},
		activeCardStatus:false
	},
	created:function(){
			this.search.student_id=this.student.id;
			this.doGetLogs();
	},
	methods:{
		doGetLogs:function(){
			var _this=this;
			_this.loadData=0;
			$.ajax({
					url:"{{url('member/children/pointLog/getLogs')}}",
					dataType:"json",
					data:_this.search,
					success:function(json){
						_this.logs=json;
					},
					error:function(){
						_this.loadData=2;
					}
			});
		},
		doChangePage:function(page){
			this.search.page=page;
			this.doGetLogs();
		},
		goStarReport:function(){
			window.location.href=this.student.report_url;
		},
		goReadPlan:function(){
			window.location.href=this.student.readplan_url;
		},
		doDeleteChild:function(cid){
			if(!confirm('是否确认删除！')){
				return ;
			}
			var _this=this;
			$.ajax({
					url:"{{url('api/member/children/deleteChild')}}",
					dataType:"json",
					type:"POST",
					data:{id:cid},
					success:function(json){
						if(json.status){
							alert(json.success);
						   window.location.href="{{ url('member') }}";
						}else{
							alert(json.error);
						}
					}
			});
		},//礼品卡激活表单显示
		showCardModal:function(){
			this.activeCard.student_id=this.student.id;
			this.activeCard.address=this.student.province+this.student.city+this.student.area+this.student.address;
			$("#cardModal").modal({backdrop: 'static', keyboard: false});
		},
		//激活礼品卡
		doActiveCard:function(){
			var _this=this;
			if(_this.activeCardStatus){
				return;
			}else{
				_this.activeCardStatus=true;
			}
			$.ajax({
				url:"{{url('api/member/giftCard/activeCard')}}",
				data:_this.activeCard,
				type:"POST",
				dataType:"json",
				success:function(json){
					if(json.status){
						_this.getChildren();
						$("#cardModal").modal('hide');
						alert(json.success);
					}else{
						alert(json.error);
					}
					_this.activeCardStatus=false;
				},
				error:function(){
					alert('链接失败！');
					_this.activeCardStatus=false;
				}
			});
		},
		
	}
});
</script>


@endsection
<!-- //继承整体布局 -->

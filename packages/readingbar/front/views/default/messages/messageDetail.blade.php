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
	    <div class="col-md-10  home-column-fr100">
            <ul class="nav nav-tabs">
				<li role="presentation" class="active"><a href="#">消息详情</a></li>
			</ul>
		<div style="clear:both"></div>
		
		<div class="content mgl-40" id="messagesDetail">
			<div class="row">
				<div class="col-md-12">
					<a href="javascript:window.history.back()" class="fr" style="color:#4bd2bf;font-size:14px;"><strong>返回</strong></a>
				</div>
				
			</div>
			<br>
			<div id="messagesList"  class="bg-eaedf4" style="overflow:scroll ;height:400px;overflow-x: hidden;">
				<template v-for="m in listdata.data">
					<div v-if="m.mine" class="chat-message  col-md-12 right">
	                       <img class="message-avatar " alt="" src="[[m.sender.avatar]]">
	                       <div class="message  col-md-10">
	                                            <span class="message-author" href="javascript:void(0)">[[m.sender.nickname]] </span>
												<span class="message-date" >[[m.created_at]]</span>
	                                            <span class="message-content">
												 [[m.content]]
	                                            </span>
	                            </div>
	                 </div>
	                 <div v-else class="chat-message  col-md-12 left">
	                 		<img class="message-avatar" alt="" src="[[m.sender.avatar]]">
	                       <div class="message  col-md-10">
	                                            <span class="message-author" href="javascript:void(0)">[[m.sender.nickname]] </span>
												<span class="message-date" >[[m.created_at]]</span>
	                                            <span class="message-content">
												 [[m.content]]
	                                            </span>
	                            </div>
	                 </div>
				</template>
	        </div>
            <div  id="messageRplyFrom" >
				<textarea v-model="message.content" class="bg-eaedf4" rows="" cols="" ></textarea>
				<button v-on:click="doSendMessage()" class=" button-01 fr">发送</button>
			</div>
		</div>
		<!--/-->
     </div>	
</div>
<!--/row end-->
</div>
<script type="text/javascript">
var messagesDetail=new Vue({
	el:"#messagesDetail",
	data:{
		listdata:null,
		search:{
			page:1,
			limit:1000
		},
		message:{
			content:null,
			reply:{{$message_id}}
		},
		scroll:0,//用于触发消息列滚动底部
	},
	created:function(){
		this.getMessages();
	},
	watch:{
		scroll:function(){
			//消息列表滚动到底部事件
	        $("#messagesList").scrollTop($("#messagesList")[0].scrollHeight);
	    }
	},
	methods:{
		//获取消息
		getMessages:function(){
			var _this=this;
			$.ajax({
				url:"{{url('api/member/message/detail/'.$message_id)}}",
				dataType:"json",
				data:_this.search,
				success:function(json){
					if(json.status){
						_this.listdata=json;
						_this.scroll++;
					}else{
						alert(json.error);
					}
				}
			});
		},
		//发送消息
		doSendMessage:function(){
			var _this=this;
			$.ajax({
				url:"{{url('api/member/message/reply')}}",
				dataType:"json",
				data:_this.message,
				success:function(json){
					if(json.status){
						_this.listdata.data.push(json.data);
						_this.scroll++;
						_this.message.content=null;
					}else{
						alert(json.error);
					}
				}
			});
		}
	}
});
</script>
<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

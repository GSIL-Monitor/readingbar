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
	   <div class="col-md-10 home-column-fr100" id="readPlans">
	        <ul class="nav nav-tabs">
				<li role="presentation" class="active" style="width:100%">
					<a href="#" class="fl">留言</a>  
					<a href="javascript:history.back()" class="fr">--返回--</a>
				</li>
			</ul>
			<div style="clear:both"></div>
			<div class="content mgl-40" id="leaveMessage" v-if="message.teacher_id">
             	<div class="plan-book-message2">
             	    <div class="row" id="messagesList">
             	        <span class="fl">收件人：</span>
						<select   v-model="message.teacher_id" class="form-control fl" style="width:120px;">
							<option v-for="t in teachers" value="[[t.id]]" >[[t.name]]</option>
						</select>
					</div>
             		<textarea v-model="message.content" class="book-message"></textarea>
             		<button v-on:click="doSendMessage()" class="book-message-buttom button-01 fr">发送</button>
             		
             	</div>
           <!--content-->
		   </div>
		</div>
	</div>
	<!--/row end-->
</div>

<script type="text/javascript">
var leaveMessage=new Vue({
	el:"#leaveMessage",
	data:{
		message:{
			content:null,
			teacher_id:null
		},
		teachers:null
	},
	watch: {
		scroll(){
			//消息列表滚动到底部事件
	        $("#messagesList").scrollTop($("#messagesList")[0].scrollHeight);
	    }
	},
	methods:{
		//获取会员关联老师
		doGetTeachers:function(){
			var _this=this;
			$.ajax({
				url:"{{url('api/member/teachers/all')}}",
				dataType:"json",
				success:function(json){
					if(json.status){
						_this.teachers=json.data;
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
				url:"{{url('api/member/message/send')}}",
				dataType:"json",
				data:_this.message,
				success:function(json){
					if(json.status){
						window.location.href="{{url('member/messages/messageDetail')}}/"+json.data.id;
					}else{
						alert(json.error);
					}
				}
			});
		}
	}
});
leaveMessage.doGetTeachers();
</script>
<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->


<!-- 继承整体布局 -->
@extends('front::mobile.common.main2l')

@section('content')

<!-- 扩展内容-->
<section id="messagesDetail">
  <div data-am-widget="tabs" class="am-tabs astation-message">
    <!--station-message-->
    <div data-am-widget="list_news" class="am-tabs-bd am-list-news" >
    	<div data-tab-panel-0 class="am-tab-panel am-active">
    		<form action="">
    			<div class="am-form-group pad15">
  					<ul class="mon message-list" id="messagesList" style="overflow:scroll ;height:50%;overflow-x: hidden;">
			            <li class="am-g" v-for="m in listdata.data">
			              <div class="am-u-sm-12 message-list-cont01">
			                 <span class="fl">[[m.sender.nickname]]</span>
			                <b class="fr">[[m.created_at]]</b>
			              </div>
			              <div class="am-u-sm-12">
			                <p>[[m.content]]</p>
			              </div>
			            </li>
			          </ul>
    			</div>
    			<div class="am-form-group pad15">
	                <textarea v-model="message.content" class="am-g book-message" style="height:20%;" rows="5" id="doc-ta-1"></textarea>
	            </div>
	            <div class="am-form-group pad15">
	                <button v-on:click="doSendMessage()" class="btn-save5 fr">发送</button>
	            </div>
	            <!--/am-form-group-->
    		</form>
    	</div> 
    	<!--data-tab-panel-0-->
    	
    </div>
    <!--list_news-->
</section>

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
		ajaxStatus:false
	},
	created:function(){
		this.getMessages();
	},
	watch: {
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
			if(_this.ajaxStatus){
				return;
			}else{
				_this.ajaxStatus=true;
			}
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
					_this.ajaxStatus=false;
				}
			});
		}
	}
});
</script>
<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

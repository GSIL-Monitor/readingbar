<div id="leaveMessage">
             <div class="am-form-group pad15 margintop15" id="messagesList">
              <label for="doc-select-1">收件人：</label>
              <select id="doc-select-1"  v-model="message.teacher_id">
                <option v-for="t in teachers" value="[[t.id]]" >[[t.name]]</option>
              </select>
              <span class="am-form-caret"></span>
            </div>
            <!--/am-form-group-->
            <div class="am-form-group pad15">
                <textarea  v-model="message.content" class="am-g book-message" rows="5" id="doc-ta-1"></textarea>
            </div>
            <div class="am-form-group pad15">
                <button  v-on:click="doSendMessage()" class="btn-save5 fr">发送</button>
            </div>
            <!--/am-form-group-->
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
	watch:{
		scroll:function(){
			//消息列表滚动到底部事件
	        $("#messagesList").scrollTop($("#messagesList")[0].scrollHeight);
	    }
	},
	methods:{
		//获取会员关联老师
		doGetTeachers:function(){
			var _leaveMessage=this;
			$.ajax({
				url:"{{url('api/member/teachers/all')}}",
				dataType:"json",
				success:function(json){
					if(json.status){
						_leaveMessage.teachers=json.data;
					}else{
						alert(json.error);
					}
				}
			});
		},
		//发送消息
		doSendMessage:function(){
			var _leaveMessage=this;
			$.ajax({
				url:"{{url('api/member/message/send')}}",
				dataType:"json",
				data:_leaveMessage.message,
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
<div id="messagesBox">

		<div class="container astation-message-operating">
            <a href="javascript:history.back()" class="fr">--返回--</a>
          </div>
          <!--/user-message-->
          <ul class="mon message-list">
            <li class="am-g" v-for="m in listdata.data">
              <div class="am-u-sm-12 message-list-cont01">
                <span class=" fl">[[m.sender.nickname]]</span>
                <b class=" fr">[[m.created_at]]</b>
              </div>
              <div class="am-u-sm-12 message-list-cont02">
                <p>[[m.content]]</p>
              </div>
              <div class="am-u-sm-12">
              		<div class="am-u-sm-10">
	              		<a v-if="m.reply!=null" class="message-list-tj fr" href="{{url('member/messages/messageDetail')}}/[[m.reply]]">回复</a>
						<a v-else class="message-list-tj fr" href="{{url('member/messages/messageDetail')}}/[[m.id]]">回复</a>
					</div class="am-u-sm-2">
						<a v-on:click="doDeleteMessages(m)" class="message-list-tj fr" href="javascript:void(0)">删除</a>
					</div><div>
					
              </div> 
            </li>
          </ul>
          <!--/-->
          <div class="am-list-news-ft pab15">
            <a class="am-list-news-more am-btn am-btn-default" href="javascript:void(0)" v-on:click="doChangePage(search.page+1)">查看更多 &raquo;</a>
          </div>
           <!--/-->

</div>           
 <script type="text/javascript">
var messagesBox=new Vue({
	el:"#messagesBox",
	data:{
		listdata:null,
		search:{
			page:1,
			limit:5
		},
		deleteMessages:[],
		ajaxStatus:false
	},
	methods:{
		getMessages:function(){
			var _this=this;
			if(_this.ajaxStatus){
				return;
			}else{
				_this.ajaxStatus=true;
			}
			$.ajax({
				url:"{{url('api/member/message')}}",
				dataType:"json",
				data:_this.search,
				success:function(json){
					if(json.status){
						if(_this.listdata){
							for(i in json.data){
								_this.listdata.data.push(json.data[i]);
							}
						}else{
							_this.listdata=json;
						}
					}else{
						alert(json.error);
					}
					_this.ajaxStatus=false;
				}
			});
		},
		doChangePage:function(page){
			if(this.ajaxStatus){
				return;
			}
			this.search.page=page;
			this.getMessages();
		},
		doDeleteMessages:function(m){
			if(!confirm('是否确认删除！')){
				return;
			}
			var _this=this;
			$.ajax({
				url:"{{url('api/member/message/delete')}}",
				dataType:"json",
				data:{id:m.id},
				success:function(json){
					if(json.status){
						_this.listdata.data.$remove(m);
					}else{
						alert(json.error);
					}
				}
			});
		}
	}
});
messagesBox.getMessages();
</script>
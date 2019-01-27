<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')

<div class="container">
	<div class="row padt9">
	  <div class="col-md-2 home-column-fl">
	  	@include('front::default.member.memberMenu')
	  </div>
	  <!--/ home-column-fl end-->
	  <div class="col-md-10  home-column-fr100">
            <ul class="nav nav-tabs">
				<li role="presentation" class="active"><a href="javascript:void(0)">收件箱</a></li>
			</ul>
			<div style="clear:both"></div>
			<div class="content mgl-40" id="messagesBox">
				<div class="padding-30">
					<div class="user-message">
<!-- 						<span class="fl"><input type="checkbox"> 请记住我</span> -->
						<a href="{{ url('member/messages/leaveMessage') }}" class="fr" style="color:#4bd2bf;font-size:14px"><strong>我要留言</strong></a>
					</div>
					<ul class="mon message-list" v-if="listdata">
						<li v-for="m in listdata.data">
							
							<div class="col-md-2 user-tx2 fl">
								<img src="[[m.sender.avatar]]">
			                	<em class="user-tx-hover2"></em>
			                </div>
							<div class="col-md-7 fl message-list-nr">
								<h4>[[m.sender.nickname]]:</h4>
								<p>[[m.content]]</p>
								<span class="col-md-6">[[m.created_at]]</span>
								<span class="col-md-6 text-right"><font v-if="m.unread" >未读:<span style="color:red">[[ m.unread ]]</span>/</font>回复:<span>[[ m.replies ]]</span></span>
							</div>
							<div class="col-md-1 fl message-buttom button-02" style="margin-left:10px">
								<a v-on:click="doDeleteMessages(m.id)" href="javascript:void(0)">删除</a>
							</div>
							<div class="col-md-1 fl message-buttom button-01" >
								<a v-if="m.reply!=null" href="{{url('member/messages/messageDetail')}}/[[m.reply]]">查看</a>
								<a v-else href="{{url('member/messages/messageDetail')}}/[[m.id]]">查看</a>
								
							</div>
							
						</li>
					</ul>
				<!--/-->
					<ul class="pagination fr" v-if="listdata.total_pages>1">
					    <li><a v-if="1!=listdata.current_page" v-on:click="doChangePage(1)">&laquo;</a></li>
					    <template  v-for="p in listdata.total_pages" v-if="Math.abs(p+1-listdata.current_page)<4">
					    	<li v-if="listdata.current_page==p+1" class="active"><a href="javascript:void(0)" v-on:click="doChangePage(p+1)">[[ p+1 ]]</a></li>
					    	<li v-else><a href="javascript:void(0)" v-on:click="doChangePage(p+1)">[[ p+1 ]]</a></li>
					    </template>
					    <li><a v-if="listdata.total_pages!=listdata.current_page" v-on:click="doChangePage(listdata.total_pages)">&raquo;</a></li>
					</ul>
				<!--/-->
				</div>
			</div>
			<!--/-->
	  </div>	
	</div>
<!--/row end-->
</div>
<script type="text/javascript">
var messagesBox=new Vue({
	el:"#messagesBox",
	data:{
		listdata:null,
		search:{
			page:1,
			limit:5
		}
	},
	methods:{
		getMessages:function(){
			var _this=this;
			$.ajax({
				url:"{{url('api/member/message')}}",
				dataType:"json",
				data:_this.search,
				success:function(json){
					if(json.status){
						_this.listdata=json;
					}else{
						alert(json.error);
					}
				}
			});
		},
		doChangePage:function(page){
			this.search.page=page;
			this.getMessages();
		},
		doDeleteMessages:function(id){
			if(!confirm('是否确认删除！')){
				return;
			}
			var _this=this;
			$.ajax({
				url:"{{url('api/member/message/delete')}}",
				dataType:"json",
				data:{id:id},
				success:function(json){
					if(json.status){
						_this.getMessages();
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
<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

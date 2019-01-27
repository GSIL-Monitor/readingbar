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
<div class="wrapper wrapper-content animated fadeInRight" id="messagesBoxDetail">
	<div class="row">
			<div class="col-lg-12">

                <div class="ibox chat-view">

                    <div class="ibox-title">
                       	消息([[messages.total]])
                    </div>


                    <div class="ibox-content">

                        <div class="row">

                            <div class="col-md-12 ">
                                <div class="chat-discussion">
	                                <template v-for="m in messages.data">
	                                    <div v-if="m.sendfrom==current_user" class="chat-message right">
	                                        <img class="message-avatar" :src="m.sender_avatar" alt="">
	                                        <div class="message">
	                                            <a class="message-author" href="javascript:void(0)"> [[m.sender_name]] </a>
												<span class="message-date"> [[m.created_at]] </span>
	                                            <span class="message-content">
												[[m.content]]
	                                            </span>
	                                        </div>
	                                    </div>
	                                    <div v-else class="chat-message  left">
	                                        <img class="message-avatar" :src="m.sender_avatar" alt="">
	                                        <div class="message">
	                                            <a class="message-author" href="javascript:void(0)"> [[m.sender_name]] </a>
												<span class="message-date"> [[m.created_at]] </span>
	                                            <span class="message-content">
												[[m.content]]
	                                            </span>
	                                        </div>
	                                    </div>
                                   </template>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="chat-message-form">

                                    <div class="form-group">
                                        <textarea v-model="reply.content" class="form-control message-input" name="message" placeholder="输入回复内容"></textarea>
                                    </div>
									<div class="form-group text-center">
										<br>
										<div class="col-md-5"></div>
                                        <button class="btn btn-primary col-md-2" style="margin:0 auto" v-on:click="doReplyMessage()">回复</button>
                                        <div class="col-md-5"></div>
                                        <br style="clear:both">
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>
        </div>
	</div>	
</div>
<script type="text/javascript">
var messagesBoxDetail=new Vue({
	el:"#messagesBoxDetail",
	data:{
		messages:null,
		current_user:{{Auth::user()->id}},
		search:{
			pre_id:"{{$pre_id}}",
			page:1,
			limit:1000,
		},
		ajaxUrls:{
			getMessageDetail:"{{url('admin/api/messagesBox/getMessageDetail')}}",
			replyMessage:"{{url('admin/api/messagesBox/replyMessage')}}",
		},
		reply:{
			pre_id:"{{$pre_id}}",
			content:null
		},
		scroll:null,
		ajaxStatus:false
	},
	watch: {
		scroll(){
			//消息列表滚动到底部事件
	        $(".chat-discussion").scrollTop($(".chat-discussion")[0].scrollHeight);
	    }
	},
	methods:{
		//获取数据
		doGetMessageDetail:function(){
			var _this=this;
			if(_this.ajaxStatus){
				return ;
			}else{
				_this.ajaxStatus=true;
			}
			$.ajax({
				url:_this.ajaxUrls.getMessageDetail,	
				dataType:"json",
				data:_this.search,
				success:function(json){
					if(json.status){
						_this.messages=json;
					}else{
						alert(json.error);
					}
					_this.ajaxStatus=false;
					_this.scroll++;
				}	
			});
		},
		//回复消息
		doReplyMessage:function(){
			var _this=this;
			if(_this.ajaxStatus){
				return ;
			}else{
				_this.ajaxStatus=true;
			}
			$.ajax({
				url:_this.ajaxUrls.replyMessage,	
				dataType:"json",
				type:"POST",
				data:_this.reply,
				success:function(json){
					_this.ajaxStatus=false;
					if(json.status){
						_this.reply.content=null;
						_this.doGetMessageDetail();
					}else{
						alert(json.error);
					}
					
				}	
			});
		}
	}
});
messagesBoxDetail.doGetMessageDetail();
</script>
@endsection



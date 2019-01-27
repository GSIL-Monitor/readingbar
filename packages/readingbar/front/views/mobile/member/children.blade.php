<!-- 继承整体布局 -->
@extends('front::mobile.common.main2l')

@section('content')
<style type="text/css">
	body{  background: #ededed;}
	.am-g .am-g{ margin: 0;}
</style>
<!-- 扩展内容-->
<section id="Children">
    <div class="am-tabs astation-message" data-am-tabs="{noSwipe: 1}"  >
		<div class="am-tabs-bd">
			<!--/-->
		    <div class=" am-g padding0">
		    	<div class="chiderti132 fr"><img src="{{url('home/wap/images/2017/icon_100_tj.png')}}"><a href="{{ url('member/children/create') }}">添加孩子信息</a></div><!--/-->
		    	<ul class="chiderlsit101 am-g">
					<li v-for="s in listdata.data">
						<div class="am-g">
							<div class="am-u-sm-4"><img :src="s.avatar"></div>
							<div class="am-u-sm-4">
								<h4>[[ s.nick_name ]]</h4>
								<span><img src="{{url('home/wap/images/2017/icon_100_jf.png')}}">[[ s.point ]]</span>
							</div>
							<div class="am-u-sm-4">
								<a href="#" v-on:click="goEdit(s)" class="gbbuttom">编辑</a>
								<a href="#" v-on:click="doDelete(s)" class="gbbuttom">删除</a>
							</div>
						</div>
						<div class="am-g chiderdata-01">
							<p v-for='se in s.services' v-if="checkDate(se.expirated)">
						    		[[se.name]]-过期日期：[[se.expirated]] 
						    		<a href="{{ url('member/pay/renewConfirm?') }}student_id=[[ s.id ]]&service_id=[[ se.service_id ]]" >[续费]</a>	
						    	</p>
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
var reportList=new Vue({
	el:"#Children",
	data:{
		listdata:null,
		search:{
			page:1,
			limit:5,
			order:'updated_at',
			sort:'desc'
		},
		loadStatus:false
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
		this.doGetChildren();
		this.scrollLoad();
	},
	methods:{
		doGetChildren:function(){
			var _this=this;
			if(_this.loadStatus){
				return;
			}
			_this.loadStatus=true;
			$.ajax({
				url:"{{url('api/member/children/all')}}",
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
		selectChild:function(s){
			this.search.student_id=s.id;
			this.listdata=null;
			this.search.page=1;
			this.doGetChildren();
		},
		goEdit:function(s){
			window.location.href="{{ url('member/children/edit') }}/"+s.id;
		},
		doDelete:function(s){
			var _this=this;
			amazeConfirm({
				msg:'是否确认删除！',
				onConfirm:function(){
					$.ajax({
						url:"{{url('api/member/children/deleteChild')}}",
						dataType:"json",
						type:"POST",
						data:{id:s.id},
						success:function(json){
							if(json.status){
								_this.listdata.data.splice(_this.listdata.data.indexOf(s),1);
								_this.doGetChildren();
							}else{
								amazeAlert({
									msg:json.error
								})
							}
						}
				});
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
						_this.doGetChildren();
					}
				}
			});  
		},
		//校验日期是否过期
		checkDate: function(expirated){
			var now = Date.parse(new Date());
			expirated =  Date.parse(new Date(expirated));
			return expirated > now;
		}
	}
});
</script>
<!-- //扩展内容--> 
@endsection
<!-- //继承整体布局 -->

<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')
<!-- 扩展内容-->
<!--/banner-->
<style>
body{ background-color:#f7f7f7;}
</style>
<div class="content paddbt70 " id="ideas">
	<div class="container cont-about container-2017" style="background-color:white">
		<div class="content650 text-center">
			<div class=" font_title">关于蕊丁吧的服务及产品，欢迎您留言：</div>
			<textarea rows="" cols="" class="conpent-textarea-fixed" placeholder="写点想法. . ." v-model="idea"></textarea>
			<div class="text-right">
				<button class="btn-local" v-on:click="submitIdea()">提交留言</button>
			</div>
			<br><br>
			<div class=" font_title">更多精彩留言</div>
			<template v-for="i in ideas.data">
				<br>
				<div class="conpent-textarea-width-fixed row">
					<div class="col-xs-12 i-name text-left">[[ i.nickname ]]:</div>
					<div class="col-xs-12">
						<div class="col-xs-1 "></div>
						<div class="col-xs-10 i-content text-left">[[ i.idea ]]</div>
						<div class="col-xs-1 "></div>
					</div>
					<div class="col-xs-12 i-dateline text-right ">[[ i.created_at ]]</div>
				</div>
				
				<div class="conpent-textarea-width-fixed row  fixed-width" >
					<div class="col-xs-12 i-name text-left">小蕊回复:</div>
					<div class="col-xs-12">
						<div class="col-xs-1 "></div>
						<div class="col-xs-10 i-content text-left">[[ i.reply ]]</div>
						<div class="col-xs-1 "></div>
					</div>
				</div>
				<hr>
			</template>
			<br><br>
			<div style="clear:both">
			<div class="col-md-12 text-center" >
				<template v-if="loadStatus">
					
						<ul class='loading-local1'>
							<li class="node1"></li>
							<li class="node2"></li>
							<li class="node3"></li>
						</ul>
						<span class="color333333">数据加载中</span>
					
				</template>
				<template v-else>
						<span class="color333333" v-if="page>=ideas.last_page">已经加载到底了</span>
						<span class="color333333 tbox-down-arrow" v-else>下拉加载数据</span>
				</template>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	/*文章控件*/
	new Vue({
		el:"#ideas",
		data:{
			ideas:[],
			keyword:"",
			page:1,
			loadStatus:false,
			limit:3,
			idea:'',
		},
		created:function(){
			this.getList();
			this.scrollLoad();
		},
		methods:{
			/*获取文章列表*/
			getList:function(){
				var _this=this;
				if(_this.loadStatus){
					return false;
				}else{
					_this.loadStatus=true;
				}
				$.ajax({
					url:"{{ url('customer/idea/getList')}}",
					data:{
						keyWord:_this.keyword,
						page:_this.page,
						limit:_this.limit
					},
					dataType:"json",
					success:function(json){
						if(_this.page>1){
							for(i in json.data){
								_this.ideas.data.push(json.data[i]);
							}
						}else{
							_this.ideas=json;		
						}
						_this.loadStatus=false;
					}
				});
			},
			/*选择显示条件*/
			selectCondition:function(c){
				this.keyword=c;
				this.page=1;
				this.ideas=[],
				this.getList();
			},
			/*滚动至底部加载数据*/
			scrollLoad:function(){
				var _this=this;
				$(document).scroll(function(){  
					if((document.body.scrollHeight-(document.body.clientHeight+document.body.scrollTop))<2){
						if(!_this.loadStatus){
							_this.page++;
							_this.getList();
						}
					}
				});  
			},
			/*提交*/
			submitIdea:function(){
				var _this=this;
				$.ajax({
					url:"{{ url('customer/idea/submit')}}",
					data:{
						idea:_this.idea,
					},
					type:'POST',
					dataType:"json",
					success:function(json){
						if(json.status){
							alert(json.success);
						}else{
							alert(json.error);
						}
					}
				});
			},
		}
	});
</script>
<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->


<!-- 继承整体布局 -->
@extends('front::mobile.common.main2l')

@section('content')
<style type="text/css">
	.am-control-nav{ display: none;}
</style>

<script type="text/javascript" src="{{url('home/wap/js/jquery.touchSwipe.min.js')}}"></script>
<!-- 扩展内容-->
<section>
  <div data-am-widget="tabs" class="am-tabs astation-message"  id='childrenList'>

    
	<div class="am-tab-panel am-active padding0">
				
               	<div class="am-g box_163css readplan2017-conte">
				 
					   <ul class="am-slides readplan2017 line">
				   		<!--孩子的选中状态是：class="active"；-->
				   		<template v-for="s in students">
				   			<li  class="active" v-if="s.id == search.student_id">
								<img class="" :src="s.avatar">
								<span>[[ s.name ]]</span>
							</li>
							<li v-on:click="selectChild(s)"  v-else>
								<img class="" :src="s.avatar">
								<span>[[ s.name ]]</span>
							</li>
				   		</template>
					</ul>
				</div>
			</div>
    <!--/-->
    <div data-am-widget="list_news" class="am-tabs-bd am-list-news" >
    	<div class="chider-bt"><span>我的蕊丁币</span>
    	<div  v-if="selectedStudent"  class="right-area"><img alt="" src="{{ url('home\pc\images\ioc-rdm.png')}}">[[ selectedStudent.point ]]</div>
    	</div><!--/-->
        <div data-tab-panel-0 class="am-active Totalscore"> 
          	<ul class="am-g jfxqy-titile">
          		<li class="am-u-sm-3">日期</li>
          		<li class="am-u-sm-3">收入/支出</li>
          		<li class="am-u-sm-3">项目</li>
          		<li class="am-u-sm-3">蕊丁币数量</li>
          	</ul>
			<ul class="Totalscore-list am-g jfxqy-lsit">
			 	<li class="am-g" v-for=' l in logs.data'>
			 		<div class="am-u-sm-3">[[ l.created_at ]]</div>
				 	<div  class="am-u-sm-3" v-if='l.point>=0'>收入</div>
				 	<div class="am-u-sm-3" v-else>支出</div>
				 	<div class="am-u-sm-3">[[ l.memo ]]</div>
				 	<div class="am-u-sm-3">[[ Math.abs(l.point) ]]</div>
			 	</li>
			</ul>
			<div class="am-u-sm-12 am-text-center">
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
        </div>
        <!--/data-tab-panel-0  am-tab-panel-->

    </div>
  </div>
</section>

<script type="text/javascript">
new Vue({
	 el:'#childrenList',
	 data:{
		students:{!! $students->toJson() !!},
		selectedStudent: null,
		logs:null,
		search:{
				student_id:null,
				page:1,
				limit:5
		},
		loadStatus:false,
		ajax:null
	},
	computed:{
		loadEnd: function(){
			var a=this.logs.current_page>=this.logs.last_page;
			if(a){
				return true;
			}else{
				return false;
			}
		}
	},
	created:function(){
			if(this.students[0]){
				this.selectChild(this.students[0]);
			}
			this.scrollLoad();
	},
	methods:{
		doGetLogs:function(){
			var _this=this;
			_this.loadData=0;
			if(_this.loadEnd){
				return;
			}
			_this.loadStatus=true;
			_this.ajax=$.ajax({
					url:"{{url('member/children/pointLog/getLogs')}}",
					dataType:"json",
					data:_this.search,
					success:function(json){
						if(_this.search.page>1){
							for(i in json.data){
								_this.logs.data.push(json.data[i]);
							}
							_this.logs.current_page=_this.search.page;
						}else{
							_this.logs=json;
						}
						_this.loadStatus=false;
					},
					error:function(){
						_this.loadData=2;
						_this.loadStatus=false;
					}
			});
		},
		selectChild:function(s){
			this.selectedStudent = s;
			this.search.student_id=s.id;
			this.search.page=1;
			this.logs=null;
			if (this.ajax) {
				this.ajax.abort();
			}
			this.doGetLogs();
		},
		/*滚动至底部加载数据*/
		scrollLoad:function(){
			var _this=this;
			$(document).scroll(function(){
				if((document.body.scrollHeight-(document.body.clientHeight+document.body.scrollTop))<20){
					if(!_this.loadStatus){
						_this.search.page++;
						_this.doGetLogs();
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

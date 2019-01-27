<!-- 继承整体布局 -->
@extends('front::mobile.common.main2l')

@section('content')
<style type="text/css">
	.am-control-nav{ display: none;}
</style>
<!-- 扩展内容-->
<script type="text/javascript" src="{{url('home/wap/js/jquery.touchSwipe.min.js')}}"></script>
<section>
    <div data-am-widget="tabs" class="am-tabs astation-message"    id="readPlans" >
		
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
		   
		    	<div class="chider-bt"><span>我的书单</span></div><!--/-->
				<!--<h4 class="my-plan-titile"><i class="am-icon-bookmark"></i><b>我的计划</b></h4>-->
		     	<ul class="children-reard-list" style="padding: 0 15px;" v-if="listdata.data.length">
		     		<li class="am-g reardlist-box" v-for="rp in listdata.data">
		     			<div>
		     				<div class="readplan-item-name">[[rp.plan_name]]</div>
		     				<div class="readplan-item-date">[[rp.from]]~[[rp.to]]</div>
		     			</div>
                		<div class="padding0 fr">
                			<a v-if="rp.status!=-1" href="{{url('member/children/readplan/detail')}}/[[rp.id]]" class="blade-buttom-3-01 fl">查看详情</a>
                			<a v-else href="javascript:alert('老师正在制定阅读计划,请耐心等待！')" class="blade-buttom-3-01 fl">查看详情</a>
                		</div>
		     		</li>
		     	</ul>
		     	 <div v-else style="text-align: center">暂时没有您的书单~</div>
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
	var readPlans=new Vue({
			el:"#readPlans",
			data:{
				listdata:null,
				student:null,
				students:{!! $students !!},
				search:{
					type: 0,
					student_id:0,
					page:1,
					limit:5
				},
				loadStatus:false,
				ajax:null,
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
				if(this.students[0]){
					this.student=this.students[0];
					this.search.student_id=this.students[0].id;
					this.getReadPlans();
				}
				this.scrollLoad();
			},
			methods:{
				//获取阅读计划
				getReadPlans:function(){
					var _this=this;
					if(_this.loadStatus){
						return;
					}
					_this.loadStatus=true;
					_this.ajax=$.ajax({
							url:"{{url('borrowService/myBooks/getPlans')}}",
							dataType:"json",
							data:_this.search,
							success:function(json){
								if(json.status){
									if(_this.search.page>1){
										for(i in json.data.data){
											_this.listdata.data.push(json.data.data[i]);
										}
										_this.listdata.current_page=_this.search.page;
									}else{
										_this.listdata=json.data;
									}
								}else{
									amazeAlert({
										title: '提示',
										msg: json.error
									})
								}
								_this.loadStatus=false;
							},
							error:function(){
								_this.loadStatus=false;
							}
					});
				},
				//翻页
				doChangePage:function(page){
					this.search.page=page;
					this.getReadPlans();
				},
				//选择孩子
				selectChild:function(s){
					this.ajax.abort();
					this.student=s;
					this.search.student_id=s.id;
					this.search.page=1;
					this.getReadPlans();
				},
				/*滚动至底部加载数据*/
				scrollLoad:function(){
					var _this=this;
					$(document).scroll(function(){
						if((document.body.scrollHeight-(document.body.clientHeight+document.body.scrollTop))<20){
							if(!_this.loadStatus && !_this.loadEnd){
								_this.search.page++;
								_this.getReadPlans();
							}
						}
					});  
				}
			}
	});		
</script>
<!-- //扩展内容--> 
@endsection
<!-- //继承整体布局 -->

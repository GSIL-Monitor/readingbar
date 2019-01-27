<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')

	
<!-- 包含会员菜单 -->
<!-- 扩展内容-->
<style type="text/css">
	body{ background: #fafafa;}
</style>
<div id="main"> 
	<div class="container">
		<div class="row padt9">
		  	<div class="col-md-2 home-column-fl">
		  		@include('front::default.member.memberMenu')
		    </div>
		
			<div class="col-md-10 home-column-fr500" id="readPlans">
				<div class="home-column-fr500-01 aminyy">
				    <!--孩子-->
					<div class="img-scroll">
					    <span class="prev"></span>
					    <span class="next"></span>
					    <div class="img-list">
					        <ul>
					        	<template v-for="s in students">
					        		<li  v-if="s.id==search.student_id" class="active">
						            	<div class="chider200-tx"><img :src="s.avatar"><em></em></div>
										<span>[[ s.name ]]</span>
						            </li>
						            <li  v-on:click="selectChild(s)" v-else>
						            	<div class="chider200-tx"><img :src="s.avatar"><em></em></div>
										<span>[[ s.name ]]</span>
						            </li>
					        	</template>
					            
					        </ul>
					    </div>
					</div>
					<!--end-->
					
			    </div>
			    <!--/home-column-fr500-->
			    <h4 class="home33-tiitle">我的书单</h4>
			    <div class="home-column-fr500-02">
					<!--/star-test-banner2r-->
					<div  v-if="loadData==0" style="background:url('{{asset('assets/css/plugins/slick/ajax-loader.gif')}}') center center no-repeat;width:100%;height:50px;"></div>
					<!--/-->
					<div  v-if="loadData==1" style="">
		                <ul class="my-plan-list2" style="width: 664px;overflow: hidden;margin: 15px auto 20px; auto" v-if="listdata.data.length">
				           <li class="row" v-for="rp in listdata.data">
				                <div class="col-md-3"  style="width:200px;">[[rp.plan_name]]</div>
				                <div class="col-md-7"  style="width:300px;">[[rp.from]]~[[rp.to]]</div>
				                <div class="col-md-2"  style="width:160px;text-align:right">
				                	<a v-if="rp.status!=-1"   :href="rp.detail">查看详情</a>
				                	<span v-else>书单正在创建中…</span>
				                </div>
				            </li>
				       </ul>
				       <div v-else style="text-align: center">暂时没有您的书单~</div>
				        <!--page-->
						<ul class="pagination fr" v-if="listdata.last_page>1" style="margin-right:140px;">
							<li v-if="listdata.current_page>1" v-on:click="doChangePage(1)"><a href="javascript:void(0)">&laquo;</a></li>
							<template v-for="p in listdata.last_page" v-if="Math.abs(listdata.current_page-(p+1))<=3">
								<li v-if="listdata.current_page==p+1" class="active" v-on:click="doChangePage(p+1)"><span>[[ p+1 ]]</span></li>
								<li v-else v-on:click="doChangePage(p+1)"><a href="javascript:void(0)">[[ p+1 ]]</a></li>
							</template>
							<li v-if="listdata.current_page < listdata.last_page" v-on:click="doChangePage(listdata.last_page)"><a href="javascript:void(0)">&raquo;</a></li>
						</ul>
						<!--/-->
		        	</div>
		        	<div  v-if="loadData==2" style="text-align:center;width:100%;height:50px;">
						<span>加载失败!<a v-on:click="getReadPlans()">重新加载</a></span>
					</div>
			    </div>
			    <!--/home-column-fr500-02-->
			</div>
		</div>
		<!--/row-->
	</div>
	
</div>
<script type="text/javascript">
 function DY_scroll(wraper,prev,next,img,speed,or)
 { 
  var wraper = $(wraper);
  var prev = $(prev);
  var next = $(next);
  var img = $(img).find('ul');
  var w = img.find('li').outerWidth(true);
  var s = speed;
  next.click(function()
       {
        img.animate({'margin-left':-w},function()
                  {
                   img.find('li').eq(0).appendTo(img);
                   img.css({'margin-left':0});
                   });
        });
  prev.click(function()
       {
        img.find('li:last').prependTo(img);
        img.css({'margin-left':-w});
        img.animate({'margin-left':0});
        });
  if (or == true)
  {
   ad = setInterval(function() { next.click();},s*1000);
   wraper.hover(function(){clearInterval(ad);},function(){ad = setInterval(function() { next.click();},s*1000);});
  }
 }
 DY_scroll('.img-scroll','.prev','.next','.img-list',30,false);// true为自动播放，不加此参数或false就默认不自动
</script>

<script type="text/javascript">
	var readPlans=new Vue({
			el:"#main",
			data:{
				listdata:null,
				student:null,
				students:{!! $students !!},
				search:{
					student_id:0,
					page:1,
					limit:5
				},
				loadData:0
			},
			created:function(){
				if(this.students[0]){
					this.student=this.students[0];
					this.search.student_id=this.students[0].id;
					this.getReadPlans();
				}
			},
			methods:{
				//获取阅读计划
				getReadPlans:function(){
					var _this=this;
					_this.loadData=0;
					$.ajax({
							url:"{{url('borrowService/myBooks/getPlans')}}",
							dataType:"json",
							data:_this.search,
							success:function(json){
								if(json.status) {
									_this.listdata=json.data;
								}else {
									appAlert({
										title:'提示',
										msg: json.error
									})
								}
								_this.loadData=1;
							},
							error:function(){
								_this.loadData=2;
							}
					});
				},
				showModal:function(){
					$("#freeStarStuddent").modal('show');
				},
				//翻页
				doChangePage:function(page){
					this.search.page=page;
					this.getReadPlans();
				},
				//选择孩子
				selectChild:function(s){
					this.student=s;
					this.search.student_id=s.id;
					this.search.page=1;
					this.getReadPlans();
				}
			}
	});
</script>


@endsection
<!-- //继承整体布局 -->


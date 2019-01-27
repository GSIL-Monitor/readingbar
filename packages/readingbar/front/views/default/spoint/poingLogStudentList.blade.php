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
		
			<div class="col-md-10 home-column-fr500" id="childrenList">
				<div class="home-column-fr500-01 aminyy">
				    <!--孩子-->
					<div class="img-scroll">
					    <span class="prev"></span>
					    <span class="next"></span>
					    <div class="img-list">
					        <ul>
					        
					        	<template v-for="s in students" >
						            <li v-on:click="selectChild(s)" v-if="s.id==search.student_id" class="active">
						            	<div class="chider200-tx"><img :src="s.avatar"><em></em></div>
										<span>[[ s.name ]]</span>
						            </li>
						             <li v-on:click="selectChild(s)" v-else>
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
			    <h4 class="home33-tiitle">我的蕊丁币
			    <span v-if="selectedStudent" class="pointLog"><img alt="" src="{{ url('home\pc\images\ioc-rdm.png')}}">[[ selectedStudent.point ]]</span>
			    </h4>
			    <div class="home-column-fr500-02">
			      
					<div class="row jfxqy">
						<ul class="row jfxqy-titile">
			          		<li class="col-md-3">日期</li>
			          		<li class="col-md-3">获得/支出</li>
			          		<li class="col-md-3">项目</li>
			          		<li class="col-md-3">蕊丁币数量</li>
			          	</ul>
						<ul class="Totalscore-list row jfxqy-lsit">
							<li class="am-g text-align"  v-if="logs==null">
								加载中...
							</li>
						 	<li class="am-g" v-for=' l in logs.data'>
						 		<div class="col-md-3">[[ l.created_at ]]</div>
							 	<div  class="col-md-3" v-if='l.point>=0'>收入</div>
							 	<div class="col-md-3" v-else>支出</div>
							 	<div class="col-md-3">[[ l.memo ]]</div>
							 	<div class="col-md-3">[[ Math.abs(l.point) ]]</div>
						 	</li>
						</ul>
						<!--page-->
					<ul class="pagination fr" v-if="logs.last_page>1">
						<li v-if="logs.current_page>1" v-on:click="doChangePage(1)"><a href="javascript:void(0)">&laquo;</a></li>
						<template v-for="p in logs.last_page" v-if="Math.abs(logs.current_page-(p+1))<=3">
							<li v-if="logs.current_page==p+1" class="active" v-on:click="doChangePage(p+1)"><span>[[ p+1 ]]</span></li>
							<li v-else v-on:click="doChangePage(p+1)"><a href="javascript:void(0)">[[ p+1 ]]</a></li>
						</template>
						<li v-if="logs.current_page < logs.last_page" v-on:click="doChangePage(logs.last_page)"><a href="javascript:void(0)">&raquo;</a></li>
					</ul>
					<!--/-->
					</div>
		        	
			    </div>
			    <!--/home-column-fr500-02-->
			</div>
		</div>
		<!--/row-->
	</div>
	<!--/container-->


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
 new Vue({
	 el:'#childrenList',
	 data:{
		students:{!! $students->toJson() !!},
		logs:null,
		selectedStudent: null,
		search:{
				student_id:null,
				page:1,
				limit:5
		}
	},
	created:function(){
			if(this.students[0]){
				this.selectChild(this.students[0]);
			}
	},
	methods:{
		doGetLogs:function(){
			var _this=this;
			_this.loadData=0;
			_this.logs=null;
			$.ajax({
					url:"{{url('member/children/pointLog/getLogs')}}",
					dataType:"json",
					data:_this.search,
					success:function(json){
						_this.logs=json;
					},
					error:function(){
						_this.loadData=2;
					}
			});
		},
		doChangePage:function(page){
			this.search.page=page;
			this.doGetLogs();
		},
		selectChild:function(s){
			this.search.student_id=s.id;
			this.selectedStudent = s;
			this.doChangePage(1);
		}
	}
});
</script>


@endsection
<!-- //继承整体布局 -->


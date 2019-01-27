<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')
<!-- 扩展内容-->
<style type="text/css">
	body{ background: #fafafa;}
</style>
<div class="container padt9">
	<div class="row">
	  	<div class="col-md-2 home-column-fl">
	  		@include('front::default.member.memberMenu')
	    </div>
	    <!--/ home-column-fl end-->
	    <div id="reportList" class="col-md-10 home-column-fr500">
		    <div class="home-column-fr500-01 aminyy">
			    <!--孩子-->
				<div class="img-scroll">
				    <span class="prev"></span>
				    <span class="next"></span>
				    <div class="img-list">
				        <ul>
				        	<template  v-for="s in students">
					            <li  v-if="s.id==search.student_id" class="active" >
					            	<div class="chider200-tx"><img :src="s.avatar"><em></em></div>
									<span>[[ s.name ]]</span>
					            </li>
					           	 <li v-on:click="selectChild(s.id)"  v-else>
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
		    <h4 class="home33-tiitle">我的报告</h4>
		    <div class="home-column-fr500-02 aminyy">
		    	<ul id="myTab" class="nav myreportnav-tabs">
					<li class="active col-md-4"><a href="#allreport" data-toggle="tab" v-on:click="setReportType('')"> 全部报告</a></li>
					<li class="col-md-4"><a href="#allreport" data-toggle="tab" v-on:click="setReportType(1)">阶段报告</a></li>
					<li class="col-md-4"><a href="#allreport" data-toggle="tab" v-on:click="setReportType(0)">STAR报告</a></li>
				</ul>
				<div id="myTabContent" class="myreporttab-content">
					<div class="tab-pane fade in active" id="allreport">
						<div class="text-center" v-if="listdata==null">正在加载中...</div>
						<ul class="myreportslsit" v-else>
							<template v-for="d in listdata.data" >
								<li class="col-md-2"  v-on:mouseenter="onReport(d.id)"  v-on:mouseleave="leaveReport(d.id)"  :id="'report_id_'+d.id" v-if="d.report_type==0">
									<div class="myreportst-ico01"><img src="{{url('home/pc/images/2017/baogao100_02.png')}}"></div>
									<div class="myreportst-ico02"><img src="{{url('home/pc/images/2017/baogao100_01.png')}}"></div>
									<h4	title="STAR报告-[[ d.name ]]" style="overflow:hidden;white-space:nowrap;text-overflow:ellipsis; width:90%;">STAR报告-[[ d.name ]]</h4>
									<span>[[ d.dateline ]]</span>
									<div class="achover">
										<a href="javascript:void(0)"  v-on:click="showPdf(d,'pdf_zh')">中</a>
										<a href="javascript:void(0)"  v-on:click="showPdf(d,'pdf_en')">英</a>
										<a href="javascript:void(0)"  :href="d.booklist">书</a>
									</div>
								</li>
								
								<li class="col-md-2"  v-on:mouseenter="onReport(d.id)"  v-on:mouseleave="leaveReport(d.id)"  :id="'report_id_'+d.id" v-if="d.report_type==1">
									<div class="myreportst-ico01"><img src="{{url('home/pc/images/2017/baogao100_02.png')}}"></div>
									<div class="myreportst-ico02"><img src="{{url('home/pc/images/2017/baogao100_01.png')}}"></div>
									<h4 title="STAR报告-[[ d.name ]]" style="overflow:hidden;white-space:nowrap;text-overflow:ellipsis; width:100%;">阶段报告-[[ d.name ]]</h4>
									<span>[[ d.dateline ]]</span>
									<div class="achover text-center">
										<a href="javascript:void(0)"  v-on:click="showPdf(d,'pdf_stage')" style="margin: 0px">阶</a>
									</div>
								</li>
								
							</template>
							
						</ul>
					</div>
				</div>
			


		    </div>
		    <!--/home-column-fr500-01-->
		  	<!--page-->
			<ul class="pagination fr" v-if="listdata.last_page>1">
				<li v-if="listdata.current_page>1" v-on:click="doChangePage(1)"><a href="javascript:void(0)">&laquo;</a></li>
				<template v-for="p in listdata.last_page" v-if="Math.abs(listdata.current_page-(p+1))<=3">
					<li v-if="listdata.current_page==p+1" class="active" v-on:click="doChangePage(p+1)"><span>[[ p+1 ]]</span></li>
					<li v-else v-on:click="doChangePage(p+1)"><a href="javascript:void(0)">[[ p+1 ]]</a></li>
				</template>
				<li v-if="listdata.current_page < listdata.last_page" v-on:click="doChangePage(listdata.last_page)"><a href="javascript:void(0)">&raquo;</a></li>
			</ul>
			<!--/-->
		</div>
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
 var reportList=new Vue({
		el:"#reportList",
		data:{
			listdata:null,
			students:{!! $students !!},
			search:{
				student_id:"",
				report_type:null,
				page:1,
				limit:12,
				order:'updated_at',
				sort:'desc'
			},
			pdf:null
		},
		created:function(){
			this.doGetReports();
		},
		methods:{
			doGetReports:function(){
				var _this=this;
				_this.listdata=null
				$.ajax({
					url:"{{url('api/member/children/star/report')}}",
					dataType:"json",
					data:_this.search,
					success:function(json){
						_this.listdata=json;
					}
				});
			},
			setStarReport:function(sid,type){
				this.search.student_id=sid;
				this.search.report_type=type;
				this.search.page=1;
				this.doGetReports();
			},
			showPdf:function(r,type){
				if(type =='pdf_zh') {
					window.open("{{url('member/children/starReport/SRD')}}/"+r.id);
				}else{
					url=r[type];
					window.open(url);
				}
			},
			hidePdf:function(){
				this.pdf=null;
			},
			doChangePage:function(page){
				this.search.page=page;
				this.doGetReports();
			},
			selectChild:function(sid){
				this.search.student_id=sid;
				this.doChangePage(1);
			},
			setReportType:function(type){
				this.search.report_type=type;
				this.doChangePage(1);
			},
			onReport:function(id){
				 $("#report_id_"+id).find(".achover").show();
				 $("#report_id_"+id).find(".myreportst-ico02").show();
				 $("#report_id_"+id).find(".myreportst-ico01").hide();
			},
			leaveReport:function(id){
				 $("#report_id_"+id).find(".achover").hide();
				 $("#report_id_"+id).find(".myreportst-ico02").hide();
				 $("#report_id_"+id).find(".myreportst-ico01").show();
			}
		}
	 });
</script>
<!-- //扩展内容--> 
@endsection
<!-- //继承整体布局 -->

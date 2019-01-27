<!-- 继承整体布局 -->
@extends('front::mobile.common.main2l')

@section('content')
<style type="text/css">
	.am-control-nav{ display: none;}
</style>
<script type="text/javascript" src="{{url('home/wap/js/jquery.touchSwipe.min.js')}}"></script>
<!-- 扩展内容-->
<section>
	<div class="am-tabs astation-message" data-am-tabs="{noSwipe: 1}" id="reportList" >
		<!--/-->
		<div class="am-tabs-bd">
		    <div class="am-tab-panel am-active padding0" id="reportList">
				
               	<div class="am-g box_163css readplan2017-conte">
				 
					   <ul class="am-slides readplan2017 line">
					   		<template  v-for="s in students">
								<li  v-if="s.id==search.student_id" class="active" >
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
                <!--/readplan2017-conte-->
                <div class="am-tab-panel am-active padding0">
		    		<div class="chider-bt"><span>我的报告</span></div><!--/-->
					<div class="am-tabs" data-am-tabs>
					  	<ul class="am-tabs-nav am-nav bgam-nav">
						    <li class="am-u-sm-4 am-active" v-on:click="setReportType('')"><a href="#tab1">全部报告</a></li>
						    <li class="am-u-sm-4" v-on:click="setReportType('0')"><a href="#tab2">STAR报告</a></li>
						    <li class="am-u-sm-4" v-on:click="setReportType('1')"><a href="#tab3">阶段报告</a></li>
					 	</ul>
						<div class="am-tabs-bd">
						    <div class="am-tab-panel bgtab-panel am-fade am-in am-active" id="tab1">
						   		<ul class="panellsit01">
							   		<template v-for="d in listdata.data" >
							    		<li class="am-g" v-if="d.report_type==0"> 
							    			<div class="am-u-sm-2"><img src="{{url('home/wap/images/2017/icon/ccc_03.png')}}"  alt=""/></div>
							    			<div class="am-u-sm-5">
							    				<h4>STAR报告-[[ d.name ]]</h4>
							    				<span>[[ d.dateline ]]</span>
							    			</div>
							    			<div class="am-u-sm-5 padding0" style="text-align: center;">
							    				<a href="#"  class="gbbuttom" v-on:click="showPdf(d,'pdf_zh')">中</a>
							    				<a href="#"  class="gbbuttom" v-on:click="showPdf(d,'pdf_en')">英</a>
							    				<a href="#"  class="gbbuttom" :href="d.booklist">书</a>
							    			</div>
							    		</li>
							    		<li class="am-g" v-if="d.report_type==1"> 
							    			<div class="am-u-sm-2"><img src="{{url('home/wap/images/2017/icon/ccc_03.png')}}"  alt=""/></div>
							    			<div class="am-u-sm-5">
							    				<h4>阶段报告-[[ d.name ]]</h4>
							    				<span>[[ d.dateline ]]</span>
							    			</div>
							    			<div class="am-u-sm-5 padding0" style="text-align: center;">
							    				<a href="#" class="gbbuttom"  v-on:click="showPdf(d,'pdf_stage')">阶段报告</a>
							    			</div>
							    		</li>
							    	</template>
						    	</ul>
						    </div>
						     <div class="am-tab-panel bgtab-panel am-fade am-in" id="tab2">
						   		<ul class="panellsit01">
							   		<template v-for="d in listdata.data" >
							    		<li class="am-g" v-if="d.report_type==0"> 
							    			<div class="am-u-sm-2"><img src="{{url('home/wap/images/2017/icon/ccc_03.png')}}"  alt=""/></div>
							    			<div class="am-u-sm-5">
							    				<h4>STAR报告-[[ d.name ]]</h4>
							    				<span>[[ d.dateline ]]</span>
							    			</div>
							    			<div class="am-u-sm-5 padding0" style="text-align: center;">
							    				<a href="#"  class="gbbuttom" v-on:click="showPdf(d,'pdf_zh')">中</a>
							    				<a href="#"  class="gbbuttom" v-on:click="showPdf(d,'pdf_en')">英</a>
							    				<a href="#"  class="gbbuttom" :href="d.booklist">书</a>
							    			</div>
							    		</li>
							    		<li class="am-g" v-if="d.report_type==1"> 
							    			<div class="am-u-sm-2"><img src="{{url('home/wap/images/2017/icon/ccc_03.png')}}"  alt=""/></div>
							    			<div class="am-u-sm-5">
							    				<h4>阶段报告-[[ d.name ]]</h4>
							    				<span>[[ d.dateline ]]</span>
							    			</div>
							    			<div class="am-u-sm-5 padding0" style="text-align: center;">
							    				<a href="#" class="gbbuttom"  v-on:click="showPdf(d,'pdf_stage')">阶段报告</a>
							    			</div>
							    		</li>
							    	</template>
						    	</ul>
						    </div>
						     <div class="am-tab-panel bgtab-panel am-fade am-in" id="tab3">
						   		<ul class="panellsit01">
							   		<template v-for="d in listdata.data" >
							    		<li class="am-g" v-if="d.report_type==0"> 
							    			<div class="am-u-sm-2"><img src="{{url('home/wap/images/2017/icon/ccc_03.png')}}"  alt=""/></div>
							    			<div class="am-u-sm-5">
							    				<h4>STAR报告-[[ d.name ]]</h4>
							    				<span>[[ d.dateline ]]</span>
							    			</div>
							    			<div class="am-u-sm-5 padding0" style="text-align: center;">
							    				<a href="#" class="gbbuttom" v-on:click="showPdf(d,'pdf_zh')">中文报告</a>
							    				<a href="#" class="gbbuttom" v-on:click="showPdf(d,'pdf_en')">英文报告</a>
							    			</div>
							    		</li>
							    		<li class="am-g" v-if="d.report_type==1"> 
							    			<div class="am-u-sm-2"><img src="{{url('home/wap/images/2017/icon/ccc_03.png')}}"  alt=""/></div>
							    			<div class="am-u-sm-5">
							    				<h4>阶段报告-[[ d.name ]]</h4>
							    				<span>[[ d.dateline ]]</span>
							    			</div>
							    			<div class="am-u-sm-5 padding0" style="text-align: center;">
							    				<a href="#" class="gbbuttom"  v-on:click="showPdf(d,'pdf_zh')">阶段报告</a>
							    			</div>
							    		</li>
							    	</template>
						    	</ul>
						    </div>
					  	</div>
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
					</div>
					<!--/-->
		    	</div>
		    </div>
		</div>
    </div>
</section>

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
				limit:5,
				order:'updated_at',
				sort:'desc'
			},
			pdf:null,
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
			this.doGetReports();
			this.scrollLoad();
		},
		methods:{
			doGetReports:function(){
				var _this=this;
				if(_this.loadStatus){
					return;
				}
				_this.loadStatus=true;
				$.ajax({
					url:"{{url('api/member/children/star/report')}}",
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
			selectChild:function(s){
				this.search.student_id=s.id;
				this.listdata=null;
				this.search.page=1;
				this.doGetReports();
			},
			setReportType:function(type){
				this.search.report_type=type;
				this.listdata=null;
				this.search.page=1;
				this.doGetReports();
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
			},
			/*滚动至底部加载数据*/
			scrollLoad:function(){
				var _this=this;
				$(document).scroll(function(){
					if((document.body.scrollHeight-(document.body.clientHeight+document.body.scrollTop))<20){
						if(!_this.loadStatus && !_this.loadEnd){
							_this.search.page++;
							_this.doGetReports();
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

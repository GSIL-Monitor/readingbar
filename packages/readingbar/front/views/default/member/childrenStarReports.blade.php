<div class="tab-pane fade in active" id="myreport">
		<div  v-if="loadData==0" style="background:url('{{asset('assets/css/plugins/slick/ajax-loader.gif')}}') center center no-repeat;width:100%;height:50px;">
			
		 </div>
       <div class="content" v-if="loadData==1">
       		<template v-if="pdf">
				<div class="content">
					<a href="javascript:void(0)" v-on:click="hidePdf()" style="float:right">返回</a>
					<br>
					<iframe src="[[pdf]]" width="100%" height="80%"></iframe>
				</div>
			</template>
			<ul class="user-blade-list" v-else>
				<li v-for="r in listdata.data">
					<div class="user-blade-nr fl">
						<span>[[r.updated_at]]</span>
						<div class="user-blade-tittle">
							<img src="{{url('home/pc/images/ioc_20.jpg')}}" class="fl">
							<h4 class="fl">[[r.report_id]]</h4>
						</div>
					</div>
					<!--/-->
					<div class="user-blade-buttom fr">
						<a href="javascript:void(0)" v-on:click="showPdf(r,'zh')" class="blade-buttom-1">中文报告</a>
						<a href="javascript:void(0)" v-on:click="showPdf(r,'en')" class="blade-buttom-2">英文报告</a>
					</div>
					<!--/-->
				</li>
			</ul>
<!--page-->
		<ul class="pagination fr" v-if="total_pages>1">
		    <li v-if="listdata.current_page>1" v-on:click="dochangepage(1)"><a href="javascript:void(0)">&laquo;</a></li>
    		<template v-for="p in listdata.total_pages" v-if="Math.abs(listdata.current_page-(p+1))<=3">
    			<li v-if="listdata.current_page==p+1" class="active" v-on:click="dochangepage(p+1)"><span>[[ p+1 ]]</span></li>
    			<li v-else v-on:click="dochangepage(p+1)"><a href="javascript:void(0)">[[ p+1 ]]</a></li>
    		</template>
	     	<li v-if="result.current_page < listdata.total_pages" v-on:click="dochangepage(listdata.total_pages)"><a href="javascript:void(0)">&raquo;</a></li>
		</ul>
		
		<!--/-->
</div>  

<div  v-if="loadData==2" style="text-align:center;width:100%;height:50px;">
	<span>加载失败!<a v-on:click="doGetReports">重新加载</a></span>
</div>
<!--/-->
    </div>
<script type="text/javascript">
 var myreport=new Vue({
		el:"#myreport",
		data:{
			listdata:null,
			search:{
				student_id:"{{$student['id']}}",
				page:1,
				limit:4,
				order:'updated_at',
				sort:'desc'
			},
			pdf:null,
			loadData:0
		},
		methods:{
			doGetReports:function(){
				var _this=this;
				_this.loadData=0;
				$.ajax({
					url:"{{url('api/member/children/star/report')}}",
					dataType:"json",
					data:_this.search,
					success:function(json){
						if(json.status){
							_this.listdata=json;
						}else{
							alert(json.error);
						}
						_this.loadData=1;
					},
					error:function(){
						_this.loadData=2;
					}
				});
			},
			showPdf:function(r,type){
				url="{{url('api/member/children/star/readReport/'.$student['id'])}}/"+r.id+"/"+type;
				this.pdf=url;
			},
			hidePdf:function(){
				this.pdf=null;
			},
			dochangepage:function(page){
				this.search.page=page;
				this.doGetReports();
			}
		}
	 }).doGetReports();
</script>
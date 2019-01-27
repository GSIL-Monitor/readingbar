<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')

<!-- 扩展内容-->
<link href="{{url('assets/css/plugins/cropper/cropper.min.css')}}" rel="stylesheet">
<script src="{{url('assets/js/plugins/cropper/cropper.min.js')}}"></script>
<div class="container" id="ReadPlanDetail">
    <div class="row padt9">
	  <div class="col-md-2 home-column-fl">
	  	@include('front::default.member.memberMenu')
	  </div>
	  <!--/ home-column-fl end-->
	   <div class="col-md-10 home-column-fr100" >
	        <ul class="nav nav-tabs">
				<li role="presentation" class="active"><a href="#">阅读计划</a></li>
			</ul>
			<div style="clear:both"></div>
			<div v-if="pdf" class="content mgl-40">
				<h1 class="plan-read-title">本月阅读书目信息</h1>
				<a href="javascript:void(0)" v-on:click="hidePdf()" style="float:right">返回</a>
				<br>
				<iframe src="[[pdf]]" width="100%" height="80%"></iframe>
			</div>
			<div v-else class="content mgl-40">
            <h1 class="plan-read-title">本月阅读书目信息</h1>
            <div class="plan-read-catalog">
            	<table class="table table-bordered">
					<thead>
						<tr class="plan-read-catalog-list">
							<th>书名</th>
							<th>书籍摘要</th>
							<th>BL</th>
							<th>Type</th>
							<th>书评</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="d in readPlan.details">
							<td style="width: 25%;position: relative;">《[[ d.book_name ]]》

							</td>
							<td>
								[[d.summary]]
							</td>
							<td>
								[[d.BL]]
							</td>
							<td>
								[[d.type]]
							</td>
							<td class="color66" style="min-width:100px">
								<a v-if="readPlan.status>=1" href="javascript:void(0)" v-on:click="goCommentForBook(d.book_id)">查看>></a>
								<span v-else>暂无</span>
							</td>
						</tr>
					</tbody>
				</table>
             </div>
             <div class="plan-read-txt">
            	<span>本月阅读报告</span><a :href='readPlan.Mr_pdf' v-if='readPlan.Mr_pdf'>查看>></a>
            </div>
            <div class="plan-read-txt">
            	<span>阅读建议</span>
				<p v-for='p in readPlan.proposal'>[[$index+1]]. [[p.proposal]] </p>
            </div>
             <div class="plan-read-txt">
            	<span>本月目标</span>
				<p v-for='g in readPlan.goals'>[[$index+1]]. [[g.goals]] </p>
            </div>
             <div class="plan-read-txt" v-if="readPlan.express_1|| readPlan.express_2">
            	<span>物流信息</span>
            	<p v-if="readPlan.express_1">
            		借书:【[[ readPlan.express_1.express_name ]]】【[[  readPlan.express_1.cost ]]元】【[[  readPlan.express_1.logistic_code ]]】
<!--             		<a v-on:click="getTraces (readPlan.express_1)">[物流跟踪]</a> -->
            	</p>
            	<p v-if="readPlan.express_2">
            		还书:【[[ readPlan.express_2.express_name ]]】【[[  readPlan.express_2.cost ]]元】【[[  readPlan.express_2.logistic_code ]]】
<!--             		<a v-on:click="getTraces (readPlan.express_2)">[物流跟踪]</a> -->
            	</p>
             </div>
           </div>	
		   <!--content-->
		   <div class="plan-read-agree" v-if="readPlan.status==0">
				<span>你是否同意本次的阅读计划?</span>
				<button class="plan-read-agree-01" v-on:click="doAgreeRP()"> 是 </button>
				<button class="plan-read-agree-02" v-on:click="doUnagreeRP()"> 否 </button>
		    </div>
		</div>
		
		<!--
        <div class="col-md-10 home-column-fr plan-ftp" id="">

        </div>/-->
		<!--/-->
	</div>
	<!--/row end-->
	<!-- 模态框（Modal） -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="width: 1200px;">
			<div class="modal-content">
				<div class="modal-body">
					<div id="myCarousel" class="carousel slide">
						<!-- 轮播（Carousel）项目 -->
						<div class="carousel-inner" >
						<template v-for='img in images'>
							<div v-if='$index==0' class="item active" >
								<img :src="img.href" style="margin: 0 auto">
							</div>
							<div v-else class="item " >
								<img :src="img.href" style="margin: 0 auto">
							</div>
						</template>
						</div>
						<!-- 轮播（Carousel）导航 -->
						<a class="carousel-control left an-01" href="#myCarousel" data-slide="prev"><img src="{{url('home/pc/images/zuo.png')}}"></a>
						<a class="carousel-control right an-02" href="#myCarousel"  data-slide="next"><img src="{{url('home/pc/images/you.png')}}"></a>
					</div> 
	
	
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal -->		    
	</div>
	<div class="modal fade" id="tracesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						    <div class="modal-dialog">
						        <div class="modal-content">
						            <div class="modal-header">
						                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						                <h4 class="modal-title" id="myModalLabel">物流跟踪</h4>
						            </div>
						            <div class="modal-body">
										<div class="row"  v-if="!traces && !tracesMessage">
											<div class="col-md-12 text-center" >
												<i class="fa fa-spin fa-refresh"></i>
											</div>
										</div>
										<div class="row" v-else-if="traces && （traces.State == 0 || traces.State == 4）">
											<div class="col-md-12 text-center" >
												[[ traces.Reason ]]
											</div>
										</div>
										<ul class="timeline" v-else-if="traces && (traces.State == 1 || traces.State == 2 || traces.State == 3)">
										    <li class="time-label" v-for='d in traces.Traces'>
										        <span class="bg-red">
										            [[ d.AcceptTime ]]
										        </span>
										        <div class="timeline-item">
										        	[[ d.AcceptStation ]]
										        </div>
										    </li>
										</ul>
										<div class="row" v-else-if = 'tracesMessage'>
											<div class="col-md-12 text-center" >
												[[ tracesMessage ]]
											</div>
										</div>
									</div>
						            <div class="modal-footer">
						                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
						            </div>
						        </div><!-- /.modal-content -->
						    </div><!-- /.modal -->
		</div>
</div>
<style type="text/css">
	.an-01 img{    top: 50%;margin-top: -20px;position: absolute;left: 35px;}
	.an-02 img{top: 50%;margin-top: -20px;position: absolute;right: 35px;}
</style>











<script type="text/javascript">
	var ReadPlanDetail=new Vue({
		el:"#ReadPlanDetail",
		data:{
			readPlan:{!! json_encode($readPlan) !!},
			pdf:null,
			images:[],
			traces: null,
			tracesMessage: null,
			tracesAjax:null
		},
		methods:{
			goCommentForBook:function(bid){
				var url="{{url('book/comment')}}?student_id="+this.readPlan.student_id+"&book_id="+bid;
				window.location.href=url;
			},
			showPdf:function(d){
				this.pdf=d;
			},
			hidePdf:function(){
				this.pdf=null;
			},
			/*同意本次阅读计划*/
			doAgreeRP:function(){
				var _this=this;
				$.ajax({
					url:"{{ url('api/member/children/readplan/agree') }}",
					data:{plan_id:_this.readPlan.id},
					dataType:"json",
					success:function(json){
						if(json.status){
							appAlert({
								title: '提示',
								msg: json.success
							});
							_this.readPlan.status=1;
						}else{
							appAlert({
								title: '提示',
								msg: json.error
							});
						}
					}
				});
			},
			/*不同意本次阅读计划*/
			doUnagreeRP:function(){
				var _this=this;
				$.ajax({
					url:"{{ url('api/member/children/readplan/unagree') }}",
					data:{plan_id:_this.readPlan.id},
					dataType:"json",
					success:function(json){
						if(json.status){
							appAlert({
								title: '提示',
								msg: json.success
							});
							_this.readPlan.status=-1;
						}else{
							appAlert({
								title: '提示',
								msg: json.error
							});
						}
					}
				});
			},
			/* 物流跟踪*/
			getTraces (express) {
				var _this = this
				if (_this.tracesAjax) {
					_this.tracesAjax.abort();
				}
				_this.traces = null
				_this.tracesMessage = null
				$("#tracesModal").modal();
				_this.tracesAjax=$.ajax({
					url: "{{ url('admin/express/traces') }}/"+express.id,
					type: "get",
					dataType: 'json',
					success: function (json) {
						_this.traces = json
					},
					error: function (e){
						_this.tracesMessage = e.responseText.trim()
					}
				});
			},
			showImages:function(d){
				this.images=d.images;
				$("#myModal").modal('show');
			}
		}
	});
</script>
<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

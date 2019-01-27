<!-- 继承整体布局 -->
@extends('front::mobile.common.main2l')

@section('content')

<!-- 扩展内容-->
<section >
<div id="ReadPlanDetail">
	<div class="am-g marginbottom5 reader-list-titile">
		<div class="am-u-sm-6 fl">书名/AR测试编号</div>
        <div class="am-u-sm-3 fl">AR报告</div>
        <div class="am-u-sm-3 fl"></div>
   </div>
	<!--/am-g-->
	<ul class="children-speaker-list">
		<li class="am-g" v-for="d in readPlan.details">
			<div class="am-u-sm-6 fl padding0 reader-list-01">
				<h4>《[[ d.book_name ]]》</h4>
				<span>[[ d.ARQuizNo ]]|[[ d.type ]]|BL:[[ d.BL ]]</span>
			</div>
	        <div class="am-u-sm-3 fl  reader-list-an01">
	        	<a v-if="d.Ar_pdf_rar_zh || d.Ar_pdf_vt_zh　|| d.Ar_pdf_rwaar_zh" href="{{ url('member/children/readplan/arreports/[[d.id]]/zh') }}" class="">中文</a>
	        	<a v-else href="javascript:alert('暂无')">中文</a>
	        	<a v-if="d.Ar_pdf_rar_en || d.Ar_pdf_vt_en　|| d.Ar_pdf_rwaar_en" href="{{ url('member/children/readplan/arreports/[[d.id]]/en') }}" class="">英文</a>
	        	<a v-else href="javascript:alert('暂无')">英文</a>
	        </div>
	        <div class="am-u-sm-3 fl padding0 reader-list-an03">
	        	<a v-if="readPlan.status>=1" href="javascript:void(0)" v-on:click="goCommentForBook(d.book_id)">书评</a>
	        	<a v-else href="javascript:alert('暂时无法评论')">书评</a>
	        </div>
		</li>
	</ul>
	<div class="am-g  plan-read-txt">
        <span>阅读建议</span>
	    <p v-for='p in readPlan.proposal'>[[$index+1]]. [[p.proposal]] </p>
    </div>
    <div class=" am-g plan-read-txt">
        <span>本月目标</span>
		<p v-for='g in readPlan.goals'>[[$index+1]]. [[g.goals]] </p>
    </div>
    <div class=" am-g plan-read-txt">
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
   <!--content-->
	<div class=" am-g plan-read-agree" v-if="readPlan.status==0">
	    <span>你是否同意本次的阅读计划?</span>
		<button class="plan-read-agree-01" v-on:click="doAgreeRP()"> 是 </button>
		<button class="plan-read-agree-02" v-on:click="doUnagreeRP()"> 否 </button>
	</div>
	<div class="am-popup" id="my-popup">
	  <div class="am-popup-inner">
	    <div class="am-popup-hd">
	      <span data-am-modal-close class="am-close">&times;</span>
	    </div>
	    <div class="am-popup-bd">
	     	 
				  <ul class="am-slides">
				      <li v-for='img in images'><img :src="img.href"  alt=""/></li>
				  </ul>
		
	    </div>
	  </div>
	</div>
	
	<div class="am-modal am-modal-no-btn" tabindex="-1" id="tracesModal">
	  <div class="am-modal-dialog">
	    <div class="am-modal-hd">物流跟踪
	      <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
	    </div>
	    <div class="am-modal-bd am-text-left">
	     	<div class="row"  v-if="!traces && !tracesMessage">
				<div class="col-md-12 am-text-center" >
					加载中。。。
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
	  </div>
	</div>
</div>
<!--img-->
<style type="text/css">
	.am-slides{}
	.am-slides li img{width: 100%;}
</style>















<!--end-->







</section>

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
				var url="{{url('/book/comment')}}?student_id="+this.readPlan.student_id+"&book_id="+bid;
				window.location.href=url;
			},
			showPdf:function(d,type){
				switch(type){
					case 'en':this.pdf=d.Ar_pdf_en;break;
					case 'zh':this.pdf=d.Ar_pdf_zh;break;
				}
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
							alert(json.success);
							_this.readPlan.status=1;
						}else{
							alert(json.error);
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
							alert(json.success);
							_this.readPlan.status=-1;
						}else{
							alert(json.error);
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


<!-- 继承整体布局 -->
@extends('front::mobile.common.main2l')

@section('content')

<!-- 扩展内容-->
<section>
  <div data-am-widget="tabs" class="am-tabs astation-message">
    <ul class="am-tabs-nav station-message">      
      <li class="am-active"><a href="[data-tab-panel-0]">总积分</a><span>{{ $student->point }}</span></li>
     
    </ul>
    <!--/-->
    <div data-am-widget="list_news" class="am-tabs-bd am-list-news"  id='childrenList'>
        <div data-tab-panel-0 class="am-active Totalscore"> 
          	<ul class="am-g jfxqy-titile">
          		<li class="am-u-sm-3">日期</li>
          		<li class="am-u-sm-3">获得/支出</li>
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
			<!--<div class="am-list-news-ft pab15">
            <a class="am-list-news-more am-btn am-btn-default" href="javascript:void(0)" v-on:click="doChangePage()">查看更多 &raquo;</a>
          </div>
          -->
        </div>
        <!--/data-tab-panel-0  am-tab-panel-->

    </div>
  </div>
</section>

<script type="text/javascript">
new Vue({
	 el:'#childrenList',
	 data:{
		student:{!! $student->toJson() !!},
		logs:null,
		search:{
				page:1,
				limit:5,
		},
		activeCard:{
			student_id:null,
			card:null,
			card_pwd:null,
			address:null,
			name:"{{ auth('member')->member->nickname }}",
			tel:"{{ auth('member')->member->cellphone }}"
		},
		activeCardStatus:false
	},
	created:function(){
			this.search.student_id=this.student.id;
			this.doGetLogs();
	},
	methods:{
		doGetLogs:function(){
			var _this=this;
			_this.loadData=0;
			$.ajax({
					url:"{{url('member/children/pointLog/getLogs')}}",
					dataType:"json",
					data:_this.search,
					success:function(json){
						if(_this.logs!=null){
							for(i in json.data){
								_this.logs.data.push(json.data[i]);
							}
						}else{
								_this.logs=json;
						}
						
					},
					error:function(){
						_this.loadData=2;
					}
			});
		},
		doChangePage:function(){
			this.search.page++;
			this.doGetLogs();
		},
		goStarReport:function(){
			window.location.href=this.student.report_url;
		},
		goReadPlan:function(){
			window.location.href=this.student.readplan_url;
		},
		doDeleteChild:function(cid){
			if(!confirm('是否确认删除！')){
				return ;
			}
			var _this=this;
			$.ajax({
					url:"{{url('api/member/children/deleteChild')}}",
					dataType:"json",
					type:"POST",
					data:{id:cid},
					success:function(json){
						if(json.status){
							alert(json.success);
						   window.location.href="{{ url('member') }}";
						}else{
							alert(json.error);
						}
					}
			});
		},//礼品卡激活表单显示
		showCardModal:function(){
			this.activeCard.student_id=this.student.id;
			this.activeCard.address=this.student.province+this.student.city+this.student.area+this.student.address;
			$("#cardModal").modal({backdrop: 'static', keyboard: false});
		},
		//激活礼品卡
		doActiveCard:function(){
			var _this=this;
			if(_this.activeCardStatus){
				return;
			}else{
				_this.activeCardStatus=true;
			}
			$.ajax({
				url:"{{url('api/member/giftCard/activeCard')}}",
				data:_this.activeCard,
				type:"POST",
				dataType:"json",
				success:function(json){
					if(json.status){
						_this.getChildren();
						$("#cardModal").modal('hide');
						alert(json.success);
					}else{
						alert(json.error);
					}
					_this.activeCardStatus=false;
				},
				error:function(){
					alert('链接失败！');
					_this.activeCardStatus=false;
				}
			});
		},
		
	}
});
</script>
<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

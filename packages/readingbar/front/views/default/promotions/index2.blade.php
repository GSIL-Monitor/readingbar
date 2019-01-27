<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')
<link href="{{url('assets/css/plugins/cropper/cropper.min.css')}}" rel="stylesheet">
<script src="{{url('assets/js/plugins/cropper/cropper.min.js')}}"></script>

<link href="{{url('assets/css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">
<script type="text/javascript" src="{{url('assets/js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>

<script type="text/javascript" src="{{url('home/pc/images/promotion/echarts.min.js')}}"></script>
<script type="text/javascript" src="{{url('home/pc/images/promotion/westeros.js')}}"></script>
<!-- 扩展内容-->
<div class="container" id="promotions">
	<div class="row padt9">
	  <div class="col-md-2 home-column-fl">
	  	@include('front::default.member.memberMenu')
	  </div>
	  <!--/ col-md-2 end-->
	  <div class="col-md-10 home-column-fr100">
            <ul class="nav nav-tabs">
				<li role="presentation" class="active"><a href="#">推广查询</a></li>
			</ul>
			<div style="clear:both"></div>
			<div class="content mgl-40">
				<div class="row">
					<span class="promotion-link fl padding30">推广链接：</span>
					<form action=""  method="POST" enctype="" class="promotion-link-from fl padding30" >
						<input type="text" name=" " class="form-control fl" readonly="readonly"  :value="dashboard.promote_url" style="width:230px;">
						<button class="promotion-link-copy fl" onclick="return false;" v-on:click="doCopyToClipboard()">复制</button>
					</form>
					<img :src="dashboard.promote_qrcode" class="QRcode fl">
				</div>
				<!--/row-->
				<div class="row">
                 	<span class="promotion-link fl padding30">时间选择:</span>
                 	<ul class="padding30 time-selec fl">
                 		<li><a href="javascript:void(0)" v-on:click="setTimeInterval('today')">今天</a></li>
                 		<li><a href="javascript:void(0)" v-on:click="setTimeInterval('yestoday')">昨天</a></li>
                 		<li><a href="javascript:void(0)" v-on:click="setTimeInterval('7')">7天</a></li>
                 		<li class="time-selec-hover"><a href="javascript:void(0)" v-on:click="setTimeInterval('30')">30天</a></li>
                    </ul>
                    <div class="modal-body time-selec02" id="data_5" style="margin-top: 5px;">
				        <div class="input-daterange input-group" id="datepicker">
				                  <input  type="text" v-model="search.star" class="form-control" name="start"  style="border: 1px solid #ccc;"/>
				                  <span class="input-group-addon">to</span>
				                  <input  type="text" v-model="search.end" class="form-control" name="end"  style="border: 1px solid #ccc;"/>
				        </div>
				    </div>
				</div>
				<!--/row-->
				<div class="row padding30">
					<div id="promotion-members" class="fl">
						<h4>[[dashboard.total_members]]</h4>
						<b>会员数量</b>
					</div>
					<div id="promotion-amount" class="fl">
						<h4>[[dashboard.total_pay]]</h4>
						<b>定制阅读支付金额</b>
					</div>
				</div>
				<!--/row-->
                <div class="row promotion padding30">
					<div class="col-md-6 fl promotion-tj01">
						<div id="promotion-cont" style="height: 100%"></div>
						<div id="pro-childer-info">
							<span><em class="pro-ys-01"></em><b>总人数：<a href="javascript:void(0)" v-on:click="doGetList('membersList',0)">[[dashboard.total_members]]</a></b></span>
							<span><em class="pro-ys-02"></em><b>已添加孩子：<a href="javascript:void(0)" v-on:click="doGetList('membersList',1)">[[dashboard.total_hc_members]]</a></b></span>
							<span><em class="pro-ys-03"></em><b>未添加孩子：<a href="javascript:void(0)" v-on:click="doGetList('membersList',2)">[[dashboard.total_hnc_members]]</a></b></span>
						</div>
					</div>
					<div class="col-md-6 fl promotion-tj01">
						<div id="promotion-cont02" style="height: 100%"></div>
						<div id="pro-pay-info">
							<span><em class="pro-ys-01"></em><b>定制阅读总订单：<a href="javascript:void(0)" v-on:click="doGetList('ordersList',0)">[[dashboard.total_orders]]</a></b></span>
							<span><em class="pro-ys-02"></em><b>定制阅读已支付订单：<a href="javascript:void(0)" v-on:click="doGetList('ordersList',1)">[[dashboard.total_hp_orders]]</a></b></span>
							<span><em class="pro-ys-03"></em><b>定制阅读未支付订单：<a href="javascript:void(0)" v-on:click="doGetList('ordersList',2)">[[dashboard.total_hnp_orders]]</a></b></span>
						</div>
					</div>
				</div>
				@include("front::default.promotions.members_list")
				@include("front::default.promotions.orders_list")
			</div>
	  </div>
	  <!--/ col-md-10 end-->
    </div>
</div>	
<!-- /扩展内容-->
<script type="text/javascript">
function setMembersChart(){
	var dom = document.getElementById("promotion-cont");
	var myChart = echarts.init(dom, 'westeros');
	var app = {};
	option = null;
	option = {
	    title : {
	       
	    },
	    tooltip : {
	        trigger: 'item',
	        formatter: "{a} <br/>{b} : {c} ({d}%)"
	    },
	    legend: {
	         /*orient: 'vertical',
	        left: 'left',
	        data: ['未添加孩子','已加孩子']*/
	    },
	    series : [
	        {
	            
	            type: 'pie',
	            radius : '75%',
	            center: ['45%', '45%'],
	            data:[
	                {value:arguments[0], name:'已加孩子'},
	                {value:arguments[1], name:'未添加孩子'}
	            ],
	            itemStyle: {
	                emphasis: {
	                    shadowBlur: 2,
	                    shadowOffsetX: 0,
	                    shadowColor: 'rgba(0, 0, 0, 0.5)'
	                }
	            }
	        }
	    ]
	};
	;
	if (option && typeof option === "object") {
	    myChart.setOption(option, true);
	}
}

</script>
<script type="text/javascript">
function setOrdersChart(){
	var dom = document.getElementById("promotion-cont02");
	var myChart = echarts.init(dom, 'westeros');
	var app = {};
	option = null;
	option = {
	    title : {
	       
	    },
	    tooltip : {
	        trigger: 'item',
	        formatter: "{a} <br/>{b} : {c} ({d}%)"
	    },
	    legend: {
	        /*orient: 'vertical',
	        left: 'left',
	        data: ['未支付订单','已支付订单']*/
	    },
	    series : [
	        {
	            
	            type: 'pie',
	           radius : '75%',
	            center: ['45%', '45%'],
	            data:[
	                
	                {value:arguments[0], name:'定制阅读已支付订单'},
	                {value:arguments[1], name:'定制阅读未支付订单'}
	            ],
	            itemStyle: {
	                emphasis: {
	                    shadowBlur: 2,
	                    shadowOffsetX: 0,
	                    shadowColor: 'rgba(0, 0, 0, 0.5)'
	                }
	            }
	        }
	    ]
	};
	;
	if (option && typeof option === "object") {
	    myChart.setOption(option, true);
	}
}
</script>
<script src="{{url('home/pc/js/distpicker.data.js')}}"></script>
<script src="{{url('home/pc/js/distpicker.js')}}"></script>
<script src="{{url('home/pc/js/main.js')}}"></script>	
<script type="text/javascript">
		$('#dob').datepicker({
	        startView: 1,
	        todayBtn: "linked",
	        keyboardNavigation: false,
	        forceParse: false,
	        autoclose: true,
	        language:"cn",
	        format: "yyyy-mm-dd"
	    });
</script>
<script type="text/javascript">
//日期控件
$('#data_5 .input-daterange').datepicker({
				format:"yyyy-mm-dd",
                keyboardNavigation: true,
                forceParse: false,
                autoclose: true,
});
//函数-获取指定日期前后几天的日期
function getDateFromCurrentDate(fromDate,dayInterval){
	var curDate = new Date(Date.parse(fromDate.replace(/-/g,"/")));
	curDate.setDate(curDate.getDate()+dayInterval);
	var year = curDate.getFullYear();
	var month = (curDate.getMonth()+1)<10?"0"+(curDate.getMonth()+1):(curDate.getMonth()+1);
	var day = curDate.getDate()<10?"0"+curDate.getDate():curDate.getDate();
	return year+"-"+month+"-"+day;
}; 
</script>
<script>
//复制剪贴版函数
function copyToClipboard(maintext){
	  if (window.clipboardData){
	    window.clipboardData.setData("Text", maintext);
	    }else if (window.netscape){
	      try{
	        netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
	    }catch(e){
	        alert("该浏览器不支持一键复制！请手工复制文本框链接地址～");
	    }
	    var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
	    if (!clip) return;
	    var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
	    if (!trans) return;
	    trans.addDataFlavor('text/unicode');
	    var str = new Object();
	    var len = new Object();
	    var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
	    var copytext=maintext;
	    str.data=copytext;
	    trans.setTransferData("text/unicode",str,copytext.length*2);
	    var clipid=Components.interfaces.nsIClipboard;
	    if (!clip) return false;
	    clip.setData(trans,null,clipid.kGlobalClipboard);
	  }
	  alert("以下内容已经复制到剪贴板" + maintext);
}
</script>
<script>
	var promotions=new Vue({
		el:"#promotions",
		data:{
			dashboard:{
				ajaxStatus:1,
			},
			membersData:null,
			ordersData:null,
			showList:null,
			search:{
				star:null,
				end:null,
				page:1,
				limit:10,
				status:0
			},
			ajaxListStatus:1
		},
		methods:{
			//加载面板数据
			loadDashboard:function(){
				var _this=this;
				if(_this.dashboard.ajaxStatus){
					_this.dashboard.ajaxStatus=0;
				}else{
					return;
				}
				$.ajax({
					url:"{{url('api/member/promotions/getDashboard')}}",
					dataType:"json",
					success:function(json){
						if(json.status){
							_this.dashboard={
								total_members:json.total_members,
								total_hc_members:json.total_hc_members,
								total_hnc_members:json.total_hnc_members,
								total_pay:json.total_pay,
								total_orders:json.total_orders,
								total_hp_orders:json.total_hp_orders,
								total_hnp_orders:json.total_hnp_orders,
								promote_url:json.promote_url,
								promote_qrcode:json.promote_qrcode,
								ajaxStatus:1
							};
							//设置饼图
							setMembersChart(json.total_hc_members,json.total_hnc_members);
							setOrdersChart(json.total_hp_orders,json.total_hnp_orders);
						}else{
							_this.dashboard.ajaxStatus=1;
						}
					},
					error:function(){
						_this.dashboard.ajaxStatus=2;
					}
				});
			},
			//复制推广链接至剪贴板
			doCopyToClipboard:function(){
				copyToClipboard(this.dashboard.promote_url);
				alert('推广链接已复制至剪贴板！');
			},
			//区间选择
			setTimeInterval:function(type){
				var myDate = new Date();
				this.search.end=myDate.getFullYear()+'-'+(myDate.getMonth()+1)+'-'+myDate.getDate();
				switch(type){
					case 'today':
						this.search.end=this.search.star=getDateFromCurrentDate(this.search.end,0);break;
					case 'yestoday':
						this.search.star=this.search.end=getDateFromCurrentDate(this.search.end,-1);break;
					default:
						if(parseInt(type)>0){
							this.search.end=getDateFromCurrentDate(this.search.end,0);
							this.search.star=getDateFromCurrentDate(this.search.end,-parseInt(type));break;
						}else{
							alert('无此检索条件');
							return;
						}
				}
				this.doChangePage(1);
			},
			//获取列表数据
			doGetList:function(l,s){
				switch(l){
					case 'membersList':
						this.search.page=1;
						this.showList=l;
						this.search.status=s;
						this.doGetMembersList();
					break;
					case 'ordersList':
						this.search.page=1;
						this.showList=l;
						this.search.status=s;
						this.doGetOrdersList();
					break;
				}
			},
			//获取会员列表数据
			doGetMembersList:function(){
				var _this=this;
				if(_this.ajaxListStatus){
					_this.ajaxListStatus=0;
				}else{
					return;
				}
				$.ajax({
					url:"{{url('api/member/promotions/getMembers')}}",
					dataType:"json",
					data:_this.search,
					success:function(json){
						if(json.status){
							_this.membersData=json;
						}
						_this.ajaxListStatus=1;
					},
					error:function(){
						_this.ajaxListStatus=2;
					}
				});
			},
			//获取订单列表数据
			doGetOrdersList:function(){
				var _this=this;
				if(_this.ajaxListStatus){
					_this.ajaxListStatus=0;
				}else{
					return;
				}
				$.ajax({
					url:"{{url('api/member/promotions/getMOrders')}}",
					dataType:"json",
					data:_this.search,
					success:function(json){
						if(json.status){
							_this.ordersData=json;
						}
						_this.ajaxListStatus=1;
					},
					error:function(){
						_this.ajaxListStatus=2;
					}
				});
			},
			//翻页
			doChangePage:function(page){
				switch(this.showList){
					case 'membersList':
						this.search.page=page;
						this.doGetMembersList();
					break;
					case 'ordersList':
						this.search.page=page;
						this.doGetOrdersList();
					break;
				}
			}
		}
	});
	promotions.loadDashboard();
	promotions.setTimeInterval('today');
	$("#data_5").on('change','input',function(){
		promotions.doChangePage(1);
	});
</script>
@endsection
<!-- //继承整体布局 -->

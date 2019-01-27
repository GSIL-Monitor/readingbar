@extends('front::mobile.common.mainSpoint')

@section('content')
<link rel="stylesheet" href="{{url('home/wap/css/spoint.css')}}">

<section id="main">
	<div class="am-g">
		<div class="orderlog">
			  	<div data-am-widget="tabs" class="am-tabs am-orderlog-d2">
			      	<ul class="am-tabs-nav am-cf">
			          	<li class="am-active am-text-center"><a href="[data-tab-panel-0]" v-on:click="getOrdersByStatus('')">所有订单</a></li>
			          	<li class="am-text-center"><a href="[data-tab-panel-1]" v-on:click="getOrdersByStatus(2)">待收货</a></li>
			          	<li class="am-text-center"><a href="[data-tab-panel-2]" v-on:click="getOrdersByStatus(1)">待发货</a></li>
			      	</ul>
			      	<div class="am-tabs-bd">
			      		
						<!--/-->
			          	<div data-tab-panel-0 class="am-tab-panel am-active orderlog-panel" id="log1" v-if="orders!=null">
			          		<ul class="loglsit">
					       		<li v-for="o in orders.data">
					       			<div class="top am-g am-g-fixed">
					       				<span >[[ o.created_at ]]</span>
					       				<span >订单号：[[ o.order_id ]]</span>
					       				<div>
					       					<span class="status-01" v-if="o.status==3">[[ o.status_text ]]</span>
					       					<span class="status-02" v-if="o.status==2">[[ o.status_text ]]</span>
					       					<span class="status-03" v-if="o.status==1">[[ o.status_text ]]</span>
					       				</div>
					       			</div>
					       			<div class="center" v-for="p in o.products">
					       				<div class="am-g am-g-fixed center01">
						       				<div class="am-u-sm-4">
						       					<img :src="p.image">
						       				</div>
						       				<!--/am-u-sm-4-->
	  										<div class="am-u-sm-8">
	  											<h4 style="width:100%;white-space:nowrap;text-overflow:ellipsis;-o-text-overflow:ellipsis;overflow:hidden">[[ p.product_name ]]</h4>
				       							<span style="width:100%;white-space:nowrap;text-overflow:ellipsis;-o-text-overflow:ellipsis;overflow:hidden">[[ p.desc ]]</span>
				       							<p >
				       								<span class="Price fl"><img src="{{url('home/wap/images/sp/sp3_2.png')}}" alt=""/>[[ p.point ]]</span>
				       								<span class="nume fr">[[ p.quantity ]]</span>
				       							</p>
	  										</div>
	  										<!--/am-u-sm-8-->
	  									</div>
					       			</div>
					       			<div class="center">
	  									<div class="am-g am-g-fixed center02">
	  										<a href="javascript:void(0)" v-on:click="deleteOrder(o)">删除订单</a>
	  										<a :href="o.detail_url" class="">订单详情</a>
	  									</div>
	  								</div>
					       			<!--/centam-ger-->
					       		</li>
			      		 	</ul>
			          	</div>
			          	<!--/log1-->
			          	<div data-tab-panel-1 class="am-tab-panel orderlog-panel"  id="log2" v-if="orders!=null">
				            <ul class="loglsit">
						       		<li v-for="o in orders.data">
						       			<div class="top am-g am-g-fixed">
						       				<span >[[ o.created_at ]]</span>
						       				<span >订单号：[[ o.order_id ]]</span>
						       				<div>
						       					<span class="status-01" v-if="o.status==3">[[ o.status_text ]]</span>
						       					<span class="status-02" v-if="o.status==2">[[ o.status_text ]]</span>
						       					<span class="status-03" v-if="o.status==1">[[ o.status_text ]]</span>
						       				</div>
						       			</div>
						       			<div class="center" v-for="p in o.products">
						       				<div class="am-g am-g-fixed center01">
							       				<div class="am-u-sm-4">
							       					<img :src="p.image">
							       				</div>
							       				<!--/am-u-sm-4-->
		  										<div class="am-u-sm-8">
		  											<h4>[[ p.product_name ]]</h4>
					       							<span>[[ p.desc ]]</span>
					       							<p>
					       								<span class="Price fl"><img src="{{url('home/wap/images/sp/sp3_2.png')}}" alt=""/>[[ p.point ]]</span>
					       								<span class="nume fr">[[ p.quantity ]]</span>
					       							</p>
		  										</div>
		  										<!--/am-u-sm-8-->
		  									</div>
						       			</div>
						       			<div class="center">
		  									<div class="am-g am-g-fixed center02">
		  										<a href="javascript:void(0)" v-on:click="deleteOrder(o)">删除订单</a>
		  										<a :href="o.detail_url" class="">订单详情</a>
		  									</div>
		  								</div>
						       			<!--/centam-ger-->
						       		</li>
				      		 	</ul>
				       			
			          	</div>
			          	<!--/-->
			          	<div data-tab-panel-2 class="am-tab-panel orderlog-panel" id="log3" v-if="orders!=null">
			            	<ul class="loglsit">
					       		<li v-for="o in orders.data">
					       			<div class="top am-g am-g-fixed">
					       				<span >[[ o.created_at ]]</span>
					       				<span >订单号：[[ o.order_id ]]</span>
					       				<div>
					       					<span class="status-01" v-if="o.status==3">[[ o.status_text ]]</span>
					       					<span class="status-02" v-if="o.status==2">[[ o.status_text ]]</span>
					       					<span class="status-03" v-if="o.status==1">[[ o.status_text ]]</span>
					       				</div>
					       			</div>
					       			<div class="center" v-for="p in o.products">
					       				<div class="am-g am-g-fixed center01">
						       				<div class="am-u-sm-4">
						       					<img :src="p.image">
						       				</div>
						       				<!--/am-u-sm-4-->
	  										<div class="am-u-sm-8">
	  											<h4>[[ p.product_name ]]</h4>
				       							<span>[[ p.desc ]]</span>
				       							<p>
				       								<span class="Price fl"><img src="{{url('home/wap/images/sp/sp3_2.png')}}" alt=""/>[[ p.point ]]</span>
				       								<span class="nume fr">[[ p.quantity ]]</span>
				       							</p>
	  										</div>
	  										<!--/am-u-sm-8-->
	  									</div>
					       			</div>
  									<div class="center">
	  									<div class="am-g am-g-fixed center02">
	  										<a href="javascript:void(0)" v-on:click="deleteOrder(o)">删除订单</a>
	  										<a :href="o.detail_url" class="">订单详情</a>
	  									</div>
	  								</div>
					       			<!--/centam-ger-->
					       		</li>
			      		 	</ul>
					     	 <!--/-->
			          	</div>
			          	<!--/-->
			          
			      	</div>
			      		<div v-if="loadStatus" class="am-text-center">
							<ul class='loading-local1'>
										<li class="node1"></li>
										<li class="node2"></li>
										<li class="node3"></li>
							</ul>
							数据加载中
						</div>
						<br>
			  	</div>
  		</div>
  		<!--/orderlog-->
    </div>
	<!--/am-g-->

</section>
<script type="text/javascript">
	new Vue({
		el:"#main",
		data:{
			orders:null,
			limit:5,
			page:1,
			order:'id',
			sort:'desc',
			status:'',
			loadStatus:false
		},
		created:function(){
			this.getOrders();
			this.scrollLoad();
		},
		methods:{
			//获取订单数据
			getOrders:function(){
				var _this=this;
				if(_this.loadStatus){
					return;
				}else{
					_this.loadStatus=true;
				}
				$.ajax({
					url:"{{ url('member/spoint/order/getList') }}",
					data:{
						page:_this.page,
						limit:_this.limit,
						order:_this.order,
						sort:_this.sort,
						status:_this.status
					},
					dataType:"json",
					success:function(json){
						if(_this.orders){
							_this.orders.current_page=_this.page;
							for(i in json.data){
								_this.orders.data.push(json.data[i]);
							}
						}else{
							_this.orders=json;
						}
						_this.loadStatus=false;;
					}
				});
			},
			//根据状态获取订单
			getOrdersByStatus:function(status){
				this.orders=null;
				this.status=status;
				this.page=1;
				this.getOrders();
			},
			//翻页
			doChangePage:function(page){
				this.page=page;
				this.getOrders();
			},
			//删除订单
			deleteOrder:function(o){
				var _this=this;
				if(confirm("请确认是否要删除该订单？")){
					$.ajax({
						url:"{{ url('member/spoint/order/delete') }}",
						data:{
							oid:o.id,
						},
						dataType:"json",
						success:function(json){
							if(json.status){
								_this.orders.data.$remove(o);
							}else{
								alert(json.error);
							}
						}
					});
				}
			},
			/*滚动至底部加载数据*/
			scrollLoad:function(){
				var _this=this;
				$(document).scroll(function(){  
					if((document.body.scrollHeight-(document.body.clientHeight+document.body.scrollTop))<10){
						if(!_this.loadStatus && _this.orders.last_page>_this.page){
							_this.page++;
							_this.getOrders();
						}
					}
				});  
			}
		}
	});
</script>
@endsection
<!-- //继承整体布局 -->
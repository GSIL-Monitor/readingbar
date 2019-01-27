
<!-- 继承整体布局 -->
@extends('front::mobile.common.main2l')

@section('content')
<!-- 扩展内容-->
<section id="orders">

    <div class="am-tabs astation-message" data-am-tabs="{noSwipe: 1}" id="doc-tab-demo-1">
		<ul class="am-tabs-nav my-orders-nav am-nav  my-orders-nav2017">
		
		    
		    <li  class="am-active"><a href="javascript: void(0)">已付款</a></li>
		    <li><a href="javascript: void(0)">待付款</a></li>
		    <!--<li><a href="javascript: void(0)">付费须知</a></li>-->
		</ul>
		<!--/-->
        <div class="am-tabs-bd">

		    <div class="am-tab-panel am-active  padding0">
		     	<ul>
		     	    <!--start-->
		           
		        	<li class="margintop10 orders-list" v-for="o in orders1.data" v-if="o.status==1">
		        	    <div class="am-g"><span>订单编号：[[o.order_id]]</span></div><!--/am-g-->
				        <div class="am-g margintop5"><span>支付时间:[[o.created_at]]</span></div><!--/am-g-->
				        <div class="am-g margintop5"><span>产品名称:[[o.product_name]]</span></div><!--/am-g-->
				        <div class="am-g margintop5">
		                    <div class="am-u-sm-4 fl orders-list-bottom">
		                        <span>使用人:</span>
		                        <span>[[o.student_name]]</span>
		                    </div>
		                    <div class="am-u-sm-4 fl orders-list-bottom">
		                        <span>价格:</span>
		                        <span>[[o.price]]</span>
		                        </div>
		                    <div class="am-u-sm-4 fr orders-list-bottom">
		                    	<span>押金:</span>
		                    	<span>[[o.deposit]]</span>
		                    </div>
				        </div>
				        <!--/am-g-->
				        <div class="am-g marginbottom5"><span class=" fr">总计：<b class="ds-bjd">[[o.total]]</b></span></div> <!--/am-g-->
				        <div v-if="o.deposit && (o.product_id == 14 || o.product_id== 15)">
				        	<button type="button" class="am-btn ds-ij2 am-btn-secondary"  v-on:click="applyRefundDeposit($event,o)" style="border: solid 1px #4bd2bf;width:100%;"  v-if="!o.applyRefundDeposit">申请退押金</button>
				        	<template v-else>
			        			<button type="button" class="am-btn ds-ij2 am-btn-secondary"  style="border: solid 1px grey;width:100%;background: grey"  v-if="o.applyRefundDeposit.status == 1">押金已退还</button>
			        			<button type="button" class="am-btn ds-ij2 am-btn-secondary"  style="border: solid 1px grey;width:100%;background: grey"  v-else>退押金已申请</button>
						 	</template>
				        </div>
				     <div class="box-10"></div>
				    </li>
		        	<!--/-->
		        
		        </ul>
		        <!--page-->
			    <ul data-am-widget="pagination" class="am-pagination am-pagination-select" v-if="orders1.last_page>1">
                    <li class="am-pagination-prev" v-if="orders1.current_page>1"><a href="javascript:void(0)" v-on:click="doChangePage(orders1.current_page-1,1)" class="">上一页</a></li>
			        <li class="am-pagination-select" >
			          <select v-model="orders1.current_page" v-on:change="doChangePage($event.taget.value,1)">
			              <option v-for="p in orders1.last_page" value="[[p+1]]" class="">[[p+1]]
			                / [[orders0.last_page]]
			              </option>
			          </select>
		  	        </li>
      		       <li class="am-pagination-next " v-if="orders1.current_page < orders1.last_page"><a href="javascript:void(0)" v-on:click="doChangePage(orders1.current_page+1,1)" class="">下一页</a></li>
                </ul>
                <!--page end-->
		    </div>
		    <!--/am-tab-panel-->
		    <div class="am-tab-panel  padding0">
		        <ul>
		            
		            <li><span class="ds-bjd" >注:如果优惠的订单未付款，点击取消订单，将退回优惠券。</span></li>
		        	<li class="margintop10 orders-list" v-for="o in orders0.data" v-if="o.status==0">
		        	    <div class="am-g"><span>订单编号：[[o.order_id]]</span></div><!--/am-g-->
		        	    <div class="am-g margintop5" style="color: #f00" v-if="o.discount_price"><span>优惠券金额：[[o.discount_price]]</span></div><!--/am-g-->
				        <div class="am-g margintop5"><span>提交时间：[[o.created_at]]</span></div><!--/am-g-->
				        <div class="am-g margintop5"><span>产品名称：[[o.product_name]]</span></div><!--/am-g-->
				        <div class="am-g margintop5">
		                    <div class="am-u-sm-4 fl orders-list-bottom">
		                        <span>使用人:</span>
		                        <span>[[o.student_name]]</span>
		                    </div>
		                    <div class="am-u-sm-4 fl orders-list-bottom">
		                        <span>价格:</span>
		                        <span>[[o.price]]</span>
		                        </div>
		                    <div class="am-u-sm-4 fr orders-list-bottom">
		                    	<span>押金:</span>
		                    	<span>[[o.deposit]]</span>
		                    </div>
				        </div>
				        <!--/am-g-->
				        <div class="am-g marginbottom5"><span class=" fr">总计：<b class="ds-bjd">[[ parseFloat(o.price)+parseFloat(o.deposit) ]]</b></span></div> <!--/am-g-->
				        <div class="am-g margintop5"><!--/v-on:click="doPayOrder(o.order_id)"-->
				        	<a href="javascript:void(0)" v-on:click="doDeleteOrder(o.order_id)" class="fl  am-btn ds-ij3">取消支付</a>
							  <button type="button" class="am-btn ds-ij2 am-btn-secondary fr" data-am-modal="{target: '#my-actions'}" v-on:click="setPayOrder(o)" style="border: solid 1px #4bd2bf;">确认支付</button>
				        </div>
				         <div class="box-10"></div>
		        	</li>
		        </ul>
		        <!--page-->
			    <ul data-am-widget="pagination" class="am-pagination am-pagination-select" v-if="orders0.last_page>1">
                    <li class="am-pagination-prev" v-if="orders0.current_page>1"><a href="javascript:void(0)" v-on:click="doChangePage(orders0.current_page-1,0)" class="">上一页</a></li>
			        <li class="am-pagination-select" >
			          <select v-model="orders0.current_page" v-on:change="doChangePage($event.taget.value,0)">
			              <option v-for="p in orders0.last_page" value="[[p+1]]" class="">[[p+1]]
			                / [[orders0.last_page]]
			              </option>
			          </select>
		  	        </li>
      		       <li class="am-pagination-next " v-if="orders0.current_page < orders0.last_page"><a href="javascript:void(0)" v-on:click="doChangePage(orders0.current_page+1,0)" class="">下一页</a></li>
                </ul>
                <!--page end-->
		    </div>
		    <!--/am-tab-panel-->
		    <div class="am-tab-panel margintop10 bgfff">
		     <article data-am-widget="paragraph" class="am-paragraph am-paragraph-default" data-am-paragraph="{ tableScrollable: true, pureview: true }">
		           <h4 style="text-align: center; margin-top: 10px;">蕊丁吧付费会员服务内容及使用须知</h4>
				
				    <p>一、 蕊丁吧会员说明</p>
	<p>1. 本服务内容及使用须知适用于蕊丁吧所有付费会员。</p>
	
		
	<p>二、 押金、损耗和赔偿（针对定制阅读会员）</p>
	<p>1 会员在购买定制阅读服务时，同时需要缴纳图书借阅押金。</p>
	<p>2
		蕊丁吧每本书都是精心挑选，从国外引进的，我们希望各位会员能与蕊丁吧一起爱护每一本图书。如学员对图书造成的损耗，需要支付相应的赔偿。具体规定如下：
	</p>
	<p>2.1 图书如在借阅过程中有轻微损毁，请家长在还书时主动告知，由我们进行修补。</p>
	<p>2.2
		若有出现圈点、涂画、撕毁、烧残、水浸、划线、注字、涂抹、卷曲、折皱等但不影响其内容完整，能继续使用的，按污损页数计罚，每页需按照（定价/页码）*2的标准赔偿金。赔偿金额超过书籍定价的，将按书籍定价的1.5倍进行赔偿，已破损的书籍归用户所有。赔偿费用需单独支付（不接受用户自行购买进行赔偿）。
	</p>
	<p>2.3
		出现开胶、撕页或大面积涂写等严重影响书籍正常阅读的，应按书籍定价的1.5倍进行赔偿，已破损的书籍归用户所有。赔偿费用需单独支付（不接受用户自行购买进行赔偿）。
	</p>
	<p>3 书籍定价</p>
	<p>3.1 书籍的价值以每本书的RMB标价为准。RMB标价按照以下方式计算：</p>
	<p>3.1.1 对图书上标有美元定价的， RMB标价按照以书籍上美元定价乘以6.7的汇率标准进行计算（四舍五入去除分角）。</p>
	<p>3.1.2
		对图书上未标出美元定价的，RMB标价按照相同ISBN书籍的亚马逊网站的美元定价乘以6.7的汇率标准进行计算（四舍五入去除分角）。</p>
	
	<p>三、 账号使用说明</p>
	<p>1. 会员付费后，系统会额外提供一个测试平台账号。</p>
	<p>2. 测试平台账号的使用人必须与学员信息一致，不允许与他人共用、外借或转让。</p>
	<p>3.
		蕊丁吧会定期对学员测试信息进行审核，如发现异常信息，将进行处理。首次发现异常信息，将与会员联系提出警告。如果出现第二次异常信息，将视为学员的严重违约行为，蕊丁吧将采取直接封号的处理，并不进行退费。
	</p>
	<p>4. 会员在服务期满后应当续费；如果会员停止续费，相应的会员服务将自动终止。重新续费后恢复服务。
		定制阅读会员（只限于定制阅读年会员）在服务有效期内，可申请最多1次，每次最长1个月的账号暂时冻结服务，冻结期间，所有服务暂停。解冻后，服务有效期顺延。没有申请则视为正常服务，时间不延续。
	</p>
	
	<p>四、 退费说明</p>
	<p>1 定制阅读会员</p>
	<p>1.1
		定制阅读会员（仅限于定制阅读年会员）在付费后30日内可申请终止服务并申请退费；蕊丁吧在扣除10%全年服务费用后，将其余费用予以退回；超过30日，会员费用不予退回。押金在用户归还全部书籍（无破损或丢失）后于15个工作日内退还。
	</p>
	<p>1.2
		会员服务到期，应提前或及时续费。如果到期后5日内未续费，也未还书的，将按照每天每本5元收取滞纳金，滞纳金从押金中扣除（滞纳金从逾期第1天开始计算）。
	</p>
	<p>1.3 押金退还说明：会员服务期满后，如不再续费，押金将退还到原支付账户，如有变化，会员应于期满前提前说明。</p>
	<p>2 自主阅读会员</p>
	<p>2.1 会员在付费后不得申请退费。</p>
	
	<p>五、 美国系统账号使用说明</p>
	<p>1. 针对付费会员，蕊丁吧将分配一个美国系统账号。</p>
	<p>2. 会员使用美国系统账号时，除遵守本使用须知及《蕊丁吧用户协议》外，还应当遵守美国系统账号管理网站的相关规定。</p>
	<p>3. 蕊丁吧有权终止会员使用美国系统账号，但应提前30日通知会员。</p>
	<p>4. 蕊丁吧通知会员停止使用美国系统账号后，可以通过其他替代方案向会员提供服务。</p>
		           </article>
		    </div>
		    <!--/am-tab-panel-->
  		</div>
    </div>
    <!--/-->
   <div class="am-modal-actions" id="my-actions">
	  <div class="am-modal-actions-group">
	    <ul class="am-list">
	      <li class="am-modal-actions-header">选择支付方式:</li>
	       <li>
	          <a href="#">
		          <input type="radio" v-model="pay.pay_type" name="pay_type" value="wxpay" checked>
		         
		          <b>微信支付</b>
	         </a>
	        </li>
	      <li>
	        <a href="#">
	            <input type="radio" v-model="pay.pay_type" name="pay_type" value="alipay">
		       
		        <b>支付宝支付</b>
	        </a>
	      </li>
	    </ul>
	  </div>
	  <div class="am-modal-actions-group">
	    <button class="am-btn am-btn-secondary am-btn-block"  v-on:click="doPayOrder()">立即支付</button>
	    <button class="am-btn am-btn-secondary2 am-btn-block" data-am-modal-close>取消支付</button>
	  </div>
	 <!--支付表单-->
		<form id="payForm" style="display:none" method="post" :action="ajaxUrls.payOrdersUrl">
			<input value="{{ csrf_token() }}" name="_token">
			<input :value="pay.order_id" name="order_id">
			<input :value="pay.pay_type" name="pay_type">
	    </form>
	<!--/支付表单-->
</div>


</section>
<script type="text/javascript">
var orders=new Vue({
	el:"#orders",
	data:{
		ajaxUrls:{
			//获取订单
			getOrdersUrl:"{{url('api/member/order/all')}}",
			//支付未付款订单
			payOrdersUrl:"{{url('api/member/order/pay')}}",
			//删除未付款订单
			deleteOrdersUrl:"{{url('api/member/order/delete')}}",
		},
		//未付款订单
		orders0:null,
		search0:{
			page:1,
			limit:5,
			status:0
		},
		//已付款订单
		orders1:null,
		search1:{
			page:1,
			limit:5,
			status:1
		},
		//支付
		pay:{
			order_id:null,
			pay_type:'alipay'
		}
	},
	methods:{
		//获取未付款订单
		doGetOrders0:function(){
			var _this=this;
			$.ajax({
				url:_this.ajaxUrls.getOrdersUrl,
				dataType:"json",
				data:_this.search0,
				success:function(json){
					_this.orders0=json;
				}
			});
		},
		//获取已付款订单
		doGetOrders1:function(){
			var _this=this;
			$.ajax({
				url:_this.ajaxUrls.getOrdersUrl,
				dataType:"json",
				data:_this.search1,
				success:function(json){
					_this.orders1=json;
				}
			});
		},
		//设置要支付的订单
		setPayOrder:function(o){
			this.pay.order_id=o.order_id;
		},
		//支付未付款订单
		doPayOrder:function(){
			$("#payForm").submit();
		},
		//删除未付款订单
		doDeleteOrder:function(oid){
			if(!confirm('是否确认删除订单'+oid)){
				return;
			}
			var _this=this;
			$.ajax({
				url:_this.ajaxUrls.deleteOrdersUrl,
				dataType:"json",
				type:"POST",
				data:{order_id:oid},
				success:function(json){
					if(json.status){
						alert(json.success);
						_this.doGetOrders0();
					}else{
						alert(json.error);
					}
				}
			});
		},
		//订单翻页
		doChangePage:function(page,status){
			switch(status){
				case 0:
					this.search0.page=page;
					this.doGetOrders0();
					break
				case 1:
					this.search1.page=page;
					this.doGetOrders1();
					break
			}
		},
		// 退押金申请
		applyRefundDeposit:function (e,o) {
			amazeConfirm({
				msg: '是否申请退押金？如若不退款，则下次购买产品无需支付押金！',
				confirm: '确认',
				onConfirm: function (){
					$.ajax({
						url: "{{ url('member/accountCenter/orders/applyRefund') }}",
						dataType:"json",
						type:"POST",
						data:{id:o.id},
						breforeSEend: function () {
							$(e.target).html('<i class="fa fa-spin fa-refresh"></i>');
						},
						success:function(json){
							amazeAlert({
								msg: json.message
							});
						},
						error: function (e){
							amazeAlert({
								msg: e.responseJSON.message
							});
						},
						complete: function () {
							$(e.target).html('申请退押金');
						}
					});
				}
			});
		}
	}
});
orders.doGetOrders0();
orders.doGetOrders1();
</script>
<script>
//接收消息提示
@if(session('buy_success'))
	switch ({{ session('product_id') }}) {
		case 16: 
			amazeConfirm({
				title: '支付成功',
				msg: "您一定是特别重视孩子英文阅读的家长！相信您对我们的《书籍测试服务》也会感兴趣，现在购买直减99元哦~~",
				confirm: '我要去看看',
				onConfirm: function () {
					window.location.href = "{{ url('product/list') }}"
				},
				cancel: '算了，下次吧'
			});
			break;
		case 17: 
			appConfirm({
				title: '支付成功',
				msg: "您一定是特别重视孩子英文阅读的家长！难道您不想通过《STAR阅读能力测评》了解孩子的英文阅读能力水平吗？现在购买直减99元哦~~",
				confirm: '想了解',
				onConfirm: function () {
					window.location.href = "{{ url('product/list') }}"
				},
				cancel: '算了，下次吧'
			});
			break;
		case 18: 
			appConfirm({
				title: '支付成功',
				msg: "您一定是特别重视孩子英文阅读的家长！我们还为您提供美国进口AR原版书籍借阅服务，快去商城兑换《借阅优惠券》吧~~",
				confirm: '去商城',
				onConfirm: function () {
					window.location.href = "{{ url('member/spoint/product') }}"
				},
				cancel: '算了，下次吧'
			});
			break;
	}
@endif
</script>
<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

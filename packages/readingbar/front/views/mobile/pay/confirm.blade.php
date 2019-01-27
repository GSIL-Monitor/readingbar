<!-- 继承整体布局 -->
@extends('front::mobile.common.main2l')

@section('content')
<!-- 扩展内容-->
<section>
       <div class="am-tab-panel am-active  padding0">
		        <ul>
		            <div class="box-10"></div>
		        	<li class="margintop10 orders-list">
		        	   <div class="am-g margintop5"><span>产品名称:{{$product['product_name']}}</span></div><!--/am-g-->
				       <div class="am-g margintop5">
		                    <div class="am-u-sm-3 fl orders-list-bottom">
		                        <span>孩子:</span>
		                        <span>{{$student['name']}}</span>
		                    </div>
		                    <div class="am-u-sm-2 fl orders-list-bottom">
		                        <span>费用:</span>
		                        <span>{{$product['price']}}</span>
		                        </div>
		                     <div class="am-u-sm-3 fl orders-list-bottom">
		                        <span>续费优惠:</span>
		                        <span>{{$product['renew_discount_price']}}</span>
		                        </div>
		                    <div class="am-u-sm-2 fr orders-list-bottom">
		                    	<span>押金:</span>
		                    	<span>{{$product['deposit']}}</span>
		                    </div>
		                    <div class="am-u-sm-2 fr orders-list-bottom">
		                    	<span>有效期:</span>
		                    	<span>{{$product['days']}}天</span>
		                    </div>
				        </div>
				        <!--/am-g -->
				        <div class="am-g marginbottom5">
				        	<span class=" fr">实付：<b class="ds-bjd">[[ total ]]</b></span>
				        	<span class=" fr">总计：<b class="ds-bjd">{{$product['price']+$product['deposit']}}</b></span>
				        </div> <!--/am-g-->
				        <div class="row padding-30 Settlement col-md-12">
							<div class="col-md-12">
								优惠券(<font color="#ff6421">注：不可抵扣押金</font>):
								<span v-if="discounts===null">加载优惠券信息...</span>
								<span v-if="discounts.length===0">无</span>
							</div>
							<div  class="col-md-3" v-for="d in discounts" style="color:#4bd2bf;">
									<input type="checkbox" v-on:change="newPayPrice()" v-model="orderForm.discounts" :value="d.id">￥[[ d.price ]]([[ d.name ]])
							</div>
						</div>
				        <div class="am-g margintop5">
				            <a href="javascript:history.back()" class="fl  am-btn ds-ij3">取消支付</a>
					        <button type="button" class="am-btn ds-ij2 am-btn-secondary fr" data-am-modal="{target: '#my-actions'}" style="border: solid 1px #4bd2bf;">确认支付</button>
					     </div>
				        <form id="payForm" style="display:none" method="post" action="{{ $action }}">
					          <input value="{{ csrf_token() }}" name="_token">
					          <input :value="orderForm.product_id" name="product_id">
					          <input :value="orderForm.service_id" name="service_id">
					          <input :value="orderForm.student_id" name="student_id">
					          <input type="checkbox" v-for="d in orderForm.discounts" :value="orderForm.discounts[$index]" checked name="discounts[]">
					          <input :value="orderForm.pay_type" name="pay_type">
					    </form>
		        	</li>
		        
		        </ul>
                <!--page end-->
		    </div>

<div class="am-modal-actions" id="my-actions">
	<form class="am-form" action="">
	  <div class="am-modal-actions-group">
	    <ul class="am-list">
	      <li class="am-modal-actions-header">选择支付方式:</li>
	      <li style="word-wrap:break-word;word-break: normal;white-space: normal;text-align:left;padding:10px;color:#4bd2bf">
	      		*蕊丁吧会员服务从购买之日起生效，测试系统服务和借阅服务不可退不可冻结。
	      </li>
	       <li>
	          <a href="#">
		          <input type="radio" name="doc-radio-1" v-model='orderForm.pay_type' value="wxpay" checked>
		         
		          <b>微信支付</b>
	         </a>
	        </li>
	      <li>
	        <a href="#">
	            <input type="radio" name="doc-radio-1" v-model='orderForm.pay_type' value="alipay">
		       
		        <b>支付宝支付</b>
	        </a>
	      </li>
	    </ul>
	  </div>
	  <div class="am-modal-actions-group">
	    <button class="am-btn am-btn-secondary am-btn-block" data-am-modal-close v-on:click="payOrder()">立即支付</button>
	    <button class="am-btn am-btn-secondary2 am-btn-block" data-am-modal-close>取消支付</button>
	  </div>
	 </form> 
</div>
</section>
<script type="text/javascript">
var pts=new Vue({
	el:"body",
	data:{
		orderForm:{
			product_id:"{{$product['id']}}",
			student_id:"{{$student['id']}}",
			service_id:"{{ $service_id or '' }}",
			discounts:[],
			pay_type:'alipay'
		},
		total:0,
		discounts:null
	},
	created:function(){
		this.newPayPrice();
		this.doGetDiscounts();
		
	},
	methods:{
		//显示支付选择弹出层
		showPTS:function(){
			$("#payModal").modal({backdrop: 'static', keyboard: false});
		},
		//确认支付
		payOrder:function(){
			var _this=this;
			switch(_this.orderForm.pay_type){
				case 'alipay':$('#payForm').submit();break;
				case 'wxpay':$('#payForm').submit();
				break;
			}
		},
		//获取用户折扣券
		doGetDiscounts:function(){
			var _this=this;
			$.ajax({
				url:"{{url('api/member/discount/getDiscounts')}}",
				dataType:"json",
				data:{product_id:_this.orderForm.product_id},
				success:function(json){
					_this.discounts=json;
				},
				errors:function(){
					_this.doGetDiscounts();
				}
		 	});
		},
		//统计实付价格
		newPayPrice:function(){
			var price={{ $product['price'] }};
			var deposit={{ $product['deposit'] }};
			var discounts =this.orderForm.discounts;
			var renewDiscountPrice = {{ $product['renew_discount_price'] }};
			var discountPrice=0;
			for(i in discounts){
				for(j in this.discounts){
					if(discounts[i]==this.discounts[j].id){
						discountPrice+=this.discounts[j].price;
					}
				}
			}
			price=price-discountPrice>0?price-discountPrice:0;
			price=price-renewDiscountPrice>0?price-renewDiscountPrice:0;
			this.total=price+deposit;
		}
	}
});
</script>
<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

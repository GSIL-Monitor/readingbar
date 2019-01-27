<!-- 继承整体布局 -->
@extends('front::mobile.common.main') @section('content')
<!-- 扩展内容-->
<section id="product8">
	<div class="content">
		<div><a href="javascript:void(0)" v-on:click="buy()">购买</a></div>
	    <img alt="" src="{{ url('home/wap/images/products/20/paper.png') }}">
	</div>
	<!-- 孩子选择 -->
	  	<div class="am-modal am-modal-confirm modal-buy" tabindex="-1" id="modal-SC">
		  <div class="am-modal-dialog" style="width: 96%;">
		    <div class="am-modal-hd">请选择孩子</div>
		    <div class="am-modal-bd">
		    	<template  v-for="s in students" >
			       <div class="child active" v-on:click="selectStudent(s)" v-if="s.id==this.student_id">
			          <div>
			          	<img alt="" :src="s.avatar" class="avatar">
			          </div>
			          <div>
			          	<div class="sc-nickname">[[ s.nick_name ]]</div>
			          	<div class="point">
			          		<img src="{{ url('home/pc/images/ioc-rdm.png') }}">
			          		[[ s.point ]]
			          	</div>
			          </div>
			       </div>
			       <div class="child "  v-on:click="selectStudent(s)" v-else>
			          <div>
			          	<img alt="" :src="s.avatar" class="avatar">
			          </div>
			          <div>
			          	<div class="sc-nickname">[[ s.nick_name ]]</div>
			          	<div class="point">
			          		<img src="{{ url('home/pc/images/ioc-rdm.png') }}">
			          		[[ s.point ]]
			          	</div>
			          </div>
			       </div>
		       </template>
		    </div>
		    <div class="am-modal-footer">
		      <span class="am-modal-btn" data-am-modal-cancel>取消</span>
		      <span class="am-modal-btn" data-am-modal-confirm>确定</span>
		    </div>
		  </div>
		</div>
	  <!-- 孩子选择 -->
	  <div class="am-modal am-modal-no-btn" tabindex="-1" id="modal-pro">
	<div class="am-modal-dialog">
		<div class="am-modal-hd">
			蕊丁吧付费会员服务内容及使用须知 <a href="javascript: void(0)"
				class="am-close am-close-spin" data-am-modal-close>&times;</a>
		</div>
		<div class="am-modal-bd">
			<div class="" style="overflow-y: scroll; height: 60%">

				<div class="product-txt">
	 <strong>借阅及还书规定</strong><br>
					1.借阅时间：从官网付费购买之日算起40日内；<br>
					2.还书日期：以蕊丁吧收到书籍时间为准；逾期还书将按照每天每本5元收取滞纳金，滞纳金从押金中扣除（滞纳金从逾期第1天开始计算）；<br>
					3.借阅押金：服务期满后，押金将于五个工作日内退还到原支付账户。<br>
					4.如遇特殊情况不能如期还书，请事先沟通，书籍如出现严重破损请做相应赔偿，赔偿原则请参考以下内容<br>
					<br>
					<strong>押金、损耗和赔偿</strong><br>
					1.会员在购买此项服务时，同时需要缴纳图书借阅押金。<br>
					2.蕊丁吧每本书都是精心挑选，从国外引进的，我们希望各位会员能与蕊丁吧一起爱护每一本图书。如学员对图书造成的损耗，需要支付相应的赔偿。具体规定如下：<br>
					2.1 图书如在借阅过程中有轻微损毁，请家长在还书时主动告知，由我们进行修补。<br>
					2.2 若有出现圈点、涂画、撕毁、烧残、水浸、划线、注字、涂抹、卷曲、折皱等但不影响其内容完整，能继续使用的，按污损页数计罚，每页需按照（定价/页码）*2的标准赔偿金。赔偿金额超过书籍定价的，将按书籍定价的1.5倍进行赔偿，已破损的书籍归用户所有。赔偿费用需单独支付（不接受用户自行购买进行赔偿）。<br>
					2.3 出现开胶、撕页或大面积涂写等严重影响书籍正常阅读的，应按书籍定价的1.5倍进行赔偿，已破损的书籍归用户所有。赔偿费用需单独支付（不接受用户自行购买进行赔偿）。<br>
					3 书籍定价<br>
					3.1 书籍的价值以每本书的RMB标价为准。RMB标价按照以下方式计算：<br>
					3.1.1 对图书上标有美元定价的， RMB标价按照以书籍上美元定价乘以6.7的汇率标准进行计算（四舍五入去除分角）。<br>
					3.1.2 对图书上未标出美元定价的，RMB标价按照相同ISBN书籍的亚马逊网站的美元定价乘以6.7的汇率标准进行计算（四舍五入去除分角）。<br>
					<br>
					<strong>书籍寄回说明</strong><br>
					为方便您能够顺利按时将图书寄回，我们已将顺丰快递单放入盒子中，还书时您只需在签名处签字，并把盒子以及二维码快递单给上门取件的顺丰快递员即可。<br>
					1.寄件方式 ：顺丰到付。<br>
					2.下单方式：可选择以下三种方式之一。<br>
					电话：拨打“95338”预约上门取件。<br>
					网站：登录 http://www.sf-express.com预约上门取件。<br>
					微信：关注【顺丰速运】公众号，点击“寄快递”中的“收派员上门”。<br>
					3.注意事项<br>
					运单产品类型，北京、天津用户请选择【顺丰标快】；其他地区用户请选择【顺丰特惠】。<br>
					备注：因没有按照说明选择/填写运单信息，导致运费增加的部分，将从押金扣除。<br>

					<a href="javascript:void(0)" data-am-modal-confirm class="product-txt-link">同意并支付</a> 
					<a href="javascript:void(0)" data-am-modal-close class="product-txt-link2 ">不同意</a>
				</div>

				<!--/modal-footer-->
			</div>
			<!--/-->
		</div>
	</div>
</div>
</section>
<script type="text/javascript">
new Vue({
	 el:"#product8",
	 data: {
		product_id: 20,
		student_id: 0,
		auth: {!! auth('member')->check()?'true':'false' !!},
		newMember: {{ auth('member')->hasBoughtAnyProduct()?'true':'false' }},
		students: {!! $students->toJson() !!},
		products: {!! $products->toJson() !!}
	},
	methods: {
		buy: function () {
			amazeAlert({
				title: '提示',
				msg: '此商品已售罄~'
			});
			return ;
			if (!this.auth) {
				amazeAlert({
					title: '提示',
					msg: '您尚未登录！',
					onConfirm: function () {
						window.location.href="{{ url('login?intended='.request()->path()) }}"
					}
				});
			}else if (this.students.length === 0) {
				amazeAlert({
					title: '提示',
					msg: '您名下没有孩子,请去添加孩子!',
					confirm: '添加孩子',
					onConfirm: function () {
						window.location.href="{{ url('/member/children/create') }}"
					}
				});
				return false;
			}else {
		    	this.student_id = 0;
		    	this.showModalSC();
			}
		},
		showModalPro: function () {
			var _this= this;
			$('#modal-pro').modal({
				closeViaDimmer:false,
		        onConfirm: function(options) {
		        	url="{{url('member/pay/confirm')}}";
					window.location.href=url+"?product_id="+_this.product_id+"&protocol=true&student_id="+_this.student_id;
		        }
		   });
		},
		showModalSC: function () {
			var _this= this;
			$('#modal-SC').modal({
				closeViaDimmer:false,
		        onConfirm: function(options) {
		        	if(_this.student_id) {
						_this.showModalPro();
			        }else {
			        	amazeAlert({
                            msg: '请选择孩子',
                            onConfirm: function () {
                         	   _this.showModalSC()
                            }
						});
				    }
		        }
		   });
		},
		selectStudent: function (s) {
			this.student_id = s.id;
		}
	}
})
</script>
<style>
#product8{
	background:#d1e6fa;
	width:100%;
	height:100%;
	padding-top:20px;
}
#product8 .content{
	position:relative;
}
#product8 .content img{
	width:100%;
}
#product8 .content div{
	width:100%;
	height:100%;
	padding-top:15px;
	position:absolute;
	text-align:center;
	padding-top: 97%;
}
#product8 .content  a{
	color: #fff;
    background: #ff7800;
    padding: 5px 40px;
    font-weight: bold;
    font-size: 14px;
    border-radius: 5px;
}
#product8 .content  a:hover{
	color:#fff;
	box-shadow: 0px 0px 2px 2px #dd6a03;
}
</style>
<!-- /扩展内容-->
@endsection
<!-- //继承整体布局 -->

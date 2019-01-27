<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')
<!-- 扩展内容-->
<div  id="product8">  
<section>
	<div><a href="javascript:void(0)" v-on:click="buy()">购买</a></div>
	<img alt="" src="{{ url('home/pc/images/products/20/paper.png') }}">
	
</section>
<div class="modal fade" id="protocolModal" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel" aria-hidden="true">

	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<div class="" style="overflow-y: scroll; height: 60%">
					<h1 class="product-h1 textcenter">蕊丁吧付费会员服务内容及使用须知</h1>
					<div class="product product-txt ">
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

						<a href="javascript:void(0)" v-on:click="setProtocol()"
							class="product-txt-link">同意并支付</a> <a href="javascript:void(0)"
							data-dismiss="modal" class="product-txt-link">不同意</a>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal -->
</div>
<!-- 孩子选择-模态框（Modal） -->
<div class="modal fade" id="selectChildModal" tabindex="-1" 
	role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<span>选择孩子购买产品</span>
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<div class="row">
						<div class="col-xm-12">
								<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
				  <!-- Indicators -->
				  <!-- Wrapper for slides -->
					  <div class="carousel-inner" role="listbox">
					  <template v-for="i in Math.ceil(students.length/3)">
					  	<div class="item active"  v-if="i===0">
					  	  <template v-for="s in students"  v-if="$index>=3*i && $index<3*(i+1)">
						      <div class="child active" v-if="s.id===student_id" v-on:click="selectStudent(s)">
						      	<img :src="s.avatar" class="avatar">
						      	<div  class="nickname">[[ s.nick_name ]]</div>
						      	<div  class="point"><img src="{{ url('home/pc/images/ioc-rdm.png') }}">[[ s.point ]]</div>
						      </div>
						       <div class="child" v-else  v-on:click="selectStudent(s)">
						      	<img :src="s.avatar" class="avatar">
						      	<div  class="nickname">[[ s.nick_name ]]</div>
						      	<div  class="point"><img src="{{ url('home/pc/images/ioc-rdm.png') }}">[[ s.point ]]</div>
						      </div>
					      </template>
					    </div>
					    <div class="item" v-else>
					        <template v-for="s in students"   v-if="$index>=3*i && $index<3*(i+1)">
						      <div class="child active" v-if="s.id===student_id"  v-on:click="selectStudent(s)">
						      	<img :src="s.avatar" class="avatar">
						      	<div  class="nickname">[[ s.nick_name ]]</div>
						      	<div  class="point"><img src="{{ url('home/pc/images/ioc-rdm.png') }}">[[ s.point ]]</div>
						      </div>
						       <div class="child" v-else  v-on:click="selectStudent(s)">
						      	<img :src="s.avatar" class="avatar">
						      	<div  class="nickname">[[ s.nick_name ]]</div>
						      	<div  class="point"><img src="{{ url('home/pc/images/ioc-rdm.png') }}">[[ s.point ]]</div>
						      </div>
					      </template>
					  </div>
					  </template>
					  <!-- Controls -->
					  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
					    <img class="glyphicon" alt="" src="{{ url('home/pc/images/btn-left.png') }}"">
					  </a>
					  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
					    <img class="glyphicon" alt="" src="{{ url('home/pc/images/btn-right.png') }}"">
					  </a>
					</div>
				</div>
			
						</div>
				</div>
				</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" v-on:click="goPay()">确认</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal -->
</div>
<script type="text/javascript">
new Vue({
	 el:"#product8",
	 data: {
		product_id: 20,
		student_id: 0,
		auth: {!! auth('member')->check()?'true':'false' !!},
		newMember: {!! auth('member')->hasBoughtAnyProduct()?'true':'false' !!},
		students: {!! $students->toJson() !!},
		products: {!! $products->toJson() !!}
	},
	methods: {
		buy: function () {
			appAlert({
				title: '提示',
				msg: '此商品已售罄~'
			});
			return;
			if (!this.auth) {
				appAlert({
					title: '提示',
					msg: '您尚未登录！',
					ok: {
						text: '登录',
						callback: function () {
							window.location.href="{{ url('login?intended='.request()->path()) }}"
						}
					}
				});
			}else if (this.students.length=== 0) {
				appAlert({
					title: '提示',
					msg: '您名下没有孩子,请去添加孩子!',
					ok: {
						text: '添加孩子',
						callback: function () {
							window.location.href="{{ url('/member/children/create') }}"
						}
					}
				});
				return false;
			}else {
		    	this.student_id = 0;
			    $("#selectChildModal").modal('show');
			}
		},
		selectStudent: function (s) {
			this.student_id = s.id;
		},
		setProtocol: function () {
	    	window.location.href="{{url('member/pay/confirm')}}"+"?product_id="+this.product_id+"&protocol=true&student_id="+this.student_id;
		},
		goPay: function () {
			$("#selectChildModal").modal('hide');
			if (!this.student_id) {
				appAlert({
					title: '提示',
					msg: '请选择孩子！',
					ok: {
						callback: function () {
							 $("#selectChildModal").modal('show');
						}
					}
				});
			} else {
				$("#protocolModal").modal('show');
			}
		}
	}
})
</script>

<style>
section{
	background: #d1e6fa;
	margin-top:0px;
	text-align:center;
	padding:40px 0px 100px 0px;
	min-width:1174px;
}
section img{
	margin: 0 auto;
}
section div{
	text-align:center;
	height:668px;
	width:100%;
	min-width:1174px;
	padding-top: 655px;
	position:absolute;
}
section div a{
	color:#fff;
	background:#ff7800;
	padding: 5px  80px;
	font-weight:bold;
	font-size:22px;
	border-radius:5px;
}
section div a:hover{
	color:#fff;
	box-shadow: 0px 0px 2px 2px #dd6a03;
}
</style>
<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

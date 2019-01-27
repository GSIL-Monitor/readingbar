<!-- 继承整体布局 -->
@extends('front::mobile.common.main') @section('content')
<!-- 扩展内容-->

<section>
    <div data-am-widget="tabs"class="am-tabs container bgeeeeee " id="ptabs">
	      <ul class="am-tabs-nav userGuide-titile  am-cf">
	          <li class="am-active"><a href="[data-tab-panel-0]" id="tab1">定制阅读</a></li>
	          <li class=""><a href="[data-tab-panel-1]" id="tab3"> 自主阅读</a></li>
	          <li class=""><a href="[data-tab-panel-2]" id="tab4">阅读能力测评</a></li>
	      </ul>
	      <div class="am-tabs-bd userGuide-list">
	      <!--/-->
				<div data-tab-panel-0 class="am-tab-panel am-text-center am-active">
					@include("front::mobile.product.detail1")
				</div>
				<div data-tab-panel-1 class="am-tab-panel am-text-center">
					@include("front::mobile.product.detail3")	
				</div>
				<div data-tab-panel-2 class="am-tab-panel am-text-center">
					@include("front::mobile.product.detail4")
				</div>
	      </div>
	  </div>
	  <script type="text/javascript">
	      		var thisId = window.location.hash;
	      		$("#ptabs").tabs('open', $(thisId));
	      </script>
</section>
<!-- /扩展内容 -->
<div class="am-modal am-modal-no-btn" tabindex="-1" id="doc-modal-1">
	<div class="am-modal-dialog">
		<div class="am-modal-hd">
			蕊丁吧付费会员服务内容及使用须知 <a href="javascript: void(0)"
				class="am-close am-close-spin" data-am-modal-close>&times;</a>
		</div>
		<div class="am-modal-bd">
			<div class="" style="overflow-y: scroll; height: 60%">

				<div class="product-txt">
	 <p>一、 蕊丁吧会员说明</p>
	<p>1. 本服务内容及使用须知适用于蕊丁吧所有付费会员。</p>
	
		<br>
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
	<br>
	<p>三、 账号使用说明</p>
	<p>1. 会员付费后，系统会额外提供一个测试平台账号。</p>
	<p>2. 测试平台账号的使用人必须与学员信息一致，不允许与他人共用、外借或转让。</p>
	<p>3.
		蕊丁吧会定期对学员测试信息进行审核，如发现异常信息，将进行处理。首次发现异常信息，将与会员联系提出警告。如果出现第二次异常信息，将视为学员的严重违约行为，蕊丁吧将采取直接封号的处理，并不进行退费。
	</p>
	<p>4. 会员在服务期满后应当续费；如果会员停止续费，相应的会员服务将自动终止。重新续费后恢复服务。
		定制阅读会员（只限于定制阅读年会员）在服务有效期内，可申请最多1次，每次最长1个月的账号暂时冻结服务，冻结期间，所有服务暂停。解冻后，服务有效期顺延。没有申请则视为正常服务，时间不延续。
	</p>
	<br>
	<p>四、 退费说明</p>
	<p>1 《定制阅读》和《定制阅读plus》会员</p>
	<p>1.1 会员在付费后30日内可申请终止服务并申请退费；蕊丁吧在扣除10%全年服务费用后，将其余费用予以退回；超过30日，会员费用不予退回。押金在用户归还全部书籍（无破损或丢失）后于15个工作日内退还。</p>
	<p>1.2 会员服务到期，应提前或及时续费。如果到期后5日内未续费，也未还书的，将按照每天每本5元收取滞纳金，滞纳金从押金中扣除（滞纳金从逾期第1天开始计算）。</p>
	<p>1.3 押金退还说明：会员服务期满后，如不再续费，押金将退还到原支付账户，如有变化，会员应于期满前提前说明。</p>
	<p>2 《自主阅读》和《阅读能力测评》会员</p>
	<p>2.1 会员在付费后不得申请退费。</p>
	<br>
	<p>五、 美国系统账号使用说明</p>
	<p>1. 针对付费会员，蕊丁吧将分配一个美国系统账号。</p>
	<p>2. 会员使用美国系统账号时，除遵守本使用须知及《蕊丁吧用户协议》外，还应当遵守美国系统账号管理网站的相关规定。</p>
	<p>3. 蕊丁吧有权终止会员使用美国系统账号，但应提前30日通知会员。</p>
	<p>4. 蕊丁吧通知会员停止使用美国系统账号后，可以通过其他替代方案向会员提供服务。</p>

					<a href="javascript:void(0)" v-on:click="setProtocol()"
						class="product-txt-link">同意并支付</a> <a href="javascript:void(0)"
						data-am-modal-close class="product-txt-link2 ">不同意</a>
				</div>
				<div class="am-modal-footer">
					<span class="am-modal-btn" data-am-modal-cancel>取消</span> <span
						class="am-modal-btn" data-am-modal-confirm>确定</span>
				</div>

				<!--/modal-footer-->
			</div>
			<!--/-->
		</div>
	</div>
</div>
<!-- 孩子选择-模态框（Modal） -->
<div class="am-modal am-modal-no-btn" tabindex="-1"
	id="selectChildModal">
	<div class="am-modal-dialog">
		<div class="am-modal-hd">
			<span>选择孩子购买产品</span> <a href="javascript: void(0)"
				class="am-close am-close-spin" data-am-modal-close>&times;</a>
		</div>
		<div class="am-modal-bd">
			<temlpate v-for="s in students">
		
			<div v-if="checkArea(s)">
				<button v-if="buy.student_id==s.id" class="chose-childname2"
					v-on:click="setStudent(s.id)">[[s.name]]</button>
				<button v-else class="chose-childname" v-on:click="setStudent(s.id)">[[s.name]]</button>
			</div>
			</temlpate>
		</div>
		<!--/-->
		<div class="chose-child-tj">
			<button class="btn-mysure am-btn ds-ij2 fl cd-popup-close"
				v-on:click="goConfirm()">确定</button>
			<a class="btn-mycancel am-btn ds-ij3 fr cd-popup-close"
				v-on:click="cancel()">取消</a>
		</div>
		<!--/-->
	</div>
</div>

<!-- 孩子选择-模态框（Modal） -->

<div class="am-modal am-modal-no-btn" tabindex="-1" id="no-stock">
		  <div class="am-modal-dialog">
		    <div class="am-modal-hd">
		      <a href="javascript: void(0)" class="am-close am-close-spin camp_close" data-am-modal-close>&times;</a>
		    </div>
		    <div class="am-modal-bd camp_modal">
		     <span>此商品已售尽，下次记得早点来哦~</span>
		     <a href="{{ url('/') }}">返回首页</a>
		    </div>
		  </div>
		</div>	
		
<script>
	var product_list=new Vue({
		el:"body",
		data:{
			products:{!! json_encode($products) !!},
			students:{!! json_encode($students) !!},
			buy:{
				product_id:null,
				student_id:null,
				protocol:false
			},
			service_area:null
		},
		methods:{
			setProduct:function(id){
				this.clearBuy();
				for(i in this.products){
					if(this.products[i].id==id){
						this.service_area=this.products[i].service_area;
						this.buy.product_id=id;
						break;
					}
				}
			},
			skipProtocol:function(id){
				if(this.getLastQuantity(id)==0){
					$("#no-stock").modal('open');
				}else{
					this.setProduct(id);
					this.buy.protocol=true;
					$("#selectChildModal").modal('open');
				}
			},
			setProtocol:function(){
				this.buy.protocol=true;
				if(this.students.length==0){
					alert('请添加孩子！');
					window.location.href="{{ url('/member') }}";
					return;
				}
				$("#doc-modal-1").modal('close');
				$("#selectChildModal").modal('open');
			},
			setStudent:function(id){
				this.buy.student_id=id;
			},
			clearBuy:function(){
				this.buy={
						product_id:null,
						student_id:null,
						protocol:false
				};
			},
			goConfirm:function(){
				url="{{url('member/pay/confirm')}}";
				if(this.buy.product_id==null){
					alert('请选择产品！');
					return;
				}
				if(!this.buy.protocol){
					alert('您为同意购买协议！');
					return;
				}
				if(this.buy.student_id==null){
					alert('请选择孩子！');
					return;
				}
				window.location.href=url+"?product_id="+this.buy.product_id+"&protocol="+this.buy.protocol+"&student_id="+this.buy.student_id;
			},
			cancel:function(){
				$("#selectChildModal").modal('close');
			},
			//提示登录
			alertLogin:function(){
				alert('您尚未登录！');
				window.location.href="{{ url('/login') }}";
			},
			//校验孩子所在地与产品服务区域是否匹配
			checkArea:function(s){
				if(this.service_area=='全国'){
					return true;
				}else if(this.service_area.indexOf(s.province)!=-1){
					return true;
				}else{
					return false;
				}
			},
			getLastQuantity:function(id){
				for(i in this.products){
					if(this.products[i].id==id){
						return this.products[i].quantity;
					}
				}
				return 0;
			}
		}
	});
	@if($errors->has('product_id'))
		alert('选购的产品不存在！');
	@endif
</script>
@endsection
<!-- //继承整体布局 -->

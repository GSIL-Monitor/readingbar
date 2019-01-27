<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')
<!-- 扩展内容-->
    <!--/banner-->
   <style>
		body{ background-color:#f7f7f7;}
	</style>
    <div class="content  " >
      <div class="container cont-about container-2017" style="background-color:white">
      
		      <div class="content940 text-center">
		      	<p class=" font_title_b">英文阅读兴趣和习惯 从这里开始</p>
				<p class="pd15 font_title_b">每年100本+原版书</p>
		      </div>
		      <div class="content940 text-center">
		      <br>
		      	<img alt="" src="{{ asset('home/pc/images/products/detail_icon1.png')}}">
		      </div>
		      <br><br><br><br>
			  <div class="component-green-tbox font_content_g">
			     	<div class="box">
			     		<div>
			     			<p>价值9988元/年  现价6388元/年</p>
						</div>
						<em class="btn-img">
							<img src="{{ asset('home/pc/images/customread_11.png') }}">
						</em>
			     	</div>
			   </div>   
			   <br><br> 
			    <div class="component-green-tbox font_content_g">
			     	<div class="box">
			     		<div class="text-left">
			     			<p class="font_content_u">
			     				<strog>适合年龄:</strog>
			     				<span>K-6（学龄前至小学六年级）</span>
			     			</p>
			     			<p class="font_content_u">
			     				<strog>服务年限:</strog>
			     				<span>1年</span>
			     			</p>
			     			<p class="font_content_u">
			     				<strog>服务地区:</strog>
			     				<span>全国（除港澳台地区）</span>
			     			</p>
			     			<p class="font_content_u">
			     				<strog>图书借阅押金:</strog>
			     				<span>800元</span>
			     			</p>
						</div>
			     	</div>
			   </div>  
			   <br><br>
			  <div class="component-green-tbox font_content_g">
			     	<div class="box">
			     		<div>
			     			<p>服务内容</p>
						</div>
						<em class="btn-img">
							<img src="{{ asset('home/pc/images/customread_11.png') }}">
						</em>
			     	</div>
			   </div> 
			  <div class="text-center">
			  	 <div class="product-table row">
			  	 		<div class="col-xs-3">
			  	 			<div class="product-table-header">
			  	 				<span>服务项目</span>
			  	 				<img alt="" src="{{ asset('home/pc/images/products/tableHead/col1.png') }}">
			  	 			</div>
							<ul>
								<li>
								1对1专属导师</li>
								<li>个性化阅读计划</li>
								<li>进口英文原版书</li>
								<li>Book Report批改</li>
								<li>AR测试系统使用</li>
								<li>STAR测评系统使用</li>
								<li>阅读总结报告</li>
								<li>阶段成长分析报告</li>
								<li>AR书单搜索</li>
								<li>顺丰快递服务</li>
								<li>其他升级服务</li>
							</ul>
						</div>
				  	 	<div class="col-xs-2">
				  	 		<div class="product-table-header">
				  	 			<span>服务频次</span>
			  	 				<img alt="" src="{{ asset('home/pc/images/products/tableHead/col2.png') }}">
			  	 			</div>
							<ul>
								<li>工作日<br>9:00-18:00</li>
								<li>1年12次</li>
								<li>1年100本</li>
								<li>1年100套</li>
								<li>无限次</li>
								<li>1年3次</li>
								<li>1年12次</li>
								<li>1年2次</li>
								<li>随时</li>
								<li>1年24次</li>
								<li>随时</li>
							</ul>
						</div>
				  	 	<div class="col-xs-5">
				  	 		<div class="product-table-header">
				  	 			<span>具体内容</span>
			  	 				<img alt="" src="{{ asset('home/pc/images/products/tableHead/col3.png') }}">
			  	 			</div>
							<ul>
								<li>服务期内有任何问题，直接向专属导师咨询。</li>
								<li>选择符合孩子阅读能力和兴趣的图书、制定合理有效的阅读计划、提供个性化激励。</li>
								<li>以100本为基础，可适度增加或减少，具体数量以实际阅读计划为准。</li>
								<li>每本书都会有配套的Book Report，专属导师按月度整体进行批改</li>
								<li>每本AR分级读物都会配套一份或多份测试题目，每读完一本书都可随时进行测试，测试完成后可自行查看英文报告</li>
								<li>每次测试完成后，1个工作日内，专属导师上传中英文解读报告至官网【个人中心】</li>
								<li>每次阅读计划完成后，会出具相应总结报告</li>
								<li>报告内容含：测试系统原始报告&相关数据分析及英文阅读建议</li>
								<li>书单经导师们亲自一本一本阅读后定期更新，可向专属导师约书。</li>
								<li>含图书配送&还书</li>
								<li>Reading Camp，家长微课等。</li>
							</ul>
						</div>
				  	 	<div class="col-xs-2">
				  	 		<div class="product-table-header">
				  	 			<span>备注</span>
			  	 				<img alt="" src="{{ asset('home/pc/images/products/tableHead/col4.png') }}">
			  	 			</div>
							<ul>
								<li></li>
								<li><a href="{{ url('files/sample/ReadingPlan.pdf') }}"  target="_blank">【查看样例】</a></li>
								<li><a href="{{ url('files/sample/OriginalBook.pdf') }}"  target="_blank">【查看样例】</a></li>
								<li><a href="{{ url('files/sample/BookReport.jpg') }}"  target="_blank">【查看样例】</a></li>
								<li>AR在库图书约18万册。<a href="{{ url('files/sample/ArTest.pdf') }}"  target="_blank">【查看样例】</a></li>
								<li><a href="{{ url('files/sample/StarEnglishReport.pdf') }}" target="_blank">【查看样例】</a></li>
								<li><a href="{{ url('files/sample/ReadingSummaryReport.pdf') }}"  target="_blank">【查看样例】</a></li>
								<li><a href="{{ url('files/sample/PhaseAnalysisReport.pdf') }}"  target="_blank">【查看样例】</a></li>
								<li>在官网【个人中心】使用此功能。</li>
								<li></li>
								<li>部分收费</li>
								
							</ul>
						</div>
			  	 	</div>
			  </div>
			   <br><br>
			   <div class="content940 text-center">
			   
			   		@if(auth('member')->isLoged())
			   			<a href="javascript:void(0)" class="btn-local" data-toggle="modal" data-target="#protocolModal" v-on:click="setProduct(1)">
				   			<em class="circle-left"></em>
				   			点击购买
				   			<em class="circle-right"></em>
				   		</a>
					@else
						<a href="javascript:void(0)" class="btn-local" v-on:click="alertLogin()">
				   			<em class="circle-left"></em>
				   			点击购买
				   			<em class="circle-right"></em>
				   		</a>
					@endif	
			   		
			   </div>
      </div>
    </div>
<!-- 模态框（Modal） -->
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
	<br>
	<p>五、 美国系统账号使用说明</p>
	<p>1. 针对付费会员，蕊丁吧将分配一个美国系统账号。</p>
	<p>2. 会员使用美国系统账号时，除遵守本使用须知及《蕊丁吧用户协议》外，还应当遵守美国系统账号管理网站的相关规定。</p>
	<p>3. 蕊丁吧有权终止会员使用美国系统账号，但应提前30日通知会员。</p>
	<p>4. 蕊丁吧通知会员停止使用美国系统账号后，可以通过其他替代方案向会员提供服务。</p>

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
<!-- 模态框（Modal）end -->
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

				<temlpate v-for="s in students">
					<div v-if="checkArea(s)">
						<button v-if="buy.student_id==s.id" class="btn btn-primary "
							v-on:click="setStudent(s.id)"
							style="float: left; margin-right: 10px">[[s.name]]</button>
						<button v-else class="btn btn-default "
							v-on:click="setStudent(s.id)"
							style="float: left; margin-right: 10px">[[s.name]]</button>
					</div>
				</temlpate>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default"
					v-on:click="goConfirm()">确认</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal -->
</div>
<!-- 孩子选择-模态框（Modal）end -->    
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
			//设置要购买的产品
			setProduct:function(id){
				this.clearBuy();
				for(i in this.products){
					if(this.products[i].id=id){
						this.service_area=this.products[i].service_area;
						this.buy.product_id=id;
						break;
					}
				}
				
			},
			//同意购买协议
			setProtocol:function(){
				this.buy.protocol=true;
				if(this.students.length==0){
					alert('请添加孩子！');
					window.location.href="{{ url('/member') }}";
					return;
				}
				$("#protocolModal").modal('hide');
				$("#selectChildModal").modal('show');
			},
			//设置购买产品的孩子信息
			setStudent:function(id){
				this.buy.student_id=id;
			},
			//清空购物信息
			clearBuy:function(){
				this.buy={
						product_id:null,
						student_id:null,
						protocol:false
				};
			},
			//校验&确认购买信息
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
			}
		}
	});
	@if($errors->has('product_id'))
		alert('选购的产品不存在！');
	@endif
</script>
<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

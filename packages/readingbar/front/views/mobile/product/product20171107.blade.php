<!-- 继承整体布局 -->
@extends('front::mobile.common.main') @section('content')
<!-- 扩展内容-->
<link rel="stylesheet" type="text/css" href="{{ url('home/wap/css/product20171107.css') }}">
    	
    <section id="product">
    	<!-- 产品选择 -->
    	<div data-am-widget="tabs" class="am-tabs am-tabs-default">
	      <ul class="am-tabs-nav am-cf">
	          <li class="am-active"><a href="[data-tab-panel-0]">测试系统服务</a></li>
	          <li class=""><a href="[data-tab-panel-1]">定制服务</a></li>
	          <li class=""><a href="[data-tab-panel-2]">借阅服务</a></li>
	      </ul>
	      <div class="am-tabs-bd">
	          <div data-tab-panel-0 class="am-tab-panel am-active">
	            	<div class="title">——测试系统服务——</div>
			          <div class="text1">
			                 	适合人群：学龄前-小学六年级学生<br>
			                 	适合地区：全国（除港澳台）
			          </div>
			          <div class="text3">
	                 	A：阅读能力测评服务<span class="num">399</span>元/年
	                 </div>
	                 <div class="indent30">
	                 	<img alt="" class="yuan" src="{{ url('home/wap/images/products/20171107/yuan.png') }}">1年服务期
	                 </div>
	                 <div class="indent30">
						<img alt="" class="yuan" src="{{ url('home/wap/images/products/20171107/yuan.png') }}">3次STAR阅读能力测评
					</div>
					<div class="indent30">
						<img alt="" class="yangli" src="{{ url('home/wap/images/products/20171107/yangli.png') }}" v-on:click="downloadSample(1)">
					</div>
	                 <div class="text3">
	                 	B：书籍测试服务<span class="num">999</span>元/年
	                 </div>
	                 <div class="indent30">
	                 	<img alt="" class="yuan" src="{{ url('home/wap/images/products/20171107/yuan.png') }}">1年服务期
	                 </div>
	                 <div class="indent30">
						<img alt="" class="yuan" src="{{ url('home/wap/images/products/20171107/yuan.png') }}">无限次AR书籍测试
					</div>
					<div class="indent30">
						<img alt="" class="yangli" src="{{ url('home/wap/images/products/20171107/yangli.png') }}" v-on:click="downloadSample(2)">
					</div>
	                 <div class="text3">
	                 	A+B：综合系统服务<span class="num">1298</span>元/年
	                 </div>
	                 <div class="indent30">
	                 	<img alt="" class="yuan" src="{{ url('home/wap/images/products/20171107/yuan.png') }}">1年服务期
	                 </div>
	                 <div class="indent30">
						<img alt="" class="yuan" src="{{ url('home/wap/images/products/20171107/yuan.png') }}">3次STAR阅读能力测评+3次AR书单推荐（每次20本）
					</div>
					 <div class="indent30">
						<img alt="" class="yuan" src="{{ url('home/wap/images/products/20171107/yuan.png') }}">无限次AR书籍测试
					</div>
					<div class="indent30">
						<img alt="" class="yuan" src="{{ url('home/wap/images/products/20171107/yuan.png') }}">老师每月监测阅读时间及目标并及时调整。
					</div>
	            	<img alt=""  class="xuzhi" src="{{ url('home/wap/images/products/20171107/xuzhi.png') }}">
	            	<img alt=""  class="goumai" src="{{ url('home/wap/images/products/20171107/goumai.png') }}" v-on:click="showModal('A')">
	          </div>
	          <div data-tab-panel-1 class="am-tab-panel ">
	                 <div class="title">——定制服务——</div>
	                  <div class="text3">
	                 	<span class="num">6688</span>元/年，押金<span class="num">800</span>元
	                 </div>
	                 <div class="text1">
	                 	适合人群：学龄前-小学六年级学生<br>
	                 	适合地区：全国（除新疆、西藏、港澳台）
	                 </div>
	                 <div class="indent30">
	                 	<img alt="" class="yuan" src="{{ url('home/wap/images/products/20171107/yuan.png') }}">1年服务期
	                 </div>
	                 <div class="indent30">
						<img alt="" class="yuan" src="{{ url('home/wap/images/products/20171107/yuan.png') }}">3次STAR阅读能力测评
					</div>
	                 <div class="indent30">
						<img alt="" class="yuan" src="{{ url('home/wap/images/products/20171107/yuan.png') }}">无限次AR书籍测试
					</div>
	                 <div class="indent30">
						<img alt="" class="yuan" src="{{ url('home/wap/images/products/20171107/yuan.png') }}">老师每月监测阅读时间及目标并及时调整
					</div>
	                 <div class="indent30">
						<img alt="" class="yuan" src="{{ url('home/wap/images/products/20171107/yuan.png') }}">每月1次个性化阅读计划，含：
					</div>
	                 <div class="text2 indent30">
						15本原版分级读物<br>
						BOOKREPORT批改指导<br>
						阅读任务布置及奖励<br>
						<img alt="" class="yangli" src="{{ url('home/wap/images/products/20171107/yangli.png') }}" v-on:click="downloadSample(3)">
					</div>
					<div class="indent30">
						<img alt="" class="yuan" src="{{ url('home/wap/images/products/20171107/yuan.png') }}">1 对1 专属导师全年跟踪服务，及时发现问题，调整阅读计划
					</div>
	                 <div class="indent30">
						<img alt="" class="yuan" src="{{ url('home/wap/images/products/20171107/yuan.png') }}">含24次顺丰快递费用
	                 </div>
	                 <img alt=""  class="xuzhi" src="{{ url('home/wap/images/products/20171107/xuzhi2.png') }}">
	                 <img alt="" class="goumai"  src="{{ url('home/wap/images/products/20171107/goumai.png') }}"  v-on:click="selectProduct(1)">
	          </div>
	          <div data-tab-panel-2 class="am-tab-panel ">
	                 <div class="title">——借阅服务——</div>
	                 <div class="text1">
	                 	适合人群：学龄前-小学六年级学生
	                 </div>
	                 <div class="text2">
	                 	1.服务期内会员并有蕊丁吧出具的STAR测评数据
	                 </div>
	                 <div class="text2">
	                 	2.GE指数小于6
	                 </div>
	                 <div class="text1">
	                 	适合地区：全国（除新疆、西藏、港澳台）
	                 </div>
	                 <div>
	                 	A：6本AR分级读物单次借阅
	                 </div>
	                 <div class="text3" style="padding-left:35px">
	                 	<span class="num">99</span>元 (原价 <span class="num" style="text-decoration:line-through;">199</span> 元)，押金<span class="num">300</span>元
	                 </div>
	                 <div>
	                 	B：12本AR分级读物单次借阅
	                 </div>
	                 <div class="text3" style="padding-left:35px">
	                     <span class="num">169</span>元 (原价 <span class="num" style="text-decoration:line-through;">368</span> 元)，押金<span class="num">600</span>元
	                 </div>
	                 <div class="text4">
	                 	<img alt="" class="yuan" src="{{ url('home/wap/images/products/20171107/yuan.png') }}">借阅期40 天<br>
						<img alt="" class="yuan" src="{{ url('home/wap/images/products/20171107/yuan.png') }}">含往返顺丰快递费用<br>
						<img alt="" class="yuan" src="{{ url('home/wap/images/products/20171107/yuan.png') }}">老师与家长简单沟通后，根据ZPD指数和阅读兴趣科学选书。<br>
						<img alt="" class="yuan" src="{{ url('home/wap/images/products/20171107/yuan.png') }}">购买后2 个工作日内老师上传书单信息，请登录【蕊丁吧】官网【我的书单】处确认后方可寄出书籍。
	                 </div>
	                 <img alt=""  class="xuzhi" src="{{ url('home/wap/images/products/20171107/xuzhi3.png') }}">
	                 <img alt=""  class="goumai" src="{{ url('home/wap/images/products/20171107/goumai.png') }}" v-on:click="showModal('B')">
	          </div>
	      </div>
	  </div>
	  <!-- 产品选择 -->
	  <!-- 测试服务产品选择  -->
	  	<div class="am-modal am-modal-confirm modal-buy" tabindex="-1" id="modal-A">
		  <div class="am-modal-dialog">
		    <div class="am-modal-hd">测试系统服务</div>
		    <div class="am-modal-bd">
		        <div class="option">
		        	<img alt="" class="goumai"  src="{{ url('home/wap/images/products/20171107/radio_yes.png') }}"  v-if="product_id===16">
		        	<img alt="" class="goumai"  src="{{ url('home/wap/images/products/20171107/radio_no.png') }}" v-else v-on:click="selectProduct(16)">
		        	A：阅读能力测评服务（399元/年）
		        </div>
		         <div class="option">
		        	<img alt="" class="goumai"  src="{{ url('home/wap/images/products/20171107/radio_yes.png') }}" v-if="product_id===17">
		        	<img alt="" class="goumai"  src="{{ url('home/wap/images/products/20171107/radio_no.png') }}" v-else  v-on:click="selectProduct(17)">
		        	B：书籍测试服务（999元/年）
		        </div>
		         <div class="option">
		        	<img alt="" class="goumai"  src="{{ url('home/wap/images/products/20171107/radio_yes.png') }}" v-if="product_id===18">
		        	<img alt="" class="goumai"  src="{{ url('home/wap/images/products/20171107/radio_no.png') }}" v-else  v-on:click="selectProduct(18)">
		        	C：综合系统服务（1298元/年）
		        </div>
		    </div>
		    <div class="am-modal-footer">
		      <span class="am-modal-btn" data-am-modal-cancel>取消</span>
		      <span class="am-modal-btn" data-am-modal-confirm>下一步</span>
		    </div>
		  </div>
		</div>
	  <!-- 测试服务产品选择 -->
	  <!-- 图书借阅 -->
	  	<div class="am-modal am-modal-confirm modal-buy" tabindex="-1" id="modal-B">
		  <div class="am-modal-dialog">
		    <div class="am-modal-hd">图书借阅</div>
		    <div class="am-modal-bd">
		       <div class="option">
		        	<img alt="" class="goumai"  src="{{ url('home/wap/images/products/20171107/radio_yes.png') }}"  v-if="product_id===14">
		        	<img alt="" class="goumai"  src="{{ url('home/wap/images/products/20171107/radio_no.png') }}" v-else v-on:click="selectProduct(14)">
		        	A：6本AR分级读物单次借阅（99元）
		        </div>
		         <div class="option">
		        	<img alt="" class="goumai"  src="{{ url('home/wap/images/products/20171107/radio_yes.png') }}" v-if="product_id===15">
		        	<img alt="" class="goumai"  src="{{ url('home/wap/images/products/20171107/radio_no.png') }}" v-else  v-on:click="selectProduct(15)">
		        	B：12本AR分级读物单次借阅（169元）
		        </div>
		    </div>
		    <div class="am-modal-footer">
		      <span class="am-modal-btn" data-am-modal-cancel>取消</span>
		      <span class="am-modal-btn" data-am-modal-confirm>下一步</span>
		    </div>
		  </div>
		</div>
	  <!-- 图书借阅 -->
	  <!-- 购买须知 -->
	  	<div class="am-modal am-modal-confirm modal-buy" tabindex="-1" id="modal-NK">
		  <div class="am-modal-dialog">
		    <div class="am-modal-hd">付费使用须知</div>
		    <div class="am-modal-bd">
		       <!-- 一般须知 -->
		       <div v-if="product_id!=14 && product_id!=15 ">
			       <strong>	一、 蕊丁吧会员说明</strong><br>
					1. 本服务内容及使用须知适用于蕊丁吧所有付费会员。
					<br><br>
					 <strong>二、 押金、损耗、赔偿及还书（针对定制服务会员）</strong><br>
					1.会员在购买定制服务时，同时需要缴纳图书借阅押金。<br>
					2.蕊丁吧每本书都是精心挑选，从国外引进的，我们希望各位会员能与蕊丁吧一起爱护每一本图书。如学员对图书造成的损耗，需要支付相应的赔偿。具体规定如下：<br>
					2.1 图书如在借阅过程中有轻微损毁，请家长在还书时主动告知，由我们进行修补。<br>
					2.2 若有出现圈点、涂画、撕毁、烧残、水浸、划线、注字、涂抹、卷曲、折皱等但不影响其内容完整，能继续使用的，按污损页数计罚，每页需按照（定价/页码）*2的标准赔偿金。赔偿金额超过书籍定价的，将按书籍定价的1.5倍进行赔偿，已破损的书籍归用户所有。赔偿费用需单独支付（不接受用户自行购买进行赔偿）。<br>
					2.3 出现开胶、撕页或大面积涂写等严重影响书籍正常阅读的，应按书籍定价的1.5倍进行赔偿，已破损的书籍归用户所有。赔偿费用需单独支付（不接受用户自行购买进行赔偿）。<br>
					3.书籍定价<br>
					3.1 书籍的价值以每本书的RMB标价为准。RMB标价按照以下方式计算：<br>
					3.1.1 对图书上标有美元定价的， RMB标价按照以书籍上美元定价乘以6.7的汇率标准进行计算（四舍五入去除分角）。<br>
					3.1.2 对图书上未标出美元定价的，RMB标价按照相同ISBN书籍的亚马逊网站的美元定价乘以6.7的汇率标准进行计算（四舍五入去除分角）。<br>
					4.书籍寄回说明<br>
					为方便您能够顺利按时将图书寄回，我们已将顺丰快递单放入盒子中，还书时您只需在签名处签字，并把盒子以及二维码快递单给上门取件的顺丰快递员即可。<br>
					4.1.寄件方式 ：顺丰到付。<br>
					4.2.下单方式：可选择以下三种方式之一。<br>
					电话：拨打“95338”预约上门取件。<br>
					网站：登录 http://www.sf-express.com预约上门取件。<br>
					微信：关注【顺丰速运】公众号，点击“寄快递”中的“收派员上门”。<br>
					4.3.注意事项<br>
					运单产品类型，北京、天津用户请选择【顺丰标快】；其他地区用户请选择【顺丰特惠】。<br>
					备注：因没有按照说明选择/填写运单信息，导致运费增加的部分，将从押金扣除。<br><br>
					
					<strong>三、 测试系统账号使用说明</strong><br>
					1. 会员付费后，系统会额外提供一个测试平台账号。<br>
					2. 测试平台账号的使用人必须与学员信息一致，不允许与他人共用、外借或转让。<br>
					3. 蕊丁吧会定期对学员测试信息进行审核，如发现异常信息，将进行处理。首次发现异常信息，将与会员联系提出警告。如果出现第二次异常信息，将视为学员的严重违约行为，蕊丁吧将采取直接封号的处理，并不进行退费。<br>
					4. 会员在服务期满后应当续费；如果会员停止续费，相应的会员服务将自动终止。重新续费后恢复服务。定制服务会员（只限于定制服务会员）在服务有效期内，可申请最多1次，每次最长1个月的账号暂时冻结服务，冻结期间，所有服务暂停。解冻后，服务有效期顺延。没有申请则视为正常服务，时间不延续。<br>
					5. 会员使用测试系统账号时，除遵守本使用须知及《蕊丁吧用户协议》外，还应当遵守美国系统账号管理网站的相关规定。<br>
					6. 蕊丁吧有权终止会员使用美国系统账号，但应提前30日通知会员。<br>
					7. 蕊丁吧通知会员停止使用美国系统账号后，可以通过其他替代方案向会员提供服务。<br><br>
					
					
					<strong>四、 退费说明</strong><br>
					1.定制服务会员<br>
					1.1 定制服务会员（仅限于定制服务会员）在付费后30日内可申请终止服务并申请退费；蕊丁吧在扣除综合系统服务及10%服务费用后，将其余费用予以退回，退费后用户可继续使用STAR阅读能力测评系统和AR书籍测试系统；超过30日，会员费用不予退回。押金在用户归还全部书籍（无破损或丢失）后于15个工作日内退还。<br>
					1.2 会员服务到期，应提前或及时续费。如果到期后5日内未续费，也未还书的，将按照每天每本5元收取滞纳金，滞纳金从押金中扣除（滞纳金从逾期第1天开始计算）。<br>
					1.3 押金退还说明：会员服务期满后，如不再续费，押金将退还到原支付账户，如有变化，会员应于期满前提前说明。<br>
					2.分级测试系统服务会员<br>
					2.1 会员在付费后不得申请退费。<br>
		       </div>
		       <div v-else>
		       		<strong>借阅及还书规定</strong><br>
					1.借阅时间：从官网付费购买之日算起40日内；<br>
					2.还书日期：以蕊丁吧收到书籍时间为准；逾期还书将按照每天每本5元收取滞纳金，滞纳金从押金中扣除（滞纳金从逾期第1天开始计算）；<br>
					3.借阅押金：服务期满后，押金将于五个工作日内退还到原支付账户。<br>
					4.如遇特殊情况不能如期还书，请事先沟通，书籍如出现严重破损请做相应赔偿，赔偿原则请参考以下内容<br><br>
					
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
		       </div>
		    </div>
		    <div class="am-modal-footer">
		      <span class="am-modal-btn" data-am-modal-cancel>取消</span>
		      <span class="am-modal-btn" data-am-modal-confirm>同意</span>
		    </div>
		  </div>
		</div>
	  <!-- 购买须知 -->
	  <!-- 孩子选择 -->
	  	<div class="am-modal am-modal-confirm modal-buy" tabindex="-1" id="modal-SC">
		  <div class="am-modal-dialog">
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
	   <!-- 未登录 -->
	  	<div class="am-modal am-modal-confirm" tabindex="-1" id="modal-unlogin">
		  <div class="am-modal-dialog">
		    <div class="am-modal-hd">提示</div>
		    <div class="am-modal-bd">
		    	 请您先免费注册，如已注册请直接登录！
		    </div>
		    <div class="am-modal-footer">
		      <a class="am-modal-btn" data-am-modal-confirm  onclick="window.location.href='{{ url('register?intended='.request()->path()) }}'">注册</a>
		      <a class="am-modal-btn" data-am-modal-confirm   onclick="window.location.href='{{ url('login?intended='.request()->path()) }}'">登录</a>
		    </div>
		  </div>
		</div>
	  <!-- 未登录-->
    </section>
       <style>
    	#needKnow .content{
    		line-height:25px;
    	}
    </style>
    <script type="text/javascript">
		new Vue({
			el: "#product",
			data:{
				students: {!! $students->toJson() !!},
				products: {!! $products->toJson() !!},
				step:1,
				student_id: null,
				protocol: null,
				product_id: null
			},
			methods:{
				// 测试系统选择产品
				showModal: function (t) {
					if (!this.checkAuth()){
						return null;
					}
					// 判断是否有孩子 没有则跳转孩子添加界面
					if (this.students.length === 0) {
						amazeAlert({
							title: '提示',
							msg: '您名下没有孩子,请去添加孩子!',
							confirm: '添加孩子',
							onConfirm: function () {
								window.location.href="{{ url('/member/children/create') }}"
							}
						});
						return false;
					}
					var _this = this;
					switch(t) {
						case "A": 
							$('#modal-A').modal({
								closeViaDimmer:false,
						        onConfirm: function(options) {
							        if (!_this.product_id) {
	         								amazeAlert({
	                                           msg: '请选择产品服务',
	                                           onConfirm: function () {
	                                        	   _this.showModal('A')
		                                       }
	             							});
									}else{
										  _this.showModalNK();
									}
						        },
						        onCancel: function (){
									_this.cancel();
							    }
						   });
							break;
						case "B": 
							$('#modal-B').modal({
								closeViaDimmer:false,
						        onConfirm: function(options) {
						        	 if (!_this.product_id) {
						        		 	amazeAlert({
	                                           msg: '请选择产品服务',
	                                           onConfirm: function () {
	                                        	   _this.showModal('B')
		                                       }
	             							});
									}else{
										  _this.showModalNK();
									}
						        },
						        onCancel: function (){
									_this.cancel();
							    }
						   });
							break;
					}
				},
				// 选择产品
				selectProduct:function (pid) {
					if (!this.checkAuth()){
						return null;
					}
					// 判断是否有孩子 没有则跳转孩子添加界面
					if (this.students.length === 0) {
						amazeAlert({
							title: '提示',
							msg: '您名下没有孩子,请去添加孩子!',
							confirm: '添加孩子',
							onConfirm: function () {
								window.location.href="{{ url('/member/children/create') }}"
							}
						});
						return false;
					}
					if (this.checkAuth() && this.checkProduct(pid)) {
						this.product_id = pid;
						this.step = 2;
						if (this.product_id===1){
							this.showModalNK();
						}
					}
				},
				// 校验产品
				checkProduct:function (pid) {
					for(i in this.products) {
						if (this.products[i].id == pid){
							var p = this.products[i];
							var msg = null;
							if(p.show == 0) {
								msg='产品不存在！';
							}else if(p.quantity == 0){
								msg='产品已售完！';
							}
							if(msg){
								amazeAlert({
									title: '提示',
									msg: msg
								});
								return false;
							}
							return true;
							break;
						}
					}
					amazeAlert({
						title: '提示',
						msg: '产品不存在！'
					});
					return false;
				},
				// 校验用户是否登陆了
				checkAuth:function (){
					if ({!! auth('member')->guest()?'true':'false' !!}) {
						$("#modal-unlogin").modal();
						return false;
					}else{
						return true;
					}
				},
				// 选择孩子
				selectStudent: function (s){
					this.student_id=s.id;
				},
				// 校验须知
				agreeProtocol: function (){
					this.protocol=true;
					this.step = 3;
					this.showModalSC();
				},
				// 显示须知
				showModalNK:function (){
					var _this= this;
					$('#modal-NK').modal({
						closeViaDimmer:false,
				        onConfirm: function(options) {
				           _this.agreeProtocol();
				        },
				        onCancel: function (){
							_this.cancel();
					    }
				   });
				},
				// 显示孩子选择
				showModalSC:function (){
					var _this= this;
					$('#modal-SC').modal({
						closeViaDimmer:false,
				        onConfirm: function(options) {
				        	if(_this.student_id) {
								url="{{url('member/pay/confirm')}}";
								window.location.href=url+"?product_id="+_this.product_id+"&protocol="+_this.protocol+"&student_id="+_this.student_id;
					        }else {
					        	amazeAlert({
	                                msg: '请选择产品服务',
	                                onConfirm: function () {
	                             	   _this.showModalSC()
	                                }
	  							});
						    }
				        },
				        onCancel: function (){
							_this.cancel();
					    }
				   });
				},
				// 返回产品选择界面
				cancel:function () {
					this.student_id=null;
					this.protocol=null;
					this.product_id=null;
					this.step = 1;
				},
				// 下载样例
				downloadSample: function (t){
					switch (t) {
						case 1: // 阅读能力测评系统
							window.open("{{ url('files/sample/StarTest20171116.pdf') }}");break;
						case 2: // 书籍测试系统
							window.open("{{ url('files/sample/ARBook20171116.pdf') }}");break;
						case 3: // 定制服务
							window.open("{{ url('files/sample/ReadPlan20171116.pdf') }}");break;
					}
				}
			}
		});
	</script>
<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

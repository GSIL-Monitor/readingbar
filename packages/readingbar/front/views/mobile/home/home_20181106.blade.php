<!-- 继承整体布局 -->
@extends('front::mobile.common.main')

@section('content')
<section id="index">
	<div id="banner">
		<div  class="am-slider am-slider-b4" >
		  <ul class="am-slides">
		      <li>
		        	<img alt="" src="{{url('home/wap/images/banner/20181107.png')}}">
					<div id="banner-info">
						<div class="title">英文分级阅读服务专家</div>
				  		<div class="content">
					  				您想了解孩子的英文阅读水平吗？<br/>
									您想了解孩子当前适合阅读什么原版书吗？<br/>
									您想了解孩子阅读的书到底理解多少吗？
						</div>
				  		<div class="btn">
				  				<a href="#ra">Go</a>
				  		</div>
					</div>
		      </li>
		  </ul>
		</div>
	</div>
	<script type="text/javascript">
		// 停止轮播功能
		$(function(){
			$('.am-slider').flexslider({touch: false});
		})
	</script>
	<div id="index-buttons">
		<a href="{{ url('/ranking') }}">
			<img class="img" src="{{ asset('home/wap/images/home/ranking.png') }}"/><div class="title">小达人排行</div>
		</a>
		<a href="{{ url('/activity/PublicBenefitActivities') }}">
			<img class="img" src="{{ asset('home/wap/images/home/angel.png') }}"/><div class="title">阅读小天使</div>
		</a>
		<a href="{{ url('/introduce/RDMessenger') }}">
			<img class="img" src="{{ asset('home/wap/images/home/recruit.png') }}"/><div class="title">蕊丁吧招募</div>
		</a>
	</div>
	<div id="text-entrance">
		<a href="https://hosted14.renlearn.com/5561679/Public/RPM/Login/Login.aspx?srcID=s" class="btn">测试系统入口</a>
		<a href="{{ url('introduce/userGuide') }}" class="btn">测试系统指南</a>
	</div>
	<div style="clear:both"/>
	<div id="raz">
		<div class="title_v1">
			<div>Raz-Kids在线阅读</div>
			<div><hr/></div>
		</div>
		<div class="middle-info"><span class="fc-main fs-18">适合年龄：</span>幼儿园中班到小学3年级</div>
		<div class="middle-info"><span class="fc-main fs-18">推荐人群：</span>处于英文阅读启蒙阶段的小朋友</div>
		<div class="qrcode">
			<img src="{{ asset('home/wap/images/home/qrcode/qrcode-raz-teacher.jpg') }}"/>
			<div class="memo">
				<div>请扫描二维码</div><div>添加老师微信</div>
			</div>
		</div>
		<img class="raz-kids" alt="" src="{{ asset('home/wap/images/home/raz-kids.png') }}"/>
	</div>
	<div id="ra">
		<div class="first-tab">	
			<a href="javascript:void(0)"  :class="first_tab == 1?'active':''" v-on:click="changeFirstTab(1)">测试系统服务</a>
			<a href="javascript:void(0)"  :class="first_tab == 2?'active':''" v-on:click="changeFirstTab(2)">AR图书借阅</a>
		</div>
		<div class="second-tab" v-if="first_tab == 1">
			<a href="javascript:void(0)" :class="second_tab == 1?'active':''" v-on:click="changeSecondTab(1)">体验服务</a>
			<a href="javascript:void(0)" :class="second_tab == 2?'active':''" v-on:click="changeSecondTab(2)">年服务</a>
		</div>
		<!-- 测试系统服务-体验服务  -->
		<div class="third-tab"  v-show="first_tab==1 && second_tab==1">
			<div class="am-tabs" data-am-tabs>
			  <ul class="am-tabs-nav am-nav am-nav-tabs">
			    <li class="am-active"><a href="#tab1">单次STAR测评</a></li>
			    <li><a href="#tab2">综合系统月体验</a></li>
			  </ul>
			
			  <div class="am-tabs-bd"  >
			    <div class="am-tab-panel am-fade am-in am-active" id="tab1">
			      	<div class="title_v2">
						<div>单次STAR测评</div>
						<div><hr></div>
						<div>150元/次</div>
					</div>
					<div class="info">
						<div><strong>适合年龄</strong>：幼儿园大班到高三</div>
						<div class="tp">
							<div><strong>推荐人群</strong>：</div>
							<div>首次体验测试系统或想了解孩子当前英文阅读能力水平的家长</div>
						</div>
						<div><strong>服务有效期</strong>：15天</div>
						<div class="tp">
							<div><strong>服务包含</strong>：</div>
							<div>测试后一个工作日，提供中、英文STAR测试报告以及20本个性化推荐书单</div>
						</div>
					</div>
					<div class="btn-buy">
							<a href="javascript:void(0)" v-on:click="selectProduct(8)">立即购买</a>
					</div>
			    </div>
			    <div class="am-tab-panel am-fade" id="tab2">
			     	<div class="title_v2">
						<div>综合系统月体验</div>
						<div><hr></div>
						<div>366元</div>
					</div>
					<div class="info">
						<div><strong>适合年龄</strong>：幼儿园大班到高三</div>
						<div class="tp">
							<div><strong>推荐人群</strong>：</div>
							<div>想全面体验测试服务和借阅服务的家长</div>
						</div>
						<div><strong>服务有效期</strong>：30天</div>
						<div><strong>服务包含</strong>：</div>
						<div class="tp">
							<div>（1）</div>
							<div>单次STAR测评</div>
						</div>
						<div class="tp">
							<div>（2）</div>
							<div>一个月书籍测试Plus服务</div>
						</div>
						<div class="tp">
							<div>（3）</div>
							<div>一次6本AR图书免费借阅，借阅期40天</div>
						</div>
					</div>
					<div class="btn-buy">
							<a href="javascript:void(0)" v-on:click="selectProduct(13)">立即购买</a> 
					</div>
			    </div>
			  </div>
			</div>
		</div>
		<!-- 测试系统服务-年服务  -->
		<div class="third-tab"  v-show="first_tab==1 && second_tab==2">
			<div class="am-tabs" data-am-tabs>
			  <ul class="am-tabs-nav am-nav am-nav-tabs">
			    <li class="am-active"><a href="#tab1">书籍测试Plus</a></li>
			    <li><a href="#tab2">综合系统服务</a></li>
			    <li><a href="#tab3">定制阅读服务</a></li>
			  </ul>
			
			  <div class="am-tabs-bd"  >
			    <div class="am-tab-panel am-fade am-in am-active" id="tab1">
			      	<div class="title_v2">
						<div>
							书籍测试Plus
						</div>
						<div><hr></div>
						<div>999元/年</div>
					</div>
					<div class="info">
						<div><strong>适合年龄</strong>：小学三年级到高三</div>
						<div class="tp">
							<div><strong>推荐人群</strong>：</div>
							<div>想了解孩子平时阅读书籍的理解程度、加强nonfiction文章阅读的家长</div>
						</div>
						<div><strong>服务有效期</strong>：1年</div>
						<div><strong>服务包含</strong>：</div>
						<div class="tp">
							<div>（1）</div>
							<div>书籍测试（不限次数）</div>
						</div>
						<div class="tp">
							<div>（2）</div>
							<div>nonfiction文章在线阅读及评估测试（不限次数）</div>
						</div>
						<div class="tp">
							<div><strong>增值服务</strong>：</div>
							<div>可联系老师为孩子设置AR POINTS目标积分 <img v-on:click="showTip(1,$event)" class="doubt" src="{{ url('home/pc/images/home/icon/icon-doubt.png') }}"></div>
						</div>
					</div>
					<div class="btn-buy">
							<a href="javascript:void(0)" v-on:click="selectProduct(17)">立即购买</a> 
					</div>
			    </div>
			    <div class="am-tab-panel am-fade" id="tab2">
			     	<div class="title_v2">
						<div>综合系统服务</div>
						<div><hr></div>
						<div>1298元/年</div>
					</div>
					<div class="info">
						<div><strong>适合年龄</strong>：幼儿园大班到高三</div>
						<div class="tp">
							<div><strong>推荐人群</strong>：</div>
							<div>有足够的时间和精力关注孩子阅读，可通过监测系统数据，引导孩子培养英文阅读习惯的家长</div>
						</div>
						<div><strong>服务有效期</strong>：1年</div>
						<div><strong>服务包含</strong>：</div>
						<div class="tp">
							<div>（1）</div>
							<div>一年3次STAR测试 <img v-on:click="showTip(2,$event)" class="doubt" src="{{ url('home/pc/images/home/icon/icon-doubt.png') }}" data-original-title="" title="">，测试后，一个工作日提供一份中、英文STAR测试报告以及20本个性化推荐书单</div>
						</div>
						<div class="tp">
							<div>（2）</div>
							<div>书籍测试Plus服务</div>
						</div>
						<div><strong>增值服务</strong>：</div>
						<div class="tp">
							<div>（1）</div>
							<div>可联系老师为孩子设置AR POINTS目标积分 <img class="doubt" v-on:click="showTip(1,$event)" src="{{ url('home/pc/images/home/icon/icon-doubt.png') }}"></div>
						</div>
						<div class="tp">
							<div>（2）</div>
							<div>全年阅读数据报告一份</div>
						</div>
					</div>
					<div class="btn-buy">
							<a href="javascript:void(0)" v-on:click="selectProduct(18)">立即购买</a> 
					</div>
			    </div>
			    <div class="am-tab-panel am-fade am-in" id="tab3">
			    	<div class="title_v2">
						<div>定制阅读服务</div>
						<div><hr></div>
						<div>
							6688元/年 <br>
							<span>押金800元 </span>
							<span class="fc-7d7d7d">（服务到期后退回）</span>
						</div>
					</div>
					<div class="info">
						<div><strong>适合年龄</strong>：幼儿园大班到小学六年级</div>
						<div class="tp">
							<div><strong>推荐人群</strong>：</div>
							<div>没有太多时间精力关注孩子阅读，需要专业老师个性化服务的家长</div>
						</div>
						<div><strong>服务有效期</strong>：1年</div>
						<div><strong>服务包含</strong>：</div>
						<div class="tp">
							<div>（1）</div>
							<div>综合系统服务</div>
						</div>
						<div class="tp">
							<div>（2）</div>
							<div>每个月个性化阅读计划定制服务（配书、阅读建议、阅读任务、激励机制）</div>
						</div>
						<div class="tp">
							<div>（3）</div>
							<div>1对1专属导师全年跟踪服务，分析测试数据，及时调整阅读计划</div>
						</div>
						<small class="fc-7d7d7d">*费用含12次往返顺丰快递费用</small>
						<div><strong>增值服务</strong>：</div>
						<div class="tp">
							<div>（1）</div>
							<div>可联系老师为孩子设置AR POINTS目标积分 <img v-on:click="showTip(1,$event)" class="doubt" src="{{ url('home/pc/images/home/icon/icon-doubt.png') }}"></div>
						</div>
						<div class="tp">
							<div>（2）</div>
							<div>全年阅读数据报告一份</div>
						</div>
						<div class="tp">
							<div>（3）</div>
							<div>图书指定、预约服务</div>
						</div>
					</div>
					<div class="btn-buy">
							<a href="javascript:void(0)" v-on:click="selectProduct(1)">立即购买</a> 
					</div>
			    </div>
			  </div>
			</div>
		</div>
		<!--AR图书借阅  -->
		<div class="third-tab"  v-show="first_tab==2">
			<div class="am-tabs" data-am-tabs>
			  <ul class="am-tabs-nav am-nav am-nav-tabs">
			    <li class="am-active"><a href="#tab1">AR图书借阅</a></li>
			  </ul>
			
			  <div class="am-tabs-bd"  >
			    <div class="am-tab-panel am-fade am-in am-active" id="tab1">
			      	<div class="title_v2">
						<div>AR图书借阅</div>
						<div><hr></div>
					</div>
					<div class="info">
						<div>
							<div>A <span style="font-size:2rem">6本借阅<span class="fc-main"> 99元 </span></span> （押金<span class="fc-main">300元</span>）</div>
							<div>B <span style="font-size:2rem">12本借阅<span class="fc-main"> 169元</span></span> （押金<span class="fc-main">600元</span>）</div>
						</div>
						<div>
							<div><strong>借阅期限</strong>：40天</div>
							<div><strong>购买条件</strong>：</div>
							<div>（1）服务期内会员</div>
							<div>（2）STAR报告中GE指数不大于6</div>
							<div>	*必须同时满足以上两个条件</div>
							<div><strong>温馨提示</strong>：</div>
							<div class="tp">
								<div>（1）</div>
								<div>老师根据STAR测试数据和孩子阅读偏好科学选书</div>
							</div>
							<div class="tp">
								<div>（2）</div>
								<div>购买后2个工作日内上传书单，手机短信提醒确认书单</div>
							</div>
							<div class="tp">
								<div>（3）</div>
								<div>含往返顺丰快递费</div>
							</div>
							<div class="tp">
								<div>（4）</div>
								<div>还书后在线申请退押金，5个工作日内退回</div>
							</div>
						</div>
					</div>
					<div class="btn-buy">
							<a href="javascript:void(0)" v-on:click="showModal('B')">立即购买</a> 
					</div>
			    </div>
			  </div>
			</div>
		</div>
	</div>
	<!-- 联系我们 -->
	<div id="us">
		<div>
				蕊丁吧，取自READINGBAR音译<br/>
				国内第一家AR系统线上服务平台<br/>
				专注于K12英文阅读兴趣和习惯培养
		</div>
		<div class="text"><div class="icon"><img src="{{ asset('home/pc/images/home/icon/icon-telphone.png') }}"/></div><div class="title">客服电话</div><div class="content">400 625 9800</div></div>
		<div class="text"><div class="icon"><img src="{{ asset('home/pc/images/home/icon/icon-envelope.png') }}"/></div><div class="title">联系邮箱</div><div class="content">biz@readingbar.net</div></div>
		<div class="text"><div class="icon"><img src="{{ asset('home/pc/images/home/icon/icon-clock.png') }}"/></div><div class="title">工作时间</div><div class="content">周一至周五 9:00-18:00</div></div>
		<div class="qrcode">
			<div><img class="img" src="{{ asset('home/pc/images/home/qrcode/qrcode-customer-service.jpg') }}"/><div class="title">客服微信</div></div>
			<div><img class="img" src="{{ asset('home/pc/images/home/qrcode/qrcode-subscribe-number.jpg') }}"/><div class="title">订阅号</div></div>
			<div><img class="img" src="{{ asset('home/pc/images/home/qrcode/qrcode-micro-shop.jpg') }}"/><div class="title">微店</div></div>
		</div>
	</div>
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
		       <div style="text-align: left">
			       <strong>一、 蕊丁吧会员说明</strong><br>
						1. 本服务内容及使用须知适用于蕊丁吧所有注册会员。<br><br>
						
						<strong>二、系统账号使用说明</strong><br>
						1. 会员付费或激活卡密后，系统会自动往注册邮箱发送系统账号。<br>
						2. 系统账号的使用人必须与学员信息一致，不允许与他人共用、外借或转让。<br>
						3. 蕊丁吧会定期对学员测试信息进行审核，如发现异常信息，将进行处理。首次发现异常信息，将与会员联系提出警告。<br>
						   如果出现第二次异常信息，将视为学员的严重违约行为，蕊丁吧将采取直接封号的处理，并不进行退费。<br>
						4. 定制服务会员（只限于定制服务会员）在服务有效期内，可申请最多1次、最长1个月的账号暂时冻结服务，冻结期间，所有服务暂停。<br>
						   解冻后，服务有效期顺延。没有申请则视为正常服务，时间不延续。<br>
						5. 会员使用测试系统账号时，除遵守本使用须知及《蕊丁吧用户协议》外，还应当遵守美国系统账号管理网站的相关规定。<br>
						6. 蕊丁吧有权终止会员使用美国系统账号，但应提前30日通知会员。<br>
						7. 蕊丁吧通知会员停止使用美国系统账号后，可以通过其他替代方案向会员提供服务。<br><br>
						
						<strong>三、 押金、损耗、赔偿及还书</strong><br>
						1.会员在购买定制服务或借阅产品时，需要缴纳图书借阅押金。<br>
						2.蕊丁吧每本书都是精心挑选，从国外引进的，我们希望各位会员能与蕊丁吧一起爱护每一本图书。如学员对图书造成的损耗，需要支付相应的赔偿。具体规定如下：<br>
						2.1 图书如在借阅过程中有轻微损毁，请家长在还书时主动告知，由我们进行修补。<br>
						2.2 若有出现圈点、涂画、撕毁、烧残、水浸、划线、注字、涂抹、卷曲、折皱等但不影响其内容完整，能继续使用的，按污损页数计罚，每页需按照（定价/页码）*2的标准赔偿金。赔偿金额超过书籍定价的，将按书籍定价的1.5倍进行赔偿，已破损的书籍归用户所有。赔偿费用需单独支付（不接受用户自行购买进行赔偿）。<br>
						2.3 出现开胶、撕页或大面积涂写等严重影响书籍正常阅读的，应按书籍定价的1.5倍进行赔偿，已破损的书籍归用户所有。赔偿费用需单独支付（不接受用户自行购买进行赔偿）。<br>
						3.书籍定价<br>
						书籍的价值以每本书的RMB标价为准。<br>
						4.书籍寄回说明<br>
						为方便您能够顺利按时将图书寄回，我们已将顺丰快递单放入盒子中，还书时您只需在签名处签字，并把盒子以及二维码快递单给上门取件的顺丰快递员即可。<br>
						4.1.寄件方式 ：顺丰到付。<br>
						4.2.下单方式：可选择以下三种方式之一。<br>
						电话：拨打“95338”预约上门取件。<br>
						网站：登录 http://www.sf-express.com预约上门取件。<br>
						微信：关注【顺丰速运】公众号，点击“寄快递”中的“收派员上门”。<br>
						4.3.注意事项<br>
						运单产品类型，选择最低运费即可，如北京、天津用户请选择【顺丰标快】；其他地区用户请选择【顺丰特惠】。<br>
						备注：因没有按照说明选择/填写运单信息，导致运费增加的部分，将从押金扣除。<br><br>
						
						
						<strong>四、 退费说明</strong><br>
						1.除定制服务，其他产品付费后不予退费。<br>
						2.仅限于定制服务会员在付费后30日内可申请终止服务并申请退费，蕊丁吧在扣除综合系统服务费及10%服务费用后，将其余费用予以退回，退费后用户可继续享受综合系统服务；<br>
						  付费后超过30日，会员费用不予退回。<br>
						3.定制服务借阅押金在会员归还全部书籍（无破损或丢失）后于15个工作日内退还；普通借阅押金，在会员在线申请退押金后5个工作日内退还。<br>
						4.定制服务到期，应提前或及时续费。如果到期后5日内未续费，也未还书的，将按照每天每本1元收取滞纳金，滞纳金从押金中扣除（滞纳金从逾期第1天开始计算）。<br>
						5.普通借阅服务到期后5日内未还书的，将按照每天每本1元收取滞纳金，滞纳金从押金中扣除（滞纳金从逾期第1天开始计算）。<br>
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
	  
	  <!-- ?提示信息 -->
	  <div class="am-modal am-modal-prompt" tabindex="-1" id="my-prompt">
	  <div class="am-modal-dialog">
	    <div class="am-modal-bd" v-html="msg">
	    </div>
	    <div class="am-modal-footer">
	      <span class="am-modal-btn" data-am-modal-confirm>确认</span>
	    </div>
	  </div>
	</div>
</section>
<script>
new Vue({
	el: 'section',
	data: {
		first_tab:1,
		second_tab:1,
		logged: {!! auth('member')->check()?'true':'false' !!},
		students: {!! $students->toJson() !!},
		products: {!! $products->toJson() !!},
		step:1,
		student_id: null,
		protocol: null,
		product_id: null,
		msg: ''
	},
	methods: {
		setCurrentLRForm: function (c) {
			this.currentLRForm = c;
		},
		changeFirstTab: function (tab) {
			this.first_tab = tab
		},
		changeSecondTab: function (tab) {
			this.second_tab = tab
		},
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
				this.showModalNK();
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
		// 问号提示
		showTip:function (t,e) {
			switch (t){
				case 1: this.msg = "有目标就更有动力！<br/>快联系老师为孩子设置个性化目标积分吧！";break;
				case 2: this.msg = "良心建议半年测一次；频繁测试，数据变化不大，家长容易焦虑，且会引起孩子反感";break;
			}
			$('#my-prompt').modal();
		}
	}
});
</script>
@endsection
<!-- //继承整体布局 -->
